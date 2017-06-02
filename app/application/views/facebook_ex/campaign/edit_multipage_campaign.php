<div class="row padding-20">
	<div class="col-xs-12 col-md-7 padding-10">
		<div class="box box-primary">
			<div class="box-header ui-sortable-handle  text-center" style="cursor: move;margin-bottom: 0px;">
				<i class="fa fa-pencil"></i>
				<h3 class="box-title">Edit Multi-page Campaign</h3>
				<!-- tools box -->
				<div class="pull-right box-tools"></div><!-- /. tools -->
			</div>
			<div class="box-body">
				<img class="wait_few_seconds center-block" src="<?php echo base_url("assets/pre-loader/Fading squares2.gif");?>" alt="">
				<form action="#" enctype="multipart/form-data" id="inbox_campaign_form" method="post">
					<div class="form-group">
						<label>
							Campaign Name 
							<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Campaign Name" data-content="Put a name so that you can identify it later"><i class='fa fa-info-circle'></i> </a>
						</label>
						<input type="text" value="<?php echo $xdata[0]["campaign_name"];?>" class="form-control"  name="campaign_name" id="campaign_name">
						<input type="hidden" value="<?php echo $xdata[0]["id"];?>" class="form-control"  name="campaign_id" id="campaign_id">
						<input type="hidden" value="<?php echo $xdata[0]["total_thread"];?>" class="form-control"  name="previous_thread" id="previous_thread">
					</div>
					
					<div class="form-group">
						<label>
							Message *
							<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Message may contain texts, urls and emotions.You can include #LEAD_USER_NAME# variable by clicking 'Include Lead User Name' button. The variable will be replaced by real names when we will send it. If you want to show links or youtube video links with preview, then you can use 'Paste URL' OR 'Paste Youtube Video URL' fields below. Remember that if you put url/link inside this message area, preview of 'Paste URL' OR 'Paste Youtube Video ID' will not work. Then, the first url inside this message area will be previewed."><i class='fa fa-info-circle'></i> </a>
						</label>
						<span class='pull-right'> 
							<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user last name"" data-content="You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
							<a title="Include lead user name" class='btn btn-default btn-sm' id="lead_last_name"><i class='fa fa-user'></i> Include "Last Name"</a>
						</span>
						<span class='pull-right'> 
							<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Include lead user first name"" data-content="You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it."><i class='fa fa-info-circle'></i> </a> 
							<a title="Include lead user name" class='btn btn-default btn-sm' id="lead_first_name"><i class='fa fa-user'></i> Include "First Name"</a>
						</span>
						<textarea class="form-control" name="message" id="message" placeholder="Type your message here..." style="height:170px;"><?php echo $xdata[0]["campaign_message"];?></textarea>
						<div class='text-center' id="emotion_container"><?php echo $emotion_list;?></div>
					</div>
					
					<div class="form-group col-xs-12 col-md-5">
						<label>
							Paste URL <br/><small>(will be attached & previewed)</small>
							<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Paste URL" data-content="Paste any url, make sure your url contains http:// or https://. This url will be attched after your message with preview."><i class='fa fa-info-circle'></i> </a>
						</label>
						<input value="<?php echo $xdata[0]["attached_url"];?>" class="form-control" name="link" id="link"  type="text" placeholder="http://example.com">
					</div>	

					<div class="form-group col-xs-12 col-md-1 text-center">
						<label></label>
						<h4 style="margin:0" title="Eiher url or video will be previewed and attached at the bottom of message">OR</h4>
					</div>	

					<div class="form-group col-xs-12 col-md-6">
						<label>
							Paste Youtube Video URL  <br/><small>(will be attached & previewed)</small>
							<a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Paste Youtube Video URL" data-content="Paste any Youtube video URL, make sure your youtube url looks like https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID. This video url will be attched after your message with preview."><i class='fa fa-info-circle'></i> </a>
						</label>
						<input value="<?php echo $xdata[0]["attached_video"];?>" class="form-control" name="video_url" id="video_url" type="text" placeholder="https://www.youtube.com/watch?v=VIDEO_ID"> 
					</div>

					<br/>
					<img id="preview_loading" class="loading center-block" src="<?php echo base_url("assets/pre-loader/Fading squares2.gif");?>" alt="">
				    <div class="clearfix"></div>
					<br/><br/>
					
					<div class="alert alert-danger text-center" id="alert_div" style="display: none; font-size: 600;"></div>
					
					<div class="form-group">
						<label style="width:100%">
							Choose pages *
							 <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Choose Pages" data-content="Choose one or more pages to create campaign. This message will send to all your active leads of pages you choose now. You can use 'Do not send message to these leads' field below to unlist any list only from this campaign. To unlist any specific lead permanently, please go to 'Import Lead > Lead List' and unsubscribe the lead, he/she will not recieve any other message until he/she is subscribed again. The value of 'Total Lead Selected' label may different than the original create form, because lead counts are dynamic and change over time."><i class='fa fa-info-circle'></i> </a>
							 <span class='label label-info pull-right' style="padding:3px 8px;font-size:13px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;">Total Lead Selected : <span id="thread_count"><?php echo $xdata[0]["total_thread"];?></span></span>
						</label>
						<?php
							$xdata_page_ids = isset($xdata[0]["page_ids"]) ? $xdata[0]["page_ids"] : "";
							$xdata_fb_page_ids = isset($xdata[0]["fb_page_ids"]) ? $xdata[0]["fb_page_ids"] : "";
							$page_ids_explode = explode(',', $xdata_page_ids);
							$fb_page_ids_explode = explode(',', $xdata_fb_page_ids);
						?>
						<select multiple="multiple"  class="form-control" id="inbox_to_pages" name="inbox_to_pages[]">	
						<?php							
							foreach($page_info as $key=>$val)
							{	
								$id=$val['id'];
								$page_name=$val['page_name'];
								$page_id=$val['page_id'];
								if(in_array($id, $page_ids_explode) && in_array($page_id, $fb_page_ids_explode))
								echo "<option selected value='{$id}-{$page_id}' page_id='{$page_id}'>{$page_name}</option>";								
								else echo "<option value='{$id}-{$page_id}' page_id='{$page_id}'>{$page_name}</option>";								
							}
						 ?>						
						</select>
						
					</div>

					<div class="form-group">
                        <label>
                       		Exclude these leads
                        	<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Do not send message to these leads" data-content="You can choose one or more. The leads you choose here will be unlisted form this campaign and will not recieve this message. Start typing a lead name, it's auto-complete."><i class='fa fa-info-circle'></i> </a>
                        </label>
                        <select style="width:100px;"  name="do_not_send[]" id="do_not_send" multiple="multiple" class="tokenize-sample form-control do_not_send_autocomplete"> 
                        <?php 
                       		foreach ($xdo_not_send_to as $key => $value) 
                       		{
                       			echo  "<option selected value='".$value["client_thread_id"]."'>".$value["client_username"]."</option>";
                       		}
                        ?>                                    
                        </select>
                    </div> 	

					<div class="row">
						<div class="form-group col-xs-12 col-md-6">
							<label>
								Delay time (seconds)
								 <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Delay time" data-content="Delay time is the delay between two successive message send. It is very important because without a delay time facebook may treat bulk sending as spam.  Put input integer value in seconds upto 10 secs. Keep it '0' to get random delay."><i class='fa fa-info-circle'></i> </a>
							</label>
							<br/>
							<input name="delay_time" value="<?php echo $xdata[0]["delay_time"];?>" min="0" max="10" id="delay_time" type="number"><br/> 0 means random
						</div>

						<div class="form-group col-xs-12 col-md-6">
							<label>
								Embed unsubscribe link
								 <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Embed unsusbcribe link with message" data-content="You can embed 'unsubscribe link' with the message you send. Just enable it and system will automaticallly add the link at the bottom. Clicking the link will unsubscribe the lead. You can use your own method to serve this purpose if you want."><i class='fa fa-info-circle'></i> </a>
							</label>
							<br/>
							<input name="unsubscribe_button" value="0" id="unsubscribe_button_disable" <?php if($xdata[0]["unsubscribe_button"]=="0") echo "checked";?> type="radio"> Disable &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input name="unsubscribe_button" value="1" id="unsubscribe_button_enable" <?php if($xdata[0]["unsubscribe_button"]=="1") echo "checked";?> type="radio"> Enable 
						</div>
					</div>

					<br>
					<br>

					<div class="form-group">
						<label>
							Schedule
							 <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Schedule" data-content="You can either send message now or can schedule it later. If you want to sed later the schedule it and system will automatically process this campaign as time and time zone mentioned. Schduled campaign may take upto 1 hour lomger than your schedule time depending on server's processing.."><i class='fa fa-info-circle'></i> </a>
						</label>
						<br/>
						<input name="schedule_type" value="now" id="schedule_now"  type="radio"> Now &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input name="schedule_type" value="later" id="schedule_later" checked type="radio"> Later 
					</div>

					<div class="form-group schedule_block_item col-xs-12 col-md-6">
						<label>Schedule time  <a href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="Schedule Time" data-content="Select date and time when you want to process this campaign."><i class='fa fa-info-circle'></i> </a></label>
						<input placeholder="Time" value="<?php echo $xdata[0]["schedule_time"];?>"  name="schedule_time" id="schedule_time" class="form-control datepicker" type="text"/>
					</div>

					<div class="form-group schedule_block_item col-xs-12 col-md-6">
						<label>
							Time zone
							 <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="Time zone" data-content="Server will consider your time zone when it process the campaign."><i class='fa fa-info-circle'></i> </a>
						</label>
						<?php
						$time_zone[''] = 'Please Select';
						echo form_dropdown('time_zone',$time_zone,$xdata[0]["time_zone"],' class="form-control" id="time_zone" required'); 
						?>
					</div>					 

					<div class="clearfix"></div>

					<div class="box-footer clearfix">
						<div class="col-xs-12">
							<button style='width:100%;margin-bottom:10px;' class="btn btn-primary center-block btn-lg" id="submit_post" name="submit_post" type="button"><i class="fa fa-pencil"></i> Edit Campaign </button>
						</div>
					</div>					
					<?php  echo "<h4 id='monthly_message_send_limit'><div class='alert alert-danger text-center'><i class='fa fa-remove'></i> Sorry, your monthly limit to send message is exceeded. <a href='".site_url('payment/usage_history')."'>".$this->lang->line("See usage log")."</a></div></h4>"?>

				</form>
			</div>
			
		</div>
	</div>  <!-- end of col-6 left part -->


	<div class="col-xs-12 col-md-5 padding-10">
		<div class="box box-primary">
			<div class="box-header ui-sortable-handle  text-center" style="cursor: move;margin-bottom: 0px;">
				<i class="fa fa-facebook-official"></i>
				<h3 class="box-title">Inbox Preview</h3>
				<!-- tools box -->
				<div class="pull-right box-tools"></div><!-- /. tools -->
			</div>
			<div class="box-body preview">					
				<img class="wait_few_seconds center-block" src="<?php echo base_url("assets/pre-loader/Fading squares2.gif");?>" alt="">
				<div class="chat_box">
					<div class="chat_header">
						<span class='pull-left' id="page_name">Page Name</span>
						<span class='pull-right'> <i class="fa fa-cog"></i> <i class="fa fa-remove"></i> </span>
					</div>
					<div class="chat_body">
						<img id="page_thumb" class="pull-left" src="<?php echo base_url("assets/images/chat_box_thumb.png");?>">
						<span id="preview_message" class="pull-left"><span id="preview_message_plain">Your message goes here...</span><span id="preview_message_link"></span></span>
						<div class="clearfix"></div>
						<div id="video_thumb" class="pull-left">
							<div id="video_embed">
								<!-- <iframe width="100%" height="100" src="https://www.youtube.com/embed/SP8o501ORJ4" frameborder="0" allowfullscreen></iframe> -->
							</div>
							<div id="video_info">								
								<div id="video_info_title"></div>
								<div id="video_info_description"></div>
								<div id="video_info_youtube">youtube.com</div>
							</div>
						</div>

						<div class="clearfix"></div>
						<div id="link_thumb" class="pull-left">
							<div class="col-xs-5" id="link_embed"></div>
							<div class="col-xs-7" id="link_info">
								<div id="link_info_title"></div>
								<div id="link_info_description"></div>
								<div id="link_info_website"></div>
							</div>	
						</div>

					</div>
					<div class="chat_footer">
						<img src="<?php echo base_url("assets/images/chat_box.png");?>" class="img-responsive">
					</div>
				</div>
			</div>			
		</div>

		<div class="box box-primary">
			<div class="box-header ui-sortable-handle  text-center" style="cursor: move;margin-bottom: 0px;">
				<i class="fa fa-cogs"></i>
				<h3 class="box-title">Send Test Message</h3>
				<!-- tools box -->
				<div class="pull-right box-tools"></div><!-- /. tools -->
			</div>
			<div class="box-body" id="test_msg_box_body">
				<div class="alert" id="test_send_modal_content">
					<form id="test_message_form">
						<img id="test_loading" class="loading center-block" src="<?php echo base_url("assets/pre-loader/Fading squares2.gif");?>" alt="">
						<h4><div id="test_message_response" class="table-responsive"></div></h4>
						<div class="form-group">
	                        <label class="text-center">
	                       		Choose up to 3 leads to test how it will look. Start typing, it's auto-complete.                       	
	                        </label>
	                        <select style="width:100px;"  name="test_send[]" id="test_send" multiple="multiple" class="tokenize-sample form-control test_send_autocomplete">                                     
	                        </select>
	                    </div>
	                    <div>
							<button class="btn btn-primary" id="submit_test_post" name="submit_test_post" type="button"><i class="fa fa-envelope"></i> Send Test Message </button>
						</div> 
					</form>
				</div>
			</div>
		</div>
		
	</div> <!-- end of col-6 right part -->

</div>


<script>

 
	$j("document").ready(function(){


		var base_url="<?php echo base_url();?>";


		$("#monthly_message_send_limit,#test_loading").hide();

		setTimeout(function() {
			$(".loading").hide();
			$(".wait_few_seconds").hide();
			$("#message,#link,#video_url").blur();
			count_lead_and_limit();			
		}, 5000);

		$('[data-toggle="popover"]').popover(); 
		$('[data-toggle="popover"]').on('click', function(e) {e.preventDefault(); return true;});

		$(".overlay").hide();

		var today = new Date();
		var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
		$j('.datepicker').datetimepicker({
			theme:'dark',
			format:'Y-m-d H:i:s',
			formatDate:'Y-m-d H:i:s',
			minDate: today,
			maxDate: next_date
		})	

		$j("#inbox_to_pages").multipleSelect({
            filter: true,
            multiple: true
        });	


        $(document.body).on('change','input[name=schedule_type]',function(){    
        	if($("input[name=schedule_type]:checked").val()=="later")
        	$(".schedule_block_item").show();
        	else 
        	{
        		$("#schedule_time").val("");
        		$("#time_zone").val("");
        		$(".schedule_block_item").hide();
        	}
        }); 


        function message_change()
        {
        	var message=$(this).val();
        	message=message.replace(/[\r\n]/g, "<br />");

        	if( $("#preview_message_link").html() != "") message = message + "<br/>";

        	$("#preview_message").show();
        	$("#preview_message_plain").show();

        	var words = message.split(" ");    
    		var img;
    		var src;
    		for (var i = 0; i < words.length; i++) 
    		{
			    words[i] = words[i].replace(/"/g,""); // replce all " from message

			    if(typeof($(".emotion[eval=\""+words[i]+"\"]").attr("title"))==='undefined') continue;			    
			    
		    	src = $(".emotion[eval=\""+words[i]+"\"]").attr("title");	
		    	src =  "<?php echo base_url('assets/images/emotions-fb');?>/"+src+".gif";	    	
		    	img= "<img src='"+src+"'>";
		    	message = message.replace(words[i], img);			    
			}	

        	$("#preview_message_plain").html(message).text();
        	if(message=="" && $("#preview_message_link").html() == "") $("#preview_message").hide(); 
        }

        $(document.body).on('keyup','#message',message_change); 
        $(document.body).on('blur','#message',message_change);

     
        $(document.body).on('click','.emotion',function(){  
        	var img_link = $(this).attr("src");
        	var eval = $(this).attr("eval");
        	var caretPos = document.getElementById("message").selectionStart;
		    var textAreaTxt = $("#message").val();
		    var txtToAdd = " "+eval+" ";
		    $("#message").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
		    $("#message").blur();
		});


        $(document.body).on('click','#lead_first_name',function(){  
		    var caretPos = document.getElementById("message").selectionStart;
		    var textAreaTxt = $("#message").val();
		    var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
		    $("#message").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
		    $("#preview_message_plain").html($("#message").val());
		});


		$(document.body).on('click','#lead_last_name',function(){  
		    var caretPos = document.getElementById("message").selectionStart;
		    var textAreaTxt = $("#message").val();
		    var txtToAdd = " #LEAD_USER_LAST_NAME# ";
		    $("#message").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
		    $("#preview_message_plain").html($("#message").val());
		});

   
 		$(document.body).on('blur','#link',function(){  
        	var link=$("#link").val();  
        	
	        if(link!='')
	        {
	            $("#preview_loading").show();
	            $.ajax({
	            type:'POST' ,
	            url:"<?php echo site_url();?>facebook_ex_campaign/link_grabber",
	            data:{link:link},
	            dataType : 'JSON',
	            success:function(response){	 

	            	$("#preview_loading").hide();          		                
	             
               	 	if(response.status=='0')
               	 	{
               	 		alert("URL is invalid.");
               	 		$("#link").val("");
               	 		$("#link_thumb").hide();
               	 		$("#preview_message").css("-webkit-border-radius","10px");       
            			$("#preview_message").css("-moz-border-radius","10px");       
            			$("#preview_message").css("border-radius","10px"); 
               	 	}
               	 	else
               	 	{
            			if(response.image=="") response.image= "<?php echo base_url('assets/images/chat_box_thumb2.png');?>";
            			$("#link_embed").html("<img src='"+response.image+"'>");
            			$("#link_info_title").html(response.title);
            			$("#link_info_description").html(response.description);
            			var link_author=link;
            			link_author = link_author.replace("http://", ""); 
	                	link_author = link_author.replace("https://", ""); 
	                	link_author = link_author.replace("www.", ""); 
	                	
	                	if($("#message").val() == "")
            			$("#preview_message_link").html("<a href='"+link+"' target='_BLANK'>"+link+"</a>").show();
            			else $("#preview_message_link").html("<br/><a href='"+link+"' target='_BLANK'>"+link+"</a>").show();
            			
            			$("#link_info_website").html(link_author);
            			$("#link_thumb").show(); 
            			$("#video_thumb").hide(); 
            			$("#video_url").val("");

            			if( $("#message").val() == "") 
            			$("#preview_message_plain").hide();            	
            			else 
            			{
            				$("#preview_message").css("-webkit-border-radius","10px 10px 10px 0");       
            				$("#preview_message").css("-moz-border-radius","10px 10px 10px 0");       
            				$("#preview_message").css("border-radius","10px 10px 10px 0");       
            			}
               	 	}
                             
	            }
	        }); 	            
	        }
	        else 
	       	{
	       		$("#link_thumb").hide(); 
	       		$("#preview_message_link").hide();
	       		$("#preview_message").css("-webkit-border-radius","10px");       
            	$("#preview_message").css("-moz-border-radius","10px");       
            	$("#preview_message").css("border-radius","10px"); 
	       	}     		      
            
        });


        $(document.body).on('blur','#video_url',function(){  
        	var link=$("#video_url").val();  
	        if(link!='')
	        {
	            $("#preview_loading").show();
	            $.ajax({
	            type:'POST' ,
	            url:"<?php echo site_url();?>facebook_ex_campaign/youtube_video_grabber",
	            data:{link:link},
	            dataType : 'JSON',
	            success:function(response){	           		                
	             	
	       			$("#preview_loading").hide();   
               	 	if(response.status=='0')
               	 	{
               	 		alert("Youtube URL is invalid.");
               	 		$("#video_url").val("");
               	 		$("#video_thumb").hide();
               	 	}
               	 	else
               	 	{
            			$("#video_embed").html(response.video_embed);
            			$("#video_info_title").html(response.title);
            			$("#video_info_description").html(response.description);
            			
            			if($("#message").val() == "")
            			$("#preview_message_link").html("<a href='"+link+"' target='_BLANK'>"+link+"</a>").show();
            			else $("#preview_message_link").html("<br/><a href='"+link+"' target='_BLANK'>"+link+"</a>").show();
            			
            			$("#video_thumb").show(); 
            			$("#link_thumb").hide(); 
            			$("#link").val("");

            			if( $("#message").val() == "") 
            			$("#preview_message_plain").hide();
            				
            			else 
            			{
            				$("#preview_message").css("-webkit-border-radius","10px 10px 10px 0");       
            				$("#preview_message").css("-moz-border-radius","10px 10px 10px 0");       
            				$("#preview_message").css("border-radius","10px 10px 10px 0");       
            			}
               	 	}
                             
	            }
	        }); 	            
	        }	
	        else 
	       	{
	       		$("#video_thumb").hide(); 
	       		$("#preview_message_link").hide();
	       		$("#preview_message").css("-webkit-border-radius","10px");       
            	$("#preview_message").css("-moz-border-radius","10px");       
            	$("#preview_message").css("border-radius","10px"); 
	       	}  
            
        });


        function count_lead_and_limit()
        {
        	var inbox_to_pages = $("#inbox_to_pages").val(); 
        	var previous_thread = $("#previous_thread").val(); // previous thread have to substract when calculate new message sending limt

        	$("#submit_post").removeClass('disabled');
       	 	$("#test_send_modal_btn").removeClass('disabled');
       	 	$("#monthly_message_send_limit").hide();

        	if(inbox_to_pages!=null)
        	{
        		var fb_page_ids=[];
        		var i=0;
        		$.each(inbox_to_pages,function(index,value) {
        			fb_page_ids[i] = $("#inbox_to_pages option[value="+value+"]").attr('page_id');
        			i++;
        		});

        		$.ajax({
			       type:'POST' ,
			       url: base_url+"facebook_ex_campaign/count_total_inbox",
			       data: {fb_page_ids:fb_page_ids,previous_thread:previous_thread},
			       dataType: 'JSON',		      
			       success:function(response)
			       { 
			         if(response.count > 300)
			       	 {
			       	 	var custom_campaign_link = "<?php echo base_url('facebook_ex_campaign/custom_campaign'); ?>";
			       	 	var alert_message = "The list seems large. We highly recommend to split your campaign with small campaign with 300 leads per campaign.For create custom campaign, <a href='"+custom_campaign_link+"'>go here</a>. Anyway we will submit all leads for sending message. But it may happen that facebook prevent sending message to high volume at a time. Use dealy 10 or more for safety.";
			       	 	$("#alert_div").show().html(alert_message);
			       	 }
			       	 else
			       	 	$("#alert_div").hide();

			       	 $("#thread_count").html(response.count);
			       	 if(response.message_limit_exceeded=="1") // monthly send limit exceeded
			       	 {
			       	 	alert(" Sorry, your monthly limit to send message is exceeded.");
			       	 	$("#submit_post").addClass('disabled');
			       	 	$("#test_send_modal_btn").addClass('disabled');
			       	 	$("#monthly_message_send_limit").show();
			       	 }
			       	 else
			       	 {
			       	 	$("#submit_post").removeClass('disabled');
			       	 	$("#test_send_modal_btn").removeClass('disabled');
			       	 	$("#monthly_message_send_limit").hide();
			       	 }
			       }
		       });
        	}
        	else $("#thread_count").html("0");
        }
	    
        $(document.body).on('click','.ms-parent input[type=checkbox]',count_lead_and_limit);

        
        $('.do_not_send_autocomplete').tokenize({
            datas: base_url+"facebook_ex_campaign/lead_autocomplete/1"
        });

        $('.test_send_autocomplete').tokenize({
            datas: base_url+"facebook_ex_campaign/lead_autocomplete/0",
            maxElements : 3
        });




	    $(document.body).on('click','#submit_test_post',function(){ 
	    	var thread_ids = $('.test_send_autocomplete').tokenize().toArray();
	    	if(thread_ids.length==0) 
	    	{
	    		alert("Please choose any lead to send test message.");
	    	 	return;
	    	}
	    	var message = $("#message").val();
	    	var link = $("#link").val();
	    	var video_url = $("#video_url").val();

	    	if(message=="" && link==""&&  video_url=="")
    		{
    			alert("Please type a message or paste url/video url. System can not send blank message.");
    			return;
    		} 
    	    $("#test_loading").show();
    	    $("#submit_test_post").addClass("disabled");
	        $.ajax({
		       type:'POST' ,
		       url: base_url+"facebook_ex_campaign/send_test_message",
		       data: {message:message,link:link,video_url:video_url,thread_ids:thread_ids},
		       success:function(response)
		       {  	    	 			
	 			  $("#test_loading").hide();
	 			  $("#submit_test_post").removeClass("disabled");
	 			  $("#test_message_response").html(response);
		       	  
		       }
	      	});
	    });



	    $(document.body).on('click','#submit_post',function(){ 
       
                  	
    		if($("#message").val()=="" && $("#link").val()==""&&  $("#video_url").val()=="")
    		{
    			alert("Please type a message or paste url/video url. System can not send blank message.");
    			return;
    		}    	
    	
        	
        	var inbox_to_pages = $("#inbox_to_pages").val();
        	
        	if(inbox_to_pages==null)
        	{
        		alert("Please select pages to create inbox campaign.");
        		return;
        	}
        	
      
        	var schedule_type = $("input[name=schedule_type]:checked").val();
        	var schedule_time = $("#schedule_time").val();
        	var time_zone = $("#time_zone").val();
        	if(schedule_type=='later' && (schedule_time=="" || time_zone==""))
        	{
        		alert("Please select schedule time/time zone.");
        		return;
        	}

        	$("#response_modal_content").removeClass("alert-danger");
        	$("#response_modal_content").removeClass("alert-success");
        	var loading = '<img src="'+base_url+'assets/pre-loader/Fading squares2.gif" class="center-block">';
        	$("#response_modal_content").html(loading);

        	var report_link = base_url+"facebook_ex_campaign/campaign_report";
        	var success_message = "<i class='fa fa-check-circle'></i> Campaign have been updated successfully. <a href='"+report_link+"'> See report</a>";

        	$("#response_modal_content").removeClass("alert-danger");
         	$("#response_modal_content").addClass("alert-success");
         	$("#response_modal_content").html(success_message);
       	        	
		      var queryString = new FormData($("#inbox_campaign_form")[0]);
		      $.ajax({
			       type:'POST' ,
			       url: base_url+"facebook_ex_campaign/edit_multipage_campaign_action",
			       data: queryString,
			       cache: false,
			       contentType: false,
			       processData: false,
			       success:function(response)
			       {  
			       }
		      	});
		      $("#response_modal").modal();
		      $(this).addClass("disabled");

				// var delay=2000;
				// setTimeout(function() {
				// 	window.location.href=report_link;
				// }, delay);

        });

 		//  $('#response_modal').on('hidden.bs.modal', function () { 
		// var link=base_url+"facebook_ex_campaign/campaign_report";
		// window.location.assign(link); 
		// })



    });

</script>



<div class="modal fade" id="response_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-center">Campaign Status</h4>
			</div>
			<div class="modal-body">
				<div class="alert text-center" id="response_modal_content">
					
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("facebook_ex/campaign/style");?>