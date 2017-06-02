<?php $this->load->view('admin/theme/message'); ?>

<!-- Main content -->
<section class="content-header">
	<h1 class = 'text-info'><i class="fa fa-list"></i> <?php echo $this->lang->line("Campaign Report");?></h1>
</section>
<section class="content">  
	<div class="row" >
		<div class="col-xs-12">
			<div class="grid_container" style="width:100%; min-height:700px;">
				<table 
				id="tt"  
				class="easyui-datagrid" 
				url="<?php echo base_url()."facebook_ex_campaign/campaign_report_data"; ?>" 

				pagination="true" 
				rownumbers="true" 
				toolbar="#tb" 
				pageSize="15" 
				pageList="[5,10,15,20,50,100]"  
				fit= "true" 
				fitColumns= "true" 
				nowrap= "true" 
				view= "detailview"
				idField="id"
				>
							
					<thead>
						<tr>
							<th field="campaign_name" sortable="true"><?php echo $this->lang->line("Campaign Name")?></th>
							<th field="post_status_formatted" align="center" ><?php echo $this->lang->line("Status")?></th>
							<th field="campaign_type_formatted" align="center" ><?php echo $this->lang->line("Type")?></th>
							<th field="attachment" align="center" ><?php echo $this->lang->line("Attachment")?></th>
							<th field="sent_count" align="center" ><?php echo $this->lang->line("Sent")?></th>
							<th field="report" align="center"  sortable="true">Report</th>
							<th field="edit" align="center" sortable="true">Edit</th>
							<th field="delete" align="center" sortable="true">Delete</th>
							<th field="scheduled_at" sortable="true" align="center"><?php echo $this->lang->line("Scheduled Time")?></th>
							<th field="added_at" align="center"  sortable="true">Created at</th>
							<th field="page_names" sortable="true"><?php echo $this->lang->line("Page Name(s)")?></th>
						</tr>
					</thead>
				</table>                        
			</div>

			<div id="tb" style="padding:3px">

				<?php
					$search_campaign_name  = $this->session->userdata('facebook_ex_conversation_campaign_name');
			        $search_posting_status  = $this->session->userdata('facebook_ex_conversation_posting_status');
			        $search_page_ids  = $this->session->userdata('facebook_ex_conversation_page_ids');
			        $search_scheduled_from = $this->session->userdata('facebook_ex_conversation_scheduled_from');
			        $search_scheduled_to = $this->session->userdata('facebook_ex_conversation_scheduled_to');
				?>
				<div class="row">
					<div class="col-xs-12">
						<a style="margin-bottom: 5px;" class="btn btn-primary" href="<?php echo site_url('facebook_ex_campaign/create_multipage_campaign');?>"  title="<?php echo $this->lang->line("Create New Campaign"); ?>">
						<i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("Create New Campaign"); ?>
						</a><br/>
					</div>
				</div>

				<form class="form-inline" style="margin-top:20px">

					<div class="form-group">
						<input id="search_campaign_name" name="search_campaign_name" value="<?php echo $search_campaign_name;?>" class="form-control" size="20" placeholder="Campaign Name">
					</div>

					<div class="form-group">
						<select name="search_page" id="search_page"  class="form-control">
							<option value="">All Page</option>	
							<?php
								foreach ($page_info as $key => $value) 
								{
									if($value['id'] == $search_page_ids)
									echo "<option selected value='".$value['id']."'>".$value['page_name']."</option>";
									else echo "<option value='".$value['id']."'>".$value['page_name']."</option>";
								}
							?>						
						</select>
					</div>

					<div class="form-group">
						<select name="search_status" id="search_status"  class="form-control">
							<option value="">Status</option>					
							<option <?php if($search_posting_status=="0") echo "selected";?> value="0">Pending</option>					
							<option <?php if($search_posting_status=="1") echo "selected";?> value="1">Processing</option>					
							<option <?php if($search_posting_status=="2") echo "selected";?> value="2">Completed</option>					
						</select>
					</div>
   
					<div class="form-group">
						<input id="scheduled_from" value="<?php echo $search_scheduled_from;?>" name="scheduled_from" class="form-control datepicker" size="20" placeholder="Scheduled from">
					</div>

					<div class="form-group">
						<input id="scheduled_to" value="<?php echo $search_scheduled_to;?>" name="scheduled_to" class="form-control  datepicker" size="20" placeholder="Scheduled to">
					</div>                    

					<button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search campaign");?></button> 				
			</div>  

				</form> 
		</div>
	</div>   
</section>

<script>

	var base_url="<?php echo site_url(); ?>"
    
    $(document.body).on('click','.delete',function(){ 
		var id = $(this).attr('id');
		var ans = confirm("Do you really want to delete this campaign?");
		if(ans)
		{
			$.ajax({
		       type:'POST' ,
		       url: "<?php echo base_url('facebook_ex_campaign/delete_campaign')?>",
		       data: {id:id},
		       success:function(response)
		       { 
		       	if(response=='1')
		       	$j('#tt').datagrid('reload');
		       	else alert("Something went wrong.");
		       }
			});
			
		}
	});


    function doSearch(event)
	{
		event.preventDefault(); 
		$j('#tt').datagrid('load',{
			campaign_name   :     $j('#search_campaign_name').val(),             
			page_ids   		:     $j('#search_page').val(),             
			posting_status  :     $j('#search_status').val(),             
			scheduled_from  :     $j('#scheduled_from').val(),    
			scheduled_to    :     $j('#scheduled_to').val(),         
			is_searched		:     1
		});

	} 

	
</script>



<script>
	

    $j('.datepicker').datetimepicker({
   	theme:'dark',
   	format:'Y-m-d H:i:s',
   	formatDate:'Y-m-d H:i:s'
  	})

  	$(document.body).on('click','.sent_report',function(){
  		var loading = '<br/><img src="'+base_url+'assets/pre-loader/Fading squares2.gif" class="center-block"><br/>';
        $("#sent_report_body").html(loading);
  		$("#sent_report_modal").modal();

  		var id = $(this).attr('cam-id');

  		$.ajax({
	            type:'POST' ,
	            url:"<?php echo site_url();?>facebook_ex_campaign/campaign_sent_status",
	            data:{id:id},
	            success:function(response){    
	            	$("#sent_report_body").html(response);
	            }
	        }); 
  	});


  
  	
</script>



<div class="modal fade" id="sent_report_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-th-list"></i> Campaign Report</h4>
			</div>
			<div class="modal-body" id="sent_report_body">
				
			</div>
		</div>
	</div>
</div>