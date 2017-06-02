<?php

class Paypal_ipn extends CI_Controller
{

    public function __construct()
    {
		parent::__construct();
		$this->load->library('paypal_class');
		$this->load->model('basic');
        set_time_limit(0);
    }
	
	public function ipn_notify()
    {
	
		$payment_info=$this->paypal_class->run_ipn();
		
		$verify_status=$payment_info['verify_status'];
		$first_name=$payment_info['data']['first_name'];
		$last_name=$payment_info['data']['last_name'];
		$buyer_email=$payment_info['data']['payer_email'];
		$receiver_email=$payment_info['data']['receiver_email'];
		$country=$payment_info['data']['address_country'];
		$payment_date=$payment_info['data']['payment_date'];
		$transaction_id=$payment_info['data']['txn_id'];
		$payment_type=$payment_info['data']['payment_type'];
		$payment_amount=$payment_info['data']['mc_gross'];
        $user_id_package_id=explode('_',$payment_info['data']['custom']);
        $user_id=$user_id_package_id[0];
		$invoice_id=$user_id_package_id[1];

        $invoice_data=$this->basic->get_data("crm_invoice",$where=array("where"=>array("id"=>$invoice_data,"user_id"=>$user_id)));
        $price=isset($invoice_data[0]["grand_total"]) ? $invoice_data[0]["grand_total"] : 0;
        $currency=isset($invoice_data[0]["currency"]) ? $invoice_data[0]["currency"] : "USD";
        $time_zone=isset($invoice_data[0]["time_zone"]) ? $invoice_data[0]["time_zone"] : "Europe/Dublin";
        	         
	   
		if($verify_status!="VERIFIED" || $payment_amount<$price){
			exit();
		}
		
		 $insert_data=array
         (
            "verify_status" 	=>$verify_status,
            "first_name"		=>$first_name,
  			"last_name"			=>$last_name,
  			"paypal_email"		=>$buyer_email,
  			"receiver_email" 	=>$receiver_email,
  			"country"			=>$country,
  			"payment_date" 		=>$payment_date,
  			"payment_type"		=>$payment_type,
  			"transaction_id"	=>$transaction_id,
            "user_id"           =>$user_id,
  			"invoice_id"		=>$invoice_id,
  			"paid_amount"	    =>$payment_amount,
            "currency"          =>$currency
        );		

        $this->basic->insert_data('crm_transaction_history', $insert_data);
        

        date_default_timezone_set($time_zone);
        $last_paid_at=date("Y-m-d H:i:s");       
        $update_data=array
        (
            "is_paid"=>"1",
            "last_paid_at"=>$last_paid_at
        );

        $this->basic->update_data("crm_invoice",array("id"=>$invoice_id,"user_id"=>$user_id),$update_data);
	
		$product_short_name = $this->config->item('product_short_name');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $subject = "New Payment Made";
        $where = array();
        $where['where'] = array('id'=>$user_id);
        $user_email = $this->basic->get_data('users',$where,$select='');
        $to = $user_email[0]['email'];
        $user_name = $user_email[0]['name'];
        $message = "Hello {$user_name} , <br/>New payment of <b>{$currency} {$payment_amount}</b> has been made by <b>{$paypal_email}</b> against <b>invoice no. {$invoice_id}</b>.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
        //send mail to user
        $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
	}


	function _mail_sender($from = '', $to = '', $subject = '', $message = '', $mask = "", $html = 0, $smtp = 1)
    {
        if ($from!= '' && $to!= '' && $subject!='' && $message!= '') {
            if (!is_array($to)) {
                $to=array($to);
            }

            if ($smtp == '1') {
                $where2 = array("where" => array('status' => '1'));
                $email_config_details = $this->basic->get_data("email_config", $where2, $select = '', $join = '', $limit = '', $start = '',
                                                        $group_by = '', $num_rows = 0);

                if (count($email_config_details) == 0) {
                    $this->load->library('email');
                } else {
                    foreach ($email_config_details as $send_info) {
                        $send_email = trim($send_info['email_address']);
                        $smtp_host = trim($send_info['smtp_host']);
                        $smtp_port = trim($send_info['smtp_port']);
                        $smtp_user = trim($send_info['smtp_user']);
                        $smtp_password = trim($send_info['smtp_password']);
                    }

            /*****Email Sending Code ******/
                $config = array(
                  'protocol' => 'smtp',
                  'smtp_host' => "{$smtp_host}",
                  'smtp_port' => "{$smtp_port}",
                  'smtp_user' => "{$smtp_user}", // change it to yours
                  'smtp_pass' => "{$smtp_password}", // change it to yours
                  'mailtype' => 'html',
                  'charset' => 'utf-8',
                  'newline' =>  '\r\n',
                  'smtp_timeout' => '30'
                 );

                    $this->load->library('email', $config);
                }
            } /*** End of If Smtp== 1 **/

            if (isset($send_email) && $send_email!= "") {
                $from = $send_email;
            }
            $this->email->from($from, $mask);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($html == 1) {
                $this->email->set_mailtype('html');
            }

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	
	

}

