<?php


require_once("home.php"); // loading home controller

/**
* @category controller
* class Admin
*/

class update extends Home
{
      
    public function __construct()
    {
        parent::__construct();     
        $this->upload_path = realpath(APPPATH . '../upload');
        $this->user_id=$this->session->userdata('user_id');
        set_time_limit(0);
    }


    public function index()
    {
        $this->v_1_1to2_0();
    }


    function v_1_1to2_0()
    {
        // writting client js
        $client_js_content=file_get_contents('js/my_chat_custom.js');
        $client_js_content_new=str_replace("base_url_replace/", site_url(), $client_js_content);
        file_put_contents('js/my_chat_custom.js', $client_js_content_new, LOCK_EX);
        // writting client js
                
        $lines="ALTER TABLE `facebook_ex_autoreply` ADD `comment_reply_enabled` ENUM('no','yes') NOT NULL AFTER `reply_type`;
                ALTER TABLE `facebook_ex_autoreply` ADD `multiple_reply` ENUM('no','yes') NOT NULL AFTER `reply_type`;
                ALTER TABLE `facebook_ex_autoreply` ADD `auto_like_comment` ENUM('no','yes') NOT NULL AFTER `reply_type`;

                ALTER TABLE `facebook_rx_conversion_user_list` ADD `contact_group_id` VARCHAR(255) NOT NULL AFTER `page_id`;
                ALTER TABLE `facebook_rx_conversion_user_list` DROP INDEX `user_id`, ADD INDEX `user_id` (`contact_group_id`) USING BTREE;

                ALTER TABLE `facebook_ex_conversation_campaign` CHANGE `campaign_type` `campaign_type` ENUM('page-wise','lead-wise','group-wise') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'page-wise';
                ALTER TABLE `facebook_ex_conversation_campaign` ADD `group_ids` TEXT NOT NULL COMMENT 'comma seperated group ids if group wise' AFTER `user_id`;

                CREATE TABLE IF NOT EXISTS `facebook_rx_conversion_contact_group` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `group_name` varchar(255) NOT NULL,
                  `user_id` int(11) NOT NULL,
                  `deleted` enum('0','1') DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";


       
        // Loop through each line

        $lines=explode(";", $lines);
        $count=0;
        foreach ($lines as $line) 
        {
            $count++;      
            $this->db->query($line);
        }
        echo $this->config->item('product_short_name')." has been updated to v2.0 successfully.".$count." queries executed.";
    }



    function delete_update()
    {
        unlink(APPPATH."controllers/update.php");
    }
 


}
