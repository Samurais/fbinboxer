<?php $this->load->view('admin/theme/message'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class='fa fa-user'></i> <?php echo $this->lang->line('Lead List'); ?>  </h1>

</section>

<!-- Main content -->
<section class="content">  
  <div class="row" >
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; min-height:600px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."facebook_ex_import_lead/contact_list_data"; ?>" 

            pagination="true" 
            rownumbers="true" 
            toolbar="#tb" 
            pageSize="20" 
            pageList="[5,10,20,50,100,500]"  
            fit= "true" 
            fitColumns= "true" 
            nowrap= "true" 
            view= "detailview"
            idField="id"
            >

            <!-- url is the link to controller function to load grid data -->
            
                <thead>
                    <tr>
                        <th field="id"  checkbox="true"></th>
                        <th field="client_username"  sortable="true" ><?php echo $this->lang->line('Name'); ?></th>                  
                        <th field="contact_type_id"  sortable="true"><?php echo $this->lang->line('Lead Group'); ?></th>                     
                        <th field="page_name"  sortable="true"><?php echo $this->lang->line('Page Name'); ?></th>                     
                        <th field="permission" align="center" formatter="yes_no"  sortable="true"><?php echo $this->lang->line('Subscribed?'); ?></th>                     
                        <th field="view" formatter='action_column'><?php echo $this->lang->line('Edit'); ?></th>    

                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">

            <a class="btn btn-info" id="assign_group">
                <i class="fa fa-group"></i> <?php echo $this->lang->line("Bulk Group Assign"); ?>
            </a>  
            <br/>  
              
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <input id="client_username" name="client_username" value="<?php echo $this->session->userdata('fb_ex_contact_list_first_name'); ?>" class="form-control" size="20" placeholder="<?php echo $this->lang->line('Name'); ?>">
                </div>  
                <div class="form-group">
                    <?php 
                        $contact_type_id['']=$this->lang->line('All Groups');
                        echo form_dropdown('contact_type_id',$contact_type_id,$this->session->userdata('fb_ex_contact_list_contact_type_id'),'class="form-control" id="contact_type_id"');  
                        ?>
                </div>  
                <div class="form-group">
                    <?php 
                        $subscribed_array['']=$this->lang->line('Subscribed & Unsubscibed');
                        $subscribed_array["1"] = 'Only Subscribed';
                        $subscribed_array["0"] = 'Only Unsubscribed';
                        echo form_dropdown('permission_search',$subscribed_array,$this->session->userdata('fb_ex_contact_list_permission_search'),'class="form-control" id="permission_search"');  
                        ?>
                </div>  
            
                <select name="search_page" id="search_page"  class="form-control">
                  <option value="">All Pages</option>  
                  <?php
                    $search_page_id  = $this->session->userdata('fb_ex_contact_list_search_page');
                    foreach ($page_info as $key => $value) 
                    {
                      if($value['page_id'] == $search_page_id)
                      echo "<option selected value='".$value['page_id']."'>".$value['page_name']."</option>";
                      else echo "<option value='".$value['page_id']."'>".$value['page_name']."</option>";
                    }
                  ?>            
                </select>
                
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('Search'); ?></button>     
                      
            </form> 

        </div>        
    </div>
  </div>   
</section>


<script> 

	 $j(function() {
    $( ".datepicker" ).datepicker();
  });      
    var base_url="<?php echo site_url(); ?>";     

    function action_column(value,row,index)
    {             
               
        var edit_url=base_url+'facebook_ex_import_lead/update_contact/'+row.id;
        var delete_url=base_url+'phonebook/delete_contact_action/'+row.id;
        
        var str="";     
      
        str=str+"&nbsp;<a style='cursor:pointer' title='"+'Edit'+"' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";        
        
        return str;
    } 


    $(document.body).on('click','#assign_group',function(){
          var rows = $j('#tt').datagrid('getSelections');
          var info=JSON.stringify(rows);  
          var info_array = JSON.parse(info);
          var selected = info_array.length;
          var upto = 500;
          if(rows=="") 
          {
            alert("You have not selected any lead to assign group. You can choose upto "+upto+" leads at a time.");
            return;
          } 
          if(selected>upto) 
          {
              alert("You can select upto "+upto+" leads. You have selected "+selected+" leads.")
              return;
          }

        $("#assign_group_modal").modal();         
    }); 

    $(document.body).on('click','#assign_group_submit',function(){
  
          var rows = $j('#tt').datagrid('getSelections');
          var info=JSON.stringify(rows);  
          if(rows=="") 
          {
            alert("You have not selected any lead to assign group.");
            return;
          } 
          var count=0;
          var group_id=[];
          $('.contact_group_id:checked').each(function () {
            group_id[count]=$(this).val();
              count++;
          });

          if(count==0) 
          {
            alert("You have not selected any lead group.");
            return;
          } 

          $("#assign_group_submit").html("Please wait...");
          $("#assign_group_submit").addClass("disabled");
          $("#assign_group_message").removeClass("alert alert-success").html("Please Wait...").show();

          $.ajax({
            type:'POST' ,
            url: "<?php echo site_url(); ?>facebook_ex_import_lead/bulk_group_assign",
            data:{info:info,group_id:group_id},
            success:function(response)
            {
             $("#assign_group_submit").html("Assign Group");
             $("#assign_group_submit").removeClass("disabled");
             $("#assign_group_message").addClass("alert alert-success").html("Groups have been assigned successfully.").show();
              location.reload();
            }
          });         
    });

    $("#url_with_email_wise_download_btn").click(function(){
    var base_url="<?php echo base_url(); ?>";
    $('#url_with_email_wise_download_btn').html("<?php echo $this->lang->line('please wait');?>");
    var link = "<?php echo site_url('phonebook/url_with_email_wise_download');?>";
    var rows = $j("#tt").datagrid("getSelections");
    var info=JSON.stringify(rows); 
    if(rows == '')
    {
      $('#url_with_email_wise_download_btn').html('<i class="fa fa-cloud-download"></i>'+"<?php echo $this->lang->line('Export');?>");
      alert("<?php echo $this->lang->line('You have not select any contact.');?>");
      return false;
    }
    $.ajax({
      type:'POST',
      url:link,
      data:{info:info},
      success:function(response)
      {
        if(response!="")         
        {
          response=base_url+response;
          $('#url_with_email_wise_download_btn').html('<i class="fa fa-cloud-download"></i>'+"<?php echo $this->lang->line('Export');?>");
          $('#download_content').html('<i class="fa fa-2x fa-thumbs-o-up" style="color:black"></i><br><br><a href="'+response+'" title="Download" class="btn btn-warning btn-lg" style="width:200px;""><i class="fa fa-cloud-download" style="color:white"></i> <?php echo $this->lang->line('Download');?></a>');
          $('#modal_for_download_url').modal();  
        }      
        else         
        alert("<?php echo $this->lang->line('Something went wrong, please try again.');?>");     
      }
    });
  });   

  function valid_date(value,row,index)
  {
     if(value=="0000-00-00") return "";
     return value;
  }          
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          client_username  :     $j('#client_username').val(),         
          contact_type_id  :     $j('#contact_type_id').val(),         
          permission_search  :     $j('#permission_search').val(),         
          search_page  :     $j('#search_page').val(),         
          is_searched      :      1
        });


    }  

</script>

<!-- Modal for download -->
<div id="modal_for_download_url" class="modal fade">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&#215;</span>
        </button>
        <h4 id="" class="modal-title"><i class="fa fa-cloud-download"></i> <?php echo $this->lang->line('Export Contact (CSV)'); ?></h4>
      </div>

      <div class="modal-body">
        <style>
        .box
        {
          border:1px solid #ccc;  
          margin: 0 auto;
          text-align: center;
          margin-top:10%;
          padding-bottom: 20px;
          background-color: #fffddd;
          color:#000;
        }
        </style>
        <!-- <div class="container"> -->
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
              <div class="box">
                <h2><?php echo $this->lang->line('Your file is ready to download'); ?></h2>
                <span id="download_content"></span>
              </div>    
              
            </div>
          </div>
        <!-- </div>  -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="assign_group_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-group"></i> Select Lead Group</h4>
      </div>
      <div class="modal-body">    
          <div id="assign_group_message" class="text-center"></div> 
          <div>              
           <?php
           foreach ($contact_type_id as $key=>$value) 
           {
               $type =  $value;            
               $type_id = $key;
               if($key=="") continue;
               echo "<label class='checkbox-inline'><input type='checkbox' class='contact_group_id' name='contact_group_id[]' value='{$type_id}'>{$type}</label><br/>";
             }

           ?>
          </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary pull-left" id="assign_group_submit">Assign Group</a>
        <a class="btn btn-default pull-right" data-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>