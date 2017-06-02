<?php

require_once("home.php"); // loading home controller

class facebook_ex_import_lead extends Home
{

    public $user_id;    
    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   
        if($this->session->userdata('user_type') != 'Admin' && !in_array(76,$this->module_access))
        redirect('home/login_page', 'location'); 
        $this->user_id=$this->session->userdata('user_id');

        if($this->session->userdata("facebook_rx_fb_user_info")==0)
        redirect('facebook_rx_account_import/index','refresh');
    
        $this->load->library("fb_rx_login");
        $this->important_feature();
        $this->member_validity();        
    }


    public function index()
    {
      $this->import_lead();
    }
  
    public function import_lead()
    {
        $data['body'] = 'facebook_ex/import_lead';
        $data['page_title'] = $this->lang->line('Import Lead');  
        $facebook_rx_fb_user_info_id  =  $this->session->userdata('facebook_rx_fb_user_info');

        $table_name = "facebook_rx_fb_page_info";
        $where['where'] = array('facebook_rx_fb_user_info_id' => $facebook_rx_fb_user_info_id);
        $page_info = $this->basic->get_data($table_name,$where,'','','','','page_name asc');
        
        $len_page_info = count($page_info); 
        $data['page_info'] = $page_info;        
        $this->_viewcontroller($data);
    }

    public function import_lead_action(){

        $facebook_rx_fb_page_info_id = $_POST['id'];
        $table_name = "facebook_rx_fb_page_info";
        $where['where'] = array('id' => $facebook_rx_fb_page_info_id);
        $facebook_rx_fb_page_info = $this->basic->get_data($table_name,$where);
        $get_concersation_info = $this->fb_rx_login->get_all_conversation_page($facebook_rx_fb_page_info[0]['page_access_token'],$facebook_rx_fb_page_info[0]['page_id']);
        $success = 0;
        $total=0;

        $facebook_rx_fb_user_info_id = $facebook_rx_fb_page_info[0]['facebook_rx_fb_user_info_id']; 
        $db_page_id =  $facebook_rx_fb_page_info[0]['page_id'];
        $db_user_id =  $facebook_rx_fb_page_info[0]['user_id'];

        foreach($get_concersation_info as &$item) 
        {           
            $db_client_id  =  $item['id'];
            $db_client_thread_id  =   $item['thead_id'];
            $db_client_name  =  $this->db->escape($item['name']);
            $db_permission  =  '1';

            $subscribed_at = date("Y-m-d H:i:s");

            $this->basic->execute_complex_query("INSERT IGNORE INTO facebook_rx_conversion_user_list(page_id,user_id,client_thread_id,client_id,client_username,permission,subscribed_at) VALUES('$db_page_id',$db_user_id,'$db_client_thread_id','$db_client_id',$db_client_name,'$db_permission','$subscribed_at');");
            if($this->db->affected_rows() != 0) $success++ ;

            $total++;
        }
        $this->basic->update_data("facebook_rx_fb_page_info",array("page_id"=>$db_page_id,"facebook_rx_fb_user_info_id"=>$facebook_rx_fb_user_info_id),array("last_lead_sync"=>date("Y-m-d H:i:s"),"current_lead_count"=>$total));
        
        $sql = "SELECT count(id) as permission_count FROM `facebook_rx_conversion_user_list` WHERE page_id='$db_page_id' AND permission='1' AND user_id=".$this->user_id;
        $count_data = $this->db->query($sql)->row_array();

        // how many are subscribed and how many are unsubscribed
        $subscribed = isset($count_data["permission_count"]) ? $count_data["permission_count"] : 0;
        $unsubscribed = abs($total - $subscribed); 
        $this->basic->update_data("facebook_rx_fb_page_info",array("page_id"=>$db_page_id,"facebook_rx_fb_user_info_id"=>$facebook_rx_fb_user_info_id),array("current_subscribed_lead_count"=>$subscribed,"current_unsubscribed_lead_count"=>$unsubscribed));
        
        $str = "$success leads has been imported successfully.";
    
        $response =array();
        $response["message"] = $str;
        $response["count"] = $success;

        echo json_encode($response);
    }

    public function user_details_modal(){

        if (empty($_POST['user_page_id'])) {
            die();
        }

        $user_id_and_page_id = explode("-",$_POST['user_page_id']);
        $user_id = $user_id_and_page_id[0];
        $page_id = $user_id_and_page_id[1];

        $table_name = "facebook_rx_conversion_user_list";
        $where['where'] = array('user_id' => $user_id, 'page_id' => $page_id);
        $one_page_user_details = $this->basic->get_data($table_name,$where);

        $html = '<script>
                    $j(document).ready(function() {
                        $("#user_data_for_inbox").DataTable();
                    }); 
                 </script>';
        $html .= "
            <table id='user_data_for_inbox' class='table table-striped table-bordered nowrap' cellspacing='0' width='100%''>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Facebook Link</th>
                    <th>Added at</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($one_page_user_details as $one_user) 
        {
            $html .= "<tr>
                        <td>".$one_user['client_username']."</td>
                        <td><a href='https://www.facebook.com/".$one_user['client_id']."' target='_blank'>"."www.facebook.com/".$one_user['client_id']."</a></td>
                        <td>".date("jS M, y H:i:s",strtotime($one_user['subscribed_at']))."</td><td>";
            if($one_user['permission'] == '1')
            {
                $html .= "<button id ='".$one_user['id']."-".$one_user['permission']."' type='button' class='client_thread_subscribe_unsubscribe btn btn-danger'>unsubscribe</button>";//$one_user['permission'];
            }
            elseif ($one_user['permission'] == '0') 
            {
                $html .= "<button id ='".$one_user['id']."-".$one_user['permission']."' type='button' class='client_thread_subscribe_unsubscribe btn btn-success'>subscribe</button>";
            }
            $html .= "</td>
                    </tr>";
        }
        
        $html .= "</tbody>
                </table>
                ";
        
        echo $html;
    }

    public function client_subscribe_unsubscribe_status_change()
    {
        if (empty($_POST['client_subscribe_unsubscribe_status'])) {
            die();
        }
        $client_subscribe_unsubscribe = array();
        $post_val=$this->input->post('client_subscribe_unsubscribe_status');
        $client_subscribe_unsubscribe = explode("-",$post_val);
        $id = isset($client_subscribe_unsubscribe[0]) ? $client_subscribe_unsubscribe[0]: 0;
        $current_status =  isset($client_subscribe_unsubscribe[1]) ? $client_subscribe_unsubscribe[1]: 0;
        
        if($current_status=="1") $permission="0";
        else $permission="1";

        $client_thread_info = $this->basic->get_data('facebook_rx_conversion_user_list',array('where'=>array('id'=>$id,'user_id'=>$this->user_id)));
        $client_thread_id = $client_thread_info[0]['client_thread_id'];
        $page_id = $client_thread_info[0]['page_id'];

        $where = array
        (
            'client_thread_id' => $client_thread_id,
            'user_id' => $this->user_id
        );
        $login_user_id = $this->user_id;
        $data = array('permission' => $permission);
        if($permission=="0") $data["unsubscribed_at"] = date("Y-m-d H:i:s");
        $response='';
        if($this->basic->update_data('facebook_rx_conversion_user_list', $where, $data))
        {     
            if($permission=="0")
            {
                $response = "<button id ='".$id."-".$permission."' type='button' class='client_thread_subscribe_unsubscribe btn btn-success'>subscribe</button>";

                $this->basic->execute_complex_query("UPDATE facebook_rx_fb_page_info SET current_subscribed_lead_count = current_subscribed_lead_count-1,current_unsubscribed_lead_count = current_unsubscribed_lead_count+1 WHERE user_id = '$login_user_id' AND page_id = '$page_id'");
            }
            else  
            {
                $response = "<button id ='".$id."-".$permission."' type='button' class='client_thread_subscribe_unsubscribe btn btn-danger'>unsubscribe</button>";

                $this->basic->execute_complex_query("UPDATE facebook_rx_fb_page_info SET current_subscribed_lead_count = current_subscribed_lead_count+1,current_unsubscribed_lead_count = current_unsubscribed_lead_count-1 WHERE user_id = '$login_user_id' AND page_id = '$page_id'");
            }
            echo $response;
        }
    }



    public function enable_disable_auto_sync()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(78,$this->module_access))
        redirect('home/login_page', 'location'); 
    
        $page_id =  $this->input->post("page_id");
        $operation =  $this->input->post("operation");
        if($page_id=="" || $operation=="") exit();

        $this->basic->update_data("facebook_rx_fb_page_info",array("page_id"=>$page_id,"user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")),array("auto_sync_lead"=>$operation));


    }



}