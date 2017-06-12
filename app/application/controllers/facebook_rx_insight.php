<?php

require_once("home.php"); // loading home controller

class facebook_rx_insight extends Home
{

    public $user_id;    
    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   
        // if($this->session->userdata('user_type') != 'Admin' && !in_array(72,$this->module_access))
        // redirect('home/login_page', 'location'); 
        $this->user_id=$this->session->userdata('user_id');

        if($this->session->userdata("facebook_rx_fb_user_info")==0)
        redirect('facebook_rx_account_import/index','refresh');
    
        set_time_limit(0);
        $this->important_feature();
        $this->member_validity();

        $this->load->library("fb_rx_login");       
    }


    public function index()
    {
    }


    public function video_insight_page_list()
    {
        $data['body'] = 'facebook_rx/insight/video_insight_page_list';
        $data['page_title'] = $this->lang->line('CasterLive - Video Insight');
        $data["fb_page_info"]=$this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info"))));
        $this->_viewcontroller($data);
    }


    public function video_list_grid($page_table_id=0)
    {
        if($page_table_id==0) exit();
        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)),array('page_name'));
        $data['page_name'] = $page_info[0]['page_name'];

        $data['body'] = 'facebook_rx/insight/video_list_grid';
        $data['page_table_id'] = $page_table_id;
        $data['page_title'] = $this->lang->line('CasterLive - Video Insight');
        $this->_viewcontroller($data);
    }


    public function video_list_grid_data($table_id=0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        redirect('home/access_forbidden', 'location');
        

        $page = isset($_POST['page']) ? intval($_POST['page']) : 15;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $video_id = trim($this->input->post("video_id", true));
        $is_searched = $this->input->post('is_searched', true);

        if ($is_searched) 
        {
            $this->session->set_userdata('video_analytics_video_id', $video_id);
        }

        // saving session data to different search parameter variables
        $search_video_id   = $this->session->userdata('video_analytics_video_id');

        $where_simple=array();        
        if ($search_video_id)    $where_simple['video_id like '] = "%".$search_video_id."%";

        $where_simple['page_table_id'] = $table_id;

        $where  = array('where'=>$where_simple);
        $order_by_str=$sort." ".$order;
        $offset = ($page-1)*$rows;
        $result = array();
        $table = "facebook_rx_video_insight";
        $info = $this->basic->get_data($table, $where, $select='', $join='', $limit=$rows, $start=$offset, $order_by=$order_by_str, $group_by='');

        $total_rows_array = $this->basic->count_row($table, $where, $count="id", $join='');
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
    }


    public function video_analytics($id)
    {
        $table_id = $id;
        $table = 'facebook_rx_video_insight';
        $where['where'] = array('facebook_rx_video_insight.id'=>$table_id);
        $join = array('facebook_rx_fb_page_info'=>'facebook_rx_video_insight.page_table_id=facebook_rx_fb_page_info.id,left');
        $select = array('video_id','page_access_token');
        $info = $this->basic->get_data($table,$where,$select,$join);

        $video_id = $info[0]['video_id'];
        $post_access_token = $info[0]['page_access_token'];
        
        $video_analytics = '';
        try
        {
            $video_analytics = $this->fb_rx_login->video_insight($video_id,$post_access_token);
        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          $data['error'] = $error_msg;
        }

        $data['video_analytics'] = $video_analytics;
        $data['body'] = 'facebook_rx/insight/video_analytics';
        $data['page_title'] = $this->lang->line('CasterLive - Video Insight');
        $this->_viewcontroller($data);
    }


    public function video_analytics_display($video_id,$page_table_id)
    {
        $where['where'] = array('id'=>$page_table_id);
        $info = $this->basic->get_data('facebook_rx_fb_page_info',$where);
        $post_access_token = $info['0']['page_access_token'];

        $video_analytics = '';
        try
        {
            $video_analytics = $this->fb_rx_login->video_insight($video_id,$post_access_token);
        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          $data['error'] = $error_msg;
        }

        $data['video_analytics'] = $video_analytics;
        $data['body'] = 'facebook_rx/insight/video_analytics';
        $data['page_title'] = $this->lang->line('CasterLive - Video Insight');
        $this->_viewcontroller($data);
    }


    public function synch_videos_for_page()
    {
        if(!$_POST)
        exit();

        $page_table_id = $this->input->post('page_table_id');
        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));
        $page_id = $page_info[0]['page_id'];
        $page_name = $page_info[0]['page_name'];
        $access_token = $page_info[0]['page_access_token'];

        try
        {
            $video_list = $this->fb_rx_login->get_videolist_from_fb_page($page_id,$access_token);

            if(isset($video_list['data']) && empty($video_list['data'])){
                echo "<h3><div class='alert alert-danger text-center'>There is no video on this page.</div></h3>";
            }
            else if (!isset($video_list['data'])) {
                echo "<h3><div class='alert alert-danger text-center'>Something went wrong, please try again.</div></h3>";
            }
            else
            {
                $data = array();
                foreach($video_list['data'] as $value)
                {
                    if($value['is_crossposting_eligible'] != 1) continue;
                    else
                    {
                        $data['video_id'] = $value['id'];
                        $data['page_name'] = $page_name;
                        $data['description'] = isset($value['description']) ? $value['description'] : '';
                        $data['created_time'] = $value['created_time'];
                        $data['permalink_url'] = "https://www.facebook.com".$value['permalink_url'];
                        $data['picture'] = isset($value['picture']) ? $value['picture'] : '';
                        $data['page_table_id'] = $page_table_id;

                        $where = array();
                        $where['where'] = array(
                            'page_table_id' => $page_table_id,
                            'video_id' => $value['id']
                            );
                        $exist_or_not = $this->basic->get_data('facebook_rx_video_insight',$where);
                        if(empty($exist_or_not))
                        {
                            $this->basic->insert_data('facebook_rx_video_insight', $data);
                        }
                        else
                        {
                            $where = array(
                                'page_table_id' => $page_table_id,
                                'video_id' => $value['id']
                                );
                            $this->basic->update_data('facebook_rx_video_insight',$where,$data);
                        }
                    }
                }
                echo "<h3><div class='alert alert-success text-center'>Videos has been imported successfully.</div></h3>";
            }
            
        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          echo $error_msg;
        }


        

    }


    public function post_insight_page_list()
    {
        $data['body'] = 'facebook_rx/insight/post_insight_page_list';
        $data['page_title'] = $this->lang->line('CasterLive - Post Insight');
        $data["fb_page_info"]=$this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info"))));
        $this->_viewcontroller($data);
    }

    public function synch_posts_for_page()
    {
        if(!$_POST)
        exit();

        $page_table_id = $this->input->post('page_table_id');
        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));
        $page_id = $page_info[0]['page_id'];
        $page_name = $page_info[0]['page_name'];
        $access_token = $page_info[0]['page_access_token'];

        try
        {
            $post_list = $this->fb_rx_login->get_postlist_from_fb_page($page_id,$access_token);

            if(isset($post_list['data']) && empty($post_list['data'])){
                echo "<h3><div class='alert alert-danger text-center'>There is no post on this page.</div></h3>";
            }
            else if(!isset($post_list['data']))
            {
                echo "<h3><div class='alert alert-danger text-center'>Something went wrong, please try again.</div></h3>";
            }
            else
            {
                $data = array();
                foreach($post_list['data'] as $value)
                {
                    $permalink = $value['permalink_url'];
                    $post_type = strpos($permalink, 'videos');
                    if($post_type !== FALSE) $data['post_type'] = 'video';
                    else $data['post_type'] = 'post';

                    $data['post_id'] = $value['id'];
                    $data['page_name'] = $page_name;
                    $data['message'] = isset($value['message']) ? $value['message'] : '';
                    $data['permalink_url'] = isset($value['permalink_url']) ? $value['permalink_url'] : '';
                    $data['picture'] = isset($value['picture']) ? $value['picture'] : '';
                    $data['created_time'] = isset($value['created_time']) ? $value['created_time'] : '';
                    $data['page_table_id'] = $page_table_id;

                    $where = array();
                    $where['where'] = array(
                        'page_table_id' => $page_table_id,
                        'post_id' => $value['id']
                        );
                    $exist_or_not = $this->basic->get_data('facebook_rx_post_insight',$where);
                    if(empty($exist_or_not))
                    {
                        $this->basic->insert_data('facebook_rx_post_insight', $data);
                    }
                    else
                    {
                        $where = array(
                            'page_table_id' => $page_table_id,
                            'post_id' => $value['id']
                            );
                        $this->basic->update_data('facebook_rx_post_insight',$where,$data);
                    }                
                }
                echo "<h3><div class='alert alert-success text-center'>Posts has been imported successfully.</div></h3>";
            }

        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          echo $error_msg;
        }

        

    }


    public function post_list_grid($page_table_id=0)
    {
        if($page_table_id==0) exit();
        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)),array('page_name'));
        $data['page_name'] = $page_info[0]['page_name'];

        $data['body'] = 'facebook_rx/insight/post_list_grid';
        $data['page_table_id'] = $page_table_id;
        $data['page_title'] = $this->lang->line('CasterLive - Post Insight');
        $this->_viewcontroller($data);
    }


    public function post_list_grid_data($table_id=0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        redirect('home/access_forbidden', 'location');
        

        $page = isset($_POST['page']) ? intval($_POST['page']) : 15;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $video_id = trim($this->input->post("post_id", true));
        $is_searched = $this->input->post('is_searched', true);

        if ($is_searched) 
        {
            $this->session->set_userdata('post_analytics_video_id', $video_id);
        }

        // saving session data to different search parameter variables
        $search_video_id   = $this->session->userdata('post_analytics_video_id');

        $where_simple=array();        
        if ($search_video_id)    $where_simple['post_id like '] = "%".$search_video_id."%";

        $where_simple['page_table_id'] = $table_id;

        $where  = array('where'=>$where_simple);
        $order_by_str=$sort." ".$order;
        $offset = ($page-1)*$rows;
        $result = array();
        $table = "facebook_rx_post_insight";
        $info = $this->basic->get_data($table, $where, $select='', $join='', $limit=$rows, $start=$offset, $order_by=$order_by_str, $group_by='');

        $total_rows_array = $this->basic->count_row($table, $where, $count="id", $join='');
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
    }


    public function post_analytics($id)
    {
        $table_id = $id;
        $table = 'facebook_rx_post_insight';
        $where['where'] = array('facebook_rx_post_insight.id'=>$table_id);
        $join = array('facebook_rx_fb_page_info'=>'facebook_rx_post_insight.page_table_id=facebook_rx_fb_page_info.id,left');
        $select = array('post_id','page_access_token');
        $info = $this->basic->get_data($table,$where,$select,$join);

        $post_id = $info[0]['post_id'];
        $post_access_token = $info[0]['page_access_token'];

        // echo $post_id."<br>";
        // echo $post_access_token;
        // exit();

        $post_analytics = '';
        try
        {
            $post_analytics = $this->fb_rx_login->post_insight($post_id,$post_access_token);
        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          $data['error'] = $error_msg;
        }

        $data['post_analytics'] = $post_analytics;
        $data['body'] = 'facebook_rx/insight/post_analytics';
        $data['page_title'] = $this->lang->line('CasterLive - Post Insight');
        $this->_viewcontroller($data);
    }


    public function post_analytics_display($post_id,$page_table_id,$live=0)
    {
        $where['where'] = array('id'=>$page_table_id);
        $info = $this->basic->get_data('facebook_rx_fb_page_info',$where);
        $post_access_token = $info['0']['page_access_token'];

        if($live==1)
        {
            $page_id = $info['0']['page_id'];
            $post_id = $page_id."_".$post_id;
        }

        $post_analytics = '';
        try
        {
            $post_analytics = $this->fb_rx_login->post_insight($post_id,$post_access_token);
        }
        catch(Exception $e) 
        {
          $error_msg = "<i class='fa fa-remove'></i> ".$e->getMessage();
          $data['error'] = $error_msg;
        }

        $data['post_analytics'] = $post_analytics;
        $data['body'] = 'facebook_rx/insight/post_analytics';
        $data['page_title'] = $this->lang->line('CasterLive - Post Insight');
        $this->_viewcontroller($data);
    }





     public function page_insight($table_name='',$table_id=0)
    {
        if($table_id==0) exit();
        $where['where'] = array('id'=>$table_id,'user_id'=>$this->user_id);
        $page_info = $this->basic->get_data($table_name,$where);
        $data['cover_image'] = $page_info[0]['page_cover'];
        $data['profile_image'] = $page_info[0]['page_profile'];
        $access_token = $page_info[0]['page_access_token'];
        $page_id = $page_info[0]['page_id'];

        $metrics = "insights/page_storytellers_by_story_type/day";
        $page_storytellers_by_story_type = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $i = 0;
        $page_storytellers_by_story_type_description = isset($page_storytellers_by_story_type[0]['description']) ? $page_storytellers_by_story_type[0]['description'] : "";

        $temp= isset($page_storytellers_by_story_type[0]['values']) ? $page_storytellers_by_story_type[0]['values'] : array();
        $page_storytellers_by_story_type_data=array();
        $page_storytellers_by_story_type_data=array();
        foreach($temp as $value)
        {
            $date = (array)$value['end_time'];
            $page_storytellers_by_story_type_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
            $page_storytellers_by_story_type_data[$i]['fan'] = $value['value']['fan'];
            $page_storytellers_by_story_type_data[$i]['user post'] = $value['value']['user post'];
            $page_storytellers_by_story_type_data[$i]['page post'] = $value['value']['page post'];
            $page_storytellers_by_story_type_data[$i]['coupon'] = $value['value']['coupon'];
            $page_storytellers_by_story_type_data[$i]['mention'] = $value['value']['mention'];
            $page_storytellers_by_story_type_data[$i]['checkin'] = $value['value']['checkin'];
            $page_storytellers_by_story_type_data[$i]['question'] = $value['value']['question'];
            $page_storytellers_by_story_type_data[$i]['event'] = $value['value']['event'];
            $page_storytellers_by_story_type_data[$i]['other'] = $value['value']['other'];
            $i++;
        }
        $data['page_storytellers_by_story_type_description'] = $page_storytellers_by_story_type_description;
        $data['page_storytellers_by_story_type_data'] = json_encode($page_storytellers_by_story_type_data);



        $metrics = "insights/page_impressions_by_paid_non_paid/day";
        $page_impression_paid_vs_organic = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_impression_paid_vs_organic_description = isset($page_impression_paid_vs_organic[0]['description']) ? $page_impression_paid_vs_organic[0]['description'] : "";

        $temp2 = isset($page_impression_paid_vs_organic[0]['values']) ? $page_impression_paid_vs_organic[0]['values'] : array();
        $page_impression_paid_vs_organic_data=array();
        foreach($temp2 as $value)
        {
            $date = (array)$value['end_time'];
            $page_impression_paid_vs_organic_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
            $page_impression_paid_vs_organic_data[$i]['paid'] = $value['value']['paid'];
            $page_impression_paid_vs_organic_data[$i]['organic'] = $value['value']['unpaid'];
            $i++;
        }
        $data['page_impression_paid_vs_organic_description'] = $page_impression_paid_vs_organic_description;
        $data['page_impression_paid_vs_organic_data'] = json_encode($page_impression_paid_vs_organic_data);




        $metrics = "insights/page_impressions_organic/day";
        $page_impressions_organic = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_impression_paid_vs_organic_description = '';
        if(isset($page_impressions_organic[0]['description']))
            $page_impression_paid_vs_organic_description = $page_impressions_organic[0]['description'];
        
        $temp3 = isset($page_impressions_organic[0]['values']) ? $page_impressions_organic[0]['values'] : array();
        $page_impressions_organic_data=array();
        foreach($temp3 as $value)
        {
            $date = (array)$value['end_time'];
            $page_impressions_organic_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
            $page_impressions_organic_data[$i]['organic'] = $value['value'];
            $i++;
        }
        $data['page_impressions_organic_description'] = $page_impression_paid_vs_organic_description;
        $data['page_impressions_organic_data'] = json_encode($page_impressions_organic_data);





        $metrics = "insights/page_storytellers_by_country/day";
        $page_storytellers_by_country = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        // $page_storytellers_by_country_description = $page_storytellers_by_country[0]['description'];
    

        $test = isset($page_storytellers_by_country[0]['values']) ? $page_storytellers_by_country[0]['values']:array();
        $page_storytellers_by_country_data = array();
        $page_storytellers_by_country_data_temp = array();
        if(!empty($test)){            
            for($i=0;$i<count($test);$i++){
                $aa = isset($test[$i]['value'])? $test[$i]['value']:array();
                foreach(array_keys($aa+$page_storytellers_by_country_data_temp) as $value)
                {
                    $page_storytellers_by_country_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_storytellers_by_country_data_temp[$value]) ? $page_storytellers_by_country_data_temp[$value] : 0);
                }
            }
        }

        $country_names = $this->get_country_names();
        $page_storyteller_country_list = '';
        $colors_array = array("#FF8B6B","#D75EF2","#78ED78","#D31319","#798C0E","#FC749F","#D3C421","#1DAF92","#5832BA","#FC5B20","#EDED28","#E27263","#E5C77B","#B7F93B","#A81538", "#087F24","#9040CE","#872904","#DD5D18","#FBFF0F");
        if(!empty($page_storytellers_by_country_data_temp)){
            $i = 0;
            $j = 0;
            foreach($page_storytellers_by_country_data_temp as $key=>$value){
                if($key=='GB') $key='UK';
                $country = isset($country_names[$key])?$country_names[$key]:$key;
                $page_storytellers_by_country_data[$i] = array(
                    'value' => $value,
                    'color' => $colors_array[$j],
                    'highlight' => $colors_array[$j],
                    'label' => $country
                    );
                $page_storyteller_country_list .= '<li><i class="fa fa-circle-o" style="color: '.$colors_array[$j].';"></i> '.$country.' : '.$value.'</li>';
                $i++;
                $j++;
                if($j==19) $j=0;
            }
        }
        $data['page_storytellers_by_country_description'] = "The Number of People Talking About the Page by User Country (Unique Users) [Last 28 days]";
        $data['page_storyteller_country_list'] = $page_storyteller_country_list;
        $data['page_storytellers_by_country_data'] = json_encode($page_storytellers_by_country_data);





        $metrics = "insights/page_impressions_by_country_unique/day";
        $page_reach_by_user_country = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test2 = isset($page_reach_by_user_country[0]['values']) ? $page_reach_by_user_country[0]['values']:array();
        $page_reach_by_user_country_data = array();
        $page_reach_by_user_country_data_temp = array();
        if(!empty($test2)){            
            for($i=0;$i<count($test2);$i++){
                $aa = isset($test2[$i]['value'])? $test2[$i]['value']:array();
                foreach(array_keys($aa+$page_reach_by_user_country_data_temp) as $value)
                {
                    $page_reach_by_user_country_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_reach_by_user_country_data_temp[$value]) ? $page_reach_by_user_country_data_temp[$value] : 0);
                }
            }
        }

        $page_reach_country_list = '';
        $colors_array = array("#FF8B6B","#D75EF2","#78ED78","#D31319","#DD5D18","#FC749F","#FBFF0F","#1DAF92","#A81538", "#087F24","#9040CE","#872904","#798C0E","#D3C421","#5832BA","#FC5B20","#EDED28","#E27263","#E5C77B","#B7F93B");
        $colors_array = array_reverse($colors_array);
        if(!empty($page_reach_by_user_country_data_temp)){
            $i = 0;
            $j = 0;
            foreach($page_reach_by_user_country_data_temp as $key=>$value){
                if($key=='GB') $key='UK';
                $country = isset($country_names[$key])?$country_names[$key]:$key;
                $page_reach_by_user_country_data[$i] = array(
                    'value' => $value,
                    'color' => $colors_array[$j],
                    'highlight' => $colors_array[$j],
                    'label' => $country
                    );
                $page_reach_country_list .= '<li><i class="fa fa-circle-o" style="color: '.$colors_array[$j].';"></i> '.$country.' : '.$value.'</li>';
                $i++;
                $j++;
                if($j==19) $j=0;
            }
        }
        
        $data['page_reach_by_user_country_description'] = "Total Page Reach by user country. (Unique Users) [Last 28 days]";
        $data['page_reach_country_list'] = $page_reach_country_list;
        $data['page_reach_by_user_country_data'] = json_encode($page_reach_by_user_country_data);

        $metrics = "insights/page_impressions_by_city_unique/day";
        $page_reach_by_user_city = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test3 = isset($page_reach_by_user_city[0]['values']) ? $page_reach_by_user_city[0]['values']:array();
        $page_reach_by_user_city_data = '';
        $page_reach_by_user_city_data_temp = array();
        if(!empty($test3)){            
            for($i=0;$i<count($test3);$i++){
                $aa = isset($test3[$i]['value'])? $test3[$i]['value']:array();
                foreach(array_keys($aa+$page_reach_by_user_city_data_temp) as $value)
                {
                    $page_reach_by_user_city_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_reach_by_user_city_data_temp[$value]) ? $page_reach_by_user_city_data_temp[$value] : 0);
                }
            }
        }
        $page_reach_by_user_city_data = '<table class="table table-hover table-stripped"><tr><th>SL</th><th>City</th><th>Total</th></tr>';
        $i = 0;
        if(!empty($page_reach_by_user_city_data_temp)){
            foreach($page_reach_by_user_city_data_temp as $key=>$value){
                $i++;
                $page_reach_by_user_city_data .= '<tr><td>'.$i.'</td><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
        }
        $page_reach_by_user_city_data .= '</table>';
        $data['page_reach_by_user_city_description'] = "Total Page Reach by user city. (Unique Users) [Last 28 days]";
        $data['page_reach_by_user_city_data'] = $page_reach_by_user_city_data;




        $metrics = "insights/page_storytellers_by_city/day";
        $page_storyteller_by_user_city = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test4 = isset($page_storyteller_by_user_city[0]['values']) ? $page_storyteller_by_user_city[0]['values']:array();
        $page_storyteller_by_user_city_data = '';
        $page_storyteller_by_user_city_data_temp = array();
        if(!empty($test4)){            
            for($i=0;$i<count($test4);$i++){
                $aa = isset($test4[$i]['value'])? $test4[$i]['value']:array();
                foreach(array_keys($aa+$page_storyteller_by_user_city_data_temp) as $value)
                {
                    $page_storyteller_by_user_city_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_storyteller_by_user_city_data_temp[$value]) ? $page_storyteller_by_user_city_data_temp[$value] : 0);
                }
            }
        }
        $page_storyteller_by_user_city_data = '<table class="table table-hover table-striped"><tr><th>SL</th><th>City</th><th>Total</th></tr>';
        $i = 0;
        if(!empty($page_storyteller_by_user_city_data_temp)){
            foreach($page_storyteller_by_user_city_data_temp as $key=>$value){
                $i++;
                $page_storyteller_by_user_city_data .= '<tr><td>'.$i.'</td><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
        }
        $page_storyteller_by_user_city_data .= '</table>';
        $data['page_storyteller_by_user_city_description'] = "The number of People Talking About the Page by user city. (Unique Users) [Last 28 Days]";
        $data['page_storyteller_by_user_city_data'] = $page_storyteller_by_user_city_data;




        $metrics = "insights/page_engaged_users/day";
        $page_engaged_user = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_engaged_user_description = '';
        $page_engaged_user_data = array();
        if(isset($page_engaged_user[0]['description']))
            $page_engaged_user_description = $page_engaged_user[0]['description'];
        
        if(isset($page_engaged_user[0]['values']))
        {

            foreach($page_engaged_user[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_engaged_user_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_engaged_user_data[$i]['value'] = $value['value'];
                $i++;
            }
        }
        $data['page_engaged_user_description'] = $page_engaged_user_description;
        $data['page_engaged_user_data'] = json_encode($page_engaged_user_data);




        $metrics = "insights/page_consumptions_by_consumption_type_unique/day";
        $page_consumptions = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_consumptions_description = '';
        $page_consumptions_data = array();
        if(isset($page_consumptions[0]['description']))
            $page_consumptions_description = $page_consumptions[0]['description'];
        
        if(isset($page_consumptions[0]['values']))
        {

            foreach($page_consumptions[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_consumptions_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_consumptions_data[$i]['other clicks'] = $value['value']['other clicks'];
                $page_consumptions_data[$i]['link clicks'] = $value['value']['link clicks'];
                $page_consumptions_data[$i]['photo view'] = $value['value']['photo view'];
                $page_consumptions_data[$i]['video play'] = $value['value']['video play'];
                $i++;
            }
        }
        $data['page_consumptions_description'] = $page_consumptions_description;
        $data['page_consumptions_data'] = json_encode($page_consumptions_data);




        $metrics = "insights/page_positive_feedback_by_type_unique/day";
        $page_positive_feedback_by_type = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_positive_feedback_by_type_description = '';
        $page_positive_feedback_by_type_data = array();
        if(isset($page_positive_feedback_by_type[0]['description']))
            $page_positive_feedback_by_type_description = $page_positive_feedback_by_type[0]['description'];
        
        if(isset($page_positive_feedback_by_type[0]['values']))
        {

            foreach($page_positive_feedback_by_type[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_positive_feedback_by_type_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_positive_feedback_by_type_data[$i]['answer'] = $value['value']['answer'];
                $page_positive_feedback_by_type_data[$i]['claim'] = $value['value']['claim'];
                $page_positive_feedback_by_type_data[$i]['comment'] = $value['value']['comment'];
                $page_positive_feedback_by_type_data[$i]['like'] = $value['value']['like'];
                $page_positive_feedback_by_type_data[$i]['link'] = $value['value']['link'];
                $page_positive_feedback_by_type_data[$i]['rsvp'] = isset($value['value']['rsvp']) ? $value['value']['rsvp'] : 0;
                $i++;
            }
        }
        $data['page_positive_feedback_by_type_description'] = $page_positive_feedback_by_type_description;
        $data['page_positive_feedback_by_type_data'] = json_encode($page_positive_feedback_by_type_data);




        $metrics = "insights/page_negative_feedback_by_type/day";
        $page_negative_feedback_by_type = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_negative_feedback_by_type_description = '';
        $page_negative_feedback_by_type_data = array();
        if(isset($page_negative_feedback_by_type[0]['description']))
            $page_negative_feedback_by_type_description = $page_negative_feedback_by_type[0]['description'];
        
        if(isset($page_negative_feedback_by_type[0]['values']))
        {

            foreach($page_negative_feedback_by_type[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_negative_feedback_by_type_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_negative_feedback_by_type_data[$i]['hide_clicks'] = $value['value']['hide_clicks'];
                $page_negative_feedback_by_type_data[$i]['hide_all_clicks'] = $value['value']['hide_all_clicks'];
                $page_negative_feedback_by_type_data[$i]['report_spam_clicks'] = $value['value']['report_spam_clicks'];
                $page_negative_feedback_by_type_data[$i]['unlike_page_clicks'] = $value['value']['unlike_page_clicks'];
                $page_negative_feedback_by_type_data[$i]['xbutton_clicks'] = $value['value']['xbutton_clicks'];
                $i++;
            }
        }
        $data['page_negative_feedback_by_type_description'] = $page_negative_feedback_by_type_description;
        $data['page_negative_feedback_by_type_data'] = json_encode($page_negative_feedback_by_type_data);



        $metrics = "insights/page_fans_online_per_day/day";
        $page_fans_online_per_day = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_fans_online_per_day_description = 'The number of people who liked your Page and who were online on the specified day. (Unique Users)';
        $page_fans_online_per_day_data = array();
        
        if(isset($page_fans_online_per_day[0]['values']))
        {

            foreach($page_fans_online_per_day[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_fans_online_per_day_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_fans_online_per_day_data[$i]['value'] = isset($value['value'])?$value['value']:0;
                $i++;
            }
        }
        $data['page_fans_online_per_day_description'] = $page_fans_online_per_day_description;
        $data['page_fans_online_per_day_data'] = json_encode($page_fans_online_per_day_data);





        $metrics = "insights/page_fan_adds/day";
        $page_fan_adds = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $metrics = "insights/page_fan_removes/day";
        $page_fan_removes = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $page_fans_adds_and_remove_data = array();
        
        if(isset($page_fan_adds[0]['values']) && isset($page_fan_removes[0]['values']))
        {

            $i = 0;
            foreach($page_fan_adds[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_fans_adds_and_remove_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_fans_adds_and_remove_data[$i]['adds'] = $value['value'];
                $i++;
            }

            $j = 0;
            foreach($page_fan_removes[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_fans_adds_and_remove_data[$j]['removes'] = $value['value'];
                $j++;
            }
        }
        $data['page_fans_adds_and_remove_data'] = json_encode($page_fans_adds_and_remove_data);




        $metrics = "insights/page_fans_by_like_source/day";
        $page_fans_by_like_source = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test2 = isset($page_fans_by_like_source[0]['values']) ? $page_fans_by_like_source[0]['values']:array();

        $page_fans_by_like_source_data = array();
        $page_fans_by_like_source_data_temp = array();
        if(!empty($test2)){            
            for($i=0;$i<count($test2);$i++){
                $aa = isset($test2[$i]['value'])? $test2[$i]['value']:array();
                foreach(array_keys($aa+$page_fans_by_like_source_data_temp) as $value)
                {
                    $page_fans_by_like_source_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_fans_by_like_source_data_temp[$value]) ? $page_fans_by_like_source_data_temp[$value] : 0);
                }
            }
        }

        $page_fans_by_like_source_list = '';
        $colors_array = array("#FC749F","#D3C421","#1DAF92","#5832BA","#FC5B20","#EDED28","#E27263","#E5C77B","#B7F93B","#A81538", "#087F24","#9040CE","#872904","#DD5D18","#FBFF0F");
        if(!empty($page_fans_by_like_source_data_temp)){
            $i = 0;
            $j = 0;
            foreach($page_fans_by_like_source_data_temp as $key=>$value){
                $key = ucfirst(str_replace('_',' ',$key));
                $page_fans_by_like_source_data[$i] = array(
                    'value' => $value,
                    'color' => $colors_array[$j],
                    'highlight' => $colors_array[$j],
                    'label' => $key
                    );
                $page_fans_by_like_source_list .= '<li><i class="fa fa-circle-o" style="color: '.$colors_array[$j].';"></i> '.$key.' : '.$value.'</li>';
                $i++;
                $j++;
                if($i==10) $j=0;
            }
        }
        $data['page_fans_by_like_source_description'] = "This is a breakdown of the number of Page likes from the most common places where people can like your Page. (Total Count) [Last 28 days]";
        $data['page_fans_by_like_source_list'] = $page_fans_by_like_source_list;
        $data['page_fans_by_like_source_data'] = json_encode($page_fans_by_like_source_data);




        $metrics = "insights/page_posts_impressions/day";
        $page_posts_impressions = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $i = 0;
        $page_posts_impressions_description = 'Daily: The number of impressions that came from all of your posts. (Total Count)';
        $page_posts_impressions_data = array();
        
        if(isset($page_posts_impressions[0]['values']))
        {

            foreach($page_posts_impressions[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_posts_impressions_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_posts_impressions_data[$i]['value'] = $value['value'];
                $i++;
            }
        }
        $data['page_posts_impressions_description'] = $page_posts_impressions_description;
        $data['page_posts_impressions_data'] = json_encode($page_posts_impressions_data);



        $metrics = "insights/page_posts_impressions_paid/day";
        $page_posts_impressions_paid = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $metrics = "insights/page_posts_impressions_organic/day";
        $page_posts_impressions_organic = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);
        $page_post_impression_paid_vs_organic_data = array();
        
        if(isset($page_posts_impressions_paid[0]['values']) && isset($page_posts_impressions_organic[0]['values']))
        {

            $i = 0;
            foreach($page_posts_impressions_paid[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_post_impression_paid_vs_organic_data[$i]['date'] = date("Y-m-d",strtotime($date['date']));
                $page_post_impression_paid_vs_organic_data[$i]['paid'] = $value['value'];
                $i++;
            }

            $j = 0;
            foreach($page_posts_impressions_organic[0]['values'] as $value)
            {
                $date = (array)$value['end_time'];
                $page_post_impression_paid_vs_organic_data[$j]['organic'] = $value['value'];
                $j++;
            }
        }
        $data['page_post_impression_pais_vs_organic_description'] = "Paid Impression : The number of impressions of your Page posts in an Ad or Sponsored Story. (Total Count) <br/> Organic Impression : The number of impressions of your posts in News Feed or ticker or on your Page. (Total Count)";
        $data['page_post_impression_paid_vs_organic_data'] = json_encode($page_post_impression_paid_vs_organic_data);




        $metrics = "insights/page_tab_views_login_top_unique/day";
        $page_tab_views = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test5 = isset($page_tab_views[0]['values']) ? $page_tab_views[0]['values']:array();
        $page_tab_views_data = '';
        $page_tab_views_data_temp = array();
        if(!empty($test5)){            
            for($i=0;$i<count($test5);$i++){
                $aa =isset($test5[$i]['value'])?$test5[$i]['value']:array();
                foreach(array_keys($aa+$page_tab_views_data_temp) as $value)
                {
                    $page_tab_views_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_tab_views_data_temp[$value]) ? $page_tab_views_data_temp[$value] : 0);
                }
            }
        }
        $page_tab_views_data = '<table class="table table-hover table-striped"><tr><th>SL</th><th>Tab</th><th>Views</th></tr>';
        $i = 0;
        if(!empty($page_tab_views_data_temp)){
            foreach($page_tab_views_data_temp as $key=>$value){
                $i++;
                $page_tab_views_data .= '<tr><td>'.$i.'</td><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
        }
        $page_tab_views_data .= '</table>';
        $data['page_tab_views_description'] = "Tabs on your Page that were viewed when logged-in users visited your Page. (Unique Users) [Last 28 Days]";
        $data['page_tab_views_data'] = $page_tab_views_data;




        $metrics = "insights/page_views_external_referrals/day";
        $page_views_external_referrals = $this->fb_rx_login->get_page_insight_info($access_token,$metrics,$page_id);

        $test6 = isset($page_views_external_referrals[0]['values']) ? $page_views_external_referrals[0]['values']:array();
        $page_views_external_referrals_data = '';
        $page_views_external_referrals_data_temp = array();
        if(!empty($test6)){            
            for($i=0;$i<count($test6);$i++){
                $aa = isset($test6[$i]['value']) ?$test6[$i]['value']:array();
                foreach(array_keys($aa+$page_views_external_referrals_data_temp) as $value)
                {
                    $page_views_external_referrals_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($page_views_external_referrals_data_temp[$value]) ? $page_views_external_referrals_data_temp[$value] : 0);
                }
            }
        }
        $page_views_external_referrals_data = '<table class="table table-hover table-striped"><tr><th>SL</th><th>Referrar</th><th>Views</th></tr>';
        $i = 0;
        if(!empty($page_views_external_referrals_data_temp)){
            foreach($page_views_external_referrals_data_temp as $key=>$value){
                $i++;
                $page_views_external_referrals_data .= '<tr><td>'.$i.'</td><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
        }
        $page_views_external_referrals_data .= '</table>';
        $data['page_views_external_referrals_description'] = "Top referring external domains sending traffic to your Page (Total Count) [Last 28 Days]";
        $data['page_views_external_referrals_data'] = $page_views_external_referrals_data;




        $data['body'] = "facebook_rx/insight/page_statistics";
        $data['page_title'] = $this->lang->line('page statistics');
        $this->_viewcontroller($data);
    }






}