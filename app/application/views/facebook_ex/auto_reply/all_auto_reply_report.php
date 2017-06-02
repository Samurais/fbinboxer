<!-- Main content -->
<section class="content-header">
	<h1 class = 'text-info'> <i class='fa fa-reply-all'></i> Auto Private Reply Report </h1>
</section>
<section class="content">  
	<div class="row" >
		<div class="col-xs-12">
			<div class="grid_container" style="width:100%; min-height:700px;">
				<table 
				id="tt"  
				class="easyui-datagrid" 
				url="<?php echo base_url()."facebook_ex_autoreply/all_auto_reply_report_data"; ?>" 

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
						<!-- <th field="id"  checkbox="true"></th> -->
						<th field="page_name" sortable="true"><?php echo $this->lang->line("Page Name")?></th>
						<th field="auto_reply_campaign_name" sortable="true"><?php echo $this->lang->line("Campaign Name")?></th>
						<th field="auto_private_reply_count" sortable="true"><?php echo $this->lang->line("reply sent")?></th>
						<th field="view" formatter="video_analytics"><?php echo $this->lang->line("Actions")?></th>
						<th field="post_created_at" sortable="true"><?php echo $this->lang->line("Post Create Time")?></th>
						<th field="last_reply_time" sortable="true"><?php echo $this->lang->line("Last Reply Time")?></th>
						<th field="post_description" sortable="true"><?php echo $this->lang->line("Post Description")?></th>
					</tr>
				</thead>
			</table>                        
		</div>

		<div id="tb" style="padding:3px">

			<form class="form-inline" style="margin-top:20px">
				<div class="form-group">
					<select name="search_page_name" id="search_page_name" class="form-control">
						<option value="">Page Name</option>
						<?php foreach ($page_info as $key => $value): ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<input id="campaign_name" name="campaign_name" class="form-control" size="30" placeholder="<?php echo $this->lang->line('Campaign Name');?>">
				</div>
				<button class='btn btn-info'  onclick="doSearch(event)"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Search");?></button>    
			</form> 
		</div>        
	</div>
</div>   
</section>


<script>

	var base_url="<?php echo site_url(); ?>";

	function doSearch(event)
	{
		event.preventDefault(); 
		$j('#tt').datagrid('load',{
			search_page_name   :     $j('#search_page_name').val(),      
			campaign_name   :     $j('#campaign_name').val(),      
			is_searched		:     1
		});


	}

	function video_analytics(value,row,index)
	{
		var page_url = "<button class='btn btn-warning btn-sm edit_reply_info' table_id='"+row.id+"'><i class='fa fa-pencil'></i> Edit</button>&nbsp;<button class='btn btn-primary btn-sm view_report' table_id='"+row.id+"'><i class='fa fa-th-list'></i> Report</button>&nbsp;<button class='btn btn-danger btn-sm delete_report' table_id='"+row.id+"'><i class='fa fa-remove'></i> Delete</button>";
		return page_url;
	}

	$(document.body).on('click','.delete_report',function(){
		var ans = confirm("Do you want to delete this record from database?");
		if(ans)
		{
			var table_id = $(this).attr('table_id');
			$.ajax({
	    	type:'POST' ,
	    	url: base_url+"facebook_ex_autoreply/ajax_autoreply_delete",
	    	data: {table_id:table_id},
	    	// async: false,
	    	success:function(response){
	         	$j('#tt').datagrid('reload');
	    	}

	    });
		}
	});


	$(document.body).on('click','.view_report',function(){
		var loading = '<img src="'+base_url+'assets/pre-loader/custom_lg.gif" class="center-block">';
		$("#view_report_modal_body").html(loading);
		$("#view_report").modal();
		var table_id = $(this).attr('table_id');
		$.ajax({
	    	type:'POST' ,
	    	url: base_url+"facebook_ex_autoreply/ajax_get_reply_info",
	    	data: {table_id:table_id},
	    	// async: false,
	    	success:function(response){
	         	$("#view_report_modal_body").html(response);
	    	}

	    });

	});


	$(document.body).on('click','.edit_reply_info',function(){
		$("#edit_response_status").html("");
		for(var j=1;j<=10;j++)
		{
			$("#edit_filter_div_"+j).hide();
		}

		var table_id = $(this).attr('table_id');
		$.ajax({
		  type:'POST' ,
		  url:"<?php echo site_url();?>facebook_ex_autoreply/ajax_edit_reply_info",
		  data:{table_id:table_id},
		  dataType:'JSON',
		  success:function(response){
		  	$("#edit_auto_reply_page_id").val(response.edit_auto_reply_page_id);
		  	$("#edit_auto_reply_post_id").val(response.edit_auto_reply_post_id);
		  	$("#edit_auto_campaign_name").val(response.edit_auto_campaign_name);
		  	$("#edit_nofilter_word_found_text").val(response.edit_nofilter_word_found_text);
		  	$("#edit_"+response.reply_type).prop('checked', true);
		  	if(response.reply_type == 'generic')
		  	{
		  		$("#edit_generic_message_div").show();
		  		$("#edit_filter_message_div").hide();
		  		var i=1;
		  		edit_content_counter = i;
		  		$("#edit_generic_message").val(response.auto_reply_text);	  	  	
		  	}
		  	else
		  	{
		  		$("#edit_filter_message_div").show();
		  		$("#edit_generic_message_div").hide();
		  		var auto_reply_text_array = JSON.stringify(response.auto_reply_text);
		  		auto_reply_text_array = JSON.parse(auto_reply_text_array,'true');
		  		
		  		for(var i = 0; i < auto_reply_text_array.length; i++) {
		  		    var j = i+1;
		  		    $("#edit_filter_div_"+j).show();
		  			$("#edit_filter_word_"+j).val(auto_reply_text_array[i]['filter_word']);
		  			$("#edit_filter_message_"+j).val(auto_reply_text_array[i]['reply_text']);
		  		}



		  		edit_content_counter = i+1;
		  		$("#edit_content_counter").val(edit_content_counter);
		  	}
		  	$("#edit_auto_reply_message_modal").modal();
		  }
		});
	});


	$(document.body).on('click','#edit_add_more_button',function(){
		if(edit_content_counter == 11)
			$("#edit_add_more_button").hide();
		$("#edit_content_counter").val(edit_content_counter);

		$("#edit_filter_div_"+edit_content_counter).show();
		edit_content_counter++;

	});



	$(document.body).on('click','#edit_save_button',function(){
		var post_id = $("#edit_auto_reply_post_id").val();
		var edit_auto_campaign_name = $("#edit_auto_campaign_name").val();
		var reply_type = $("input[name=edit_message_type]:checked").val();
		
		if (typeof(reply_type)==='undefined')
		{
			alert("You didn't select any option.");
			return false;
		}
		if(reply_type == 'generic' || edit_auto_campaign_name == '')
		{
			var content = $("#edit_generic_message").val().trim();
			if(content == ''){
				alert("You didn't provide all information.");
				return false;
			}
		}
		else
		{
			var content1 = $("#edit_filter_word_1").val().trim();
			var content2 = $("#edit_filter_message_1").val().trim();
			if(content1 == '' || content2 == '' || edit_auto_campaign_name == ''){
				alert("You didn't provide all information.");
				return false;
			}
		}

		var loading = '<img src="'+base_url+'assets/pre-loader/custom_lg.gif" class="center-block">';
		$("#edit_response_status").html(loading);

		var queryString = new FormData($("#edit_auto_reply_info_form")[0]);
	    $.ajax({
	    	type:'POST' ,
	    	url: base_url+"facebook_ex_autoreply/ajax_update_autoreply_submit",
	    	data: queryString,
	    	dataType : 'JSON',
	    	// async: false,
	    	cache: false,
	    	contentType: false,
	    	processData: false,
	    	success:function(response){
	         	if(response.status=="1")
		        {
		         	$("#edit_response_status").html(response.message);
		        }
		        else
		        {
		         	$("#edit_response_status").html(response.message);
		        }
	    	}

	    });

	});


	$(document.body).on('change','input[name=edit_message_type]',function(){    
    	if($("input[name=edit_message_type]:checked").val()=="generic")
    	{
    		$("#edit_generic_message_div").show();
    		$("#edit_filter_message_div").hide();
    	}
    	else 
    	{
    		$("#edit_generic_message_div").hide();
    		$("#edit_filter_message_div").show();
    	}
    });

    $(document.body).on('click','.lead_first_name',function(){
    	var caretPos = $(this).parent().next()[0].selectionStart;
	    var textAreaTxt = $(this).parent().next().val();
	    var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
	    // var new_text = textAreaTxt + txtToAdd;
	    $(this).parent().next().val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
	});

	$(document.body).on('click','.lead_last_name',function(){

    	var caretPos = $(this).parent().next().next()[0].selectionStart;
	    var textAreaTxt = $(this).parent().next().next().val();
	    var txtToAdd = " #LEAD_USER_LAST_NAME# ";
	    $(this).parent().next().next().val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
	});

    $(document.body).on('click','.emotion',function(){  
    	var img_link = $(this).attr("src");
    	var eval = $(this).attr("eval");
    	var caretPos = $(this).parent().prev()[0].selectionStart;
    	var textAreaTxt = $(this).parent().prev().val();
    	var txtToAdd = " "+eval+" ";
    	$(this).parent().prev().val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
    });

	
</script>


<div class="modal fade" id="view_report" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">Report of auto reply</h4>
            </div>
            <div class="modal-body text-center" id="view_report_modal_body">                

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">Please give the following information for post auto private reply</h4>
            </div>
            <form action="#" id="edit_auto_reply_info_form" method="post">
	            <input type="hidden" name="edit_auto_reply_page_id" id="edit_auto_reply_page_id" value="">
	            <input type="hidden" name="edit_auto_reply_post_id" id="edit_auto_reply_post_id" value="">
            <div class="modal-body" id="edit_auto_reply_message_modal_body">                
				<div class="row" style="padding: 10px 20px 10px 20px;">					
					<div class="col-xs-12">
						<input name="edit_message_type" value="generic" id="edit_generic" class="radio_button" type="radio"> Generic message for all <br/>
						<input name="edit_message_type" value="filter" id="edit_filter" class="radio_button" type="radio"> Send message by filtering word/sentence 
					</div>
					<div class="col-xs-12" style="margin-top: 15px;">
						<div class="form-group">
							<label>
								Auto reply campaign name <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your content here"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control" type="text" name="edit_auto_campaign_name" id="edit_auto_campaign_name" placeholder="write your auto reply campaign name here">
						</div>
					</div>
					<div class="col-xs-12" id="edit_generic_message_div" style="display: none;">
						<div class="form-group">
							<label>
								Message <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_generic_message" id="edit_generic_message" placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id="emotion_container"><?php echo $emotion_list;?></div>
						</div>
					</div>
					<div class="col-xs-12" id="edit_filter_message_div" style="display: none;">
						<div class="form-group" id="edit_filter_div_1" style="border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_1" id="edit_filter_word_1" placeholder="write your filter word here">
							<br/>
							<label>
								Message <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_1" id="edit_filter_message_1"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_2" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_2" id="edit_filter_word_2" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_2" id="edit_filter_message_2"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_3" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_3" id="edit_filter_word_3" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_3" id="edit_filter_message_3"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_4" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_4" id="edit_filter_word_4" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_4" id="edit_filter_message_4"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_5" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_5" id="edit_filter_word_5" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_5" id="edit_filter_message_5"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_6" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_6" id="edit_filter_word_6" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_6" id="edit_filter_message_6"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_7" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_7" id="edit_filter_word_7" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_7" id="edit_filter_message_7"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_8" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_8" id="edit_filter_word_8" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_8" id="edit_filter_message_8"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_9" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_9" id="edit_filter_word_9" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_9" id="edit_filter_message_9"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="edit_filter_div_10" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_10" id="edit_filter_word_10" placeholder="write your filter word here">
							<br/>
							<label>
								Message 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your message which you want to send based on filter words. You can customize the message by individual commenter name."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> Include "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> Include "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_filter_message_10" id="edit_filter_message_10"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<br/>
						<div class="clearfix">
							<input type="hidden" name="edit_content_counter" id="edit_content_counter" />
							<button type="button" class="btn btn-sm btn-success pull-right" id="edit_add_more_button"><i class="fa fa-plus"></i> Add more filtering</button>
						</div>

						<div class="form-group" id="edit_nofilter_word_found_div" style="margin-top: 10px; border: 1px solid #ccc; padding: 10px;">
							<label>
								Message if no filter word found
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."><i class='fa fa-info-circle'></i> </a>
							</label>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_last_name'><i class='fa fa-user'></i> "Last Name"</a>
							</span>
							<span class='pull-right'> 
								<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
								<a title="Include lead user name" class='btn btn-default btn-sm lead_first_name'><i class='fa fa-user'></i> "First Name"</a>
							</span>	
							<textarea class="form-control message" name="edit_nofilter_word_found_text" id="edit_nofilter_word_found_text"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>


					</div>
				</div>
				<div class="col-xs-12 text-center" id="edit_response_status"></div>
            </div>
            </form>
            <div class="modal-footer text-center">                
				<button class="btn btn-lg btn-warning" id="edit_save_button">Update</button>
            </div>
        </div>
    </div>
</div>

