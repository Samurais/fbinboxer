<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header"></li>  

      <li> <a href="<?php echo site_url()."facebook_ex_dashboard/index"; ?>"> <i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line("dashboard"); ?></span></a></li>

      <?php if($this->session->userdata('user_type') == 'Member'): ?>
        <li><a href="<?php echo site_url()."payment/member_payment_history"; ?>"><i class="fa fa-paypal"></i> <span><?php echo $this->lang->line("Payment"); ?></span> </a></li>
      <?php endif; ?>

      <?php if($this->session->userdata('user_type') == 'Member'): ?>
        <li > <a href="<?php echo site_url()."payment/usage_history"; ?>"> <i class="fa fa-list-ol"></i> <span><?php echo $this->lang->line("usage log"); ?></span></a></li> 
      <?php endif; ?>


      <?php if($this->session->userdata('user_type') == 'Admin'): ?>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-plus"></i> <span><?php echo $this->lang->line("Administration"); ?></span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">


            <li><a href="<?php echo site_url()."admin/user_management"; ?>"><i class="fa fa-user"></i> <?php echo $this->lang->line("User Management"); ?></a></li>
            <li><a href="<?php echo site_url(); ?>admin/notify_members"><i class="fa fa-bell-o"></i> <?php echo $this->lang->line("Send Notification"); ?></a></li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span><?php echo $this->lang->line("Settings"); ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url(); ?>admin_config_email/index"><i class="fa fa-envelope"></i> <?php echo $this->lang->line("Email Settings"); ?></a></li>
                <li><a href="<?php echo site_url(); ?>admin_config/configuration"><i class="fa fa-cog"></i> <?php echo $this->lang->line("General Settings"); ?></a></li>
                <li><a href="<?php echo site_url(); ?>admin_config/purchase_code_configuration"><i class="fa fa-code"></i> <?php echo $this->lang->line("Purchase Code Settings"); ?></a></li>
                <li><a href='<?php echo site_url()."admin_config_ad/ad_config"; ?>'><i class="fa fa-bullhorn"></i> <?php echo $this->lang->line("advertisement settings"); ?></a></li> 
                <li><a href="<?php echo site_url()."admin_config_login/login_config"; ?>"><i class="fa fa-sign-in"></i> <?php echo $this->lang->line("social login settings"); ?></a></li>
                <li><a href='<?php echo site_url()."facebook_rx_config/index"; ?>'><i class="fa fa-facebook-official"></i> <?php echo $this->lang->line("FB Inboxer Settings"); ?></a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-paypal"></i> <span><?php echo $this->lang->line("Payment"); ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>    
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url()."payment/payment_dashboard_admin"; ?>"> <i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Dashboard"); ?></a></li>   
                <li><a href="<?php echo site_url()."payment/package_settings"; ?>"><i class="fa fa-cube"></i> <?php echo $this->lang->line("Package Settings"); ?></a></li>    
                <li><a href="<?php echo site_url()."payment/payment_setting_admin"; ?>"><i class="fa fa-cog"></i> <?php echo $this->lang->line("Payment Settings"); ?></a></li>    
                <li><a href="<?php echo site_url()."payment/admin_payment_history"; ?>"><i class="fa fa-history"></i> <?php echo $this->lang->line("Payment History"); ?></a></li>     
              </ul>
            </li> 
          </ul>
        </li>
      <?php endif; ?> 

      <!-- FB Exciter used same account import as Soci Marketer -->
      <?php if($this->session->userdata("user_type")=="Admin" || in_array(65,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_rx_account_import/index"; ?>"> <i class="fa fa-cloud-download"></i> <span><?php echo $this->lang->line("Import Account"); ?></span></a></li>     
      <?php endif; ?>  

      <?php if($this->session->userdata("user_type")=="Admin" || in_array(76,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_ex_import_lead/index"; ?>"> <i class="fa fa-download"></i> <span><?php echo $this->lang->line("Import Lead"); ?></span></a></li>   
        <li> <a href="<?php echo site_url()."facebook_ex_import_lead/contact_group"; ?>"> <i class="fa fa-group"></i> <span><?php echo $this->lang->line("Lead Group"); ?></span></a></li>    
        <li> <a href="<?php echo site_url()."facebook_ex_import_lead/contact_list"; ?>"> <i class="fa fa-user"></i> <span><?php echo $this->lang->line("Lead List"); ?></span></a></li>  
      <?php endif; ?>


      <?php if($this->session->userdata("user_type")=="Admin" || in_array(76,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_ex_campaign/create_multipage_campaign"; ?>"> <i class="fa fa-clone"></i> <span> <?php echo $this->lang->line("Multi-page Campaign"); ?></span></a></li>    
      <?php endif; ?> 

      <?php if($this->session->userdata("user_type")=="Admin" || in_array(76,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_ex_campaign/create_multigroup_campaign"; ?>"> <i class="fa fa-object-ungroup"></i> <span><?php echo $this->lang->line("Multi-group Campaign"); ?></span></a></li>    
      <?php endif; ?> 

      <?php if($this->session->userdata("user_type")=="Admin" || in_array(76,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_ex_campaign/custom_campaign"; ?>"> <i class="fa fa-random"></i> <span><?php echo $this->lang->line("Custom Campaign"); ?></span></a></li>    
      <?php endif; ?> 

      <?php if($this->session->userdata("user_type")=="Admin" || in_array(76,$this->module_access)) : ?> 
        <li> <a href="<?php echo site_url()."facebook_ex_campaign/campaign_report"; ?>"> <i class="fa fa-th-list"></i> <span><?php echo $this->lang->line("Campaign Report"); ?></span></a></li>    
      <?php endif; ?> 


      <?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, array(77,80,81,69,28)))>0 ) : ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-flash"></i> <span><?php echo $this->lang->line("Lead Generator"); ?></span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>    
          <ul class="treeview-menu"> 
            <?php if($this->session->userdata("user_type")=="Admin" || in_array(80,$this->module_access)) : ?> 
              <li> <a href="<?php echo site_url()."facebook_ex_autoreply/index"; ?>"> <i class="fa fa-reply-all"></i> <span><?php echo $this->lang->line("Enable auto reply"); ?></span></a></li>    
            <?php endif; ?>

            <?php if($this->session->userdata("user_type")=="Admin" || in_array(80,$this->module_access)) : ?> 
              <li> <a href="<?php echo site_url()."facebook_ex_autoreply/all_auto_reply_report"; ?>"> <i class="fa fa-list-ol"></i> <span><?php echo $this->lang->line("Auto reply report"); ?></span></a></li>    
            <?php endif; ?>

            <?php if($this->session->userdata("user_type")=="Admin" || in_array(77,$this->module_access)) : ?> 
              <li> <a href="<?php echo site_url()."facebook_ex_message_button/index"; ?>"> <i class="fa fa-comment"></i> <span><?php echo $this->lang->line("'Send Message' Button"); ?></span></a></li>    
            <?php endif; ?> 

            <?php if($this->session->userdata("user_type")=="Admin" || in_array(81,$this->module_access)) : ?> 
              <li> <a href="<?php echo site_url()."facebook_ex_json_messanger/index"; ?>"> <i class="fa fa-code"></i> <span><?php echo $this->lang->line("Messanger AD JSON script"); ?></span></a></li>    
            <?php endif; ?>


            <?php if($this->session->userdata("user_type")=="Admin" || in_array(69,$this->module_access)) : ?>
              <li> <a href="<?php echo site_url()."facebook_rx_cta_poster/cta_post_list/1"; ?>"> <i class="fa fa-hand-o-up"></i> <span><?php echo $this->lang->line("Call to action Poster"); ?></span></a></li>
            <?php endif; ?>

            <?php if($this->session->userdata('user_type') == 'Admin' || in_array(28,$this->module_access)): ?>
              <li><a href="<?php echo site_url('fb_chat_plugin_custom/index'); ?>"><i class="fa fa-wechat"></i> <span><?php echo $this->lang->line("Facebook Chat Plugin"); ?></span></a></li>
            <?php endif; ?>

          </ul>
        </li>
      <?php endif; ?>

      <!-- Facebook messenger manager tool -->
      <?php if($this->session->userdata("user_type")=="Admin" || ($this->session->userdata("user_type")!="Admin" && (in_array(82,$this->module_access) || in_array(83,$this->module_access))) ): ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-commenting"></i> <span><?php echo $this->lang->line('page inbox & notification'); ?></span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('fb_msg_manager/index'); ?>"><i class="fa fa-cog"></i> <span><?php echo $this->lang->line("settings"); ?></span></a></li>
            <?php if($this->session->userdata('user_type') == 'Admin' || in_array(82,$this->module_access)): ?>
              <li><a href="<?php echo site_url('fb_msg_manager/message_dashboard'); ?>"><i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line("message dashboard"); ?></span></a></li>
            <?php endif; ?>  
            <?php if($this->session->userdata('user_type') == 'Admin' || in_array(83,$this->module_access)): ?>
              <li><a href="<?php echo site_url('fb_msg_manager_notification/index'); ?>"><i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line("notification dashboard"); ?></span></a></li>
            <?php endif; ?>  

          </ul>
        </li> 
      <?php endif; ?>
      <!-- end of Facebook messenger manager tool -->


      <?php if($this->session->userdata("user_type")=="Admin") : ?> 
        <li><a href='<?php echo site_url()."native_api/index"; ?>'><i class="fa fa-clock-o"></i> <span><?php echo $this->lang->line("cron job"); ?></span></a></li>
        <li> <a target="_BLANK" href="<?php echo site_url('documentation/#!/fbexciter_logo'); ?>"> <i class="fa fa-book"></i> <span><?php echo $this->lang->line("user manual"); ?></span></a></li>    
      <?php endif; ?> 

     <li style="margin-bottom:200px">&nbsp;</li>

   </ul>
 </section>
 <!-- /.sidebar -->
</aside>