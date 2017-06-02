<style>

hr{
   margin-top: 10px;
}

.custom-top-margin{
  margin-top: 20px;
}

.sync_page_style{
   margin-top: 8px;
}
/* .wrapper,.content-wrapper{background: #fafafa !important;} */
.well{background: #fff;}
.box-shadow
{
  -webkit-box-shadow: 0px 2px 14px -3px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 2px 14px -3px rgba(0,0,0,0.75);
    box-shadow: 0px 2px 14px -3px rgba(0,0,0,0.75);
    border-bottom: 4px solid orange;
}

.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 66px;
    width: 50px;
    text-align: center;
    font-size: 30px;
    line-height: 66px;
    background: rgba(0,0,0,0.2);
}

.info-box {
    display: block;
    min-height: 67px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
}
.info-box-content
{
	margin-left: 50px;
}
</style>

<br/>
<?php if(empty($page_info)){ ?>
<div class="">
<div class="col-xs-12">       
	<div class="well">
		<h4 class="text-center"> <i class="fa fa-facebook-official"></i> You have no page in facebook<h4>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="">
<div class="col-xs-12">       
	<div class="well">
		<h4 class="text-center blue"> <i class="fa fa-facebook-official"></i> Auto Private Reply : Page List<h4>
		</div>
	</div>
</div>
<div class="row" style="padding:0 15px;">
	<?php $i=0; foreach($page_info as $value) : ?>
	<div class="col-xs-12 col-sm-12 col-md-6">
      <div class="box box-shadow box-solid">
        <div class="box-header with-border text-center">
          <h3 class="box-title blue"><?php echo $value['page_name']; ?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12">
            <div class="row">
              <?php $profile_picture=$value['page_profile']; ?>
              <div class="text-center col-xs-12 col-md-4">
                <img src="<?php echo $profile_picture;?>" alt="" class='custom-top-margin' style='padding:2px;border:1px solid #ccc;' height="107" width="107">
                
              	<a style="display: block; margin-top: 5px;" target="_blank" href="<?php echo base_url('facebook_ex_autoreply/auto_reply_report').'/'.$value['id']; ?>" class="btn btn-success btn-sm view_repo"><i class="fa fa-binoculars"></i> View report</a>
             
              </div>
              <div class="col-xs-12 col-md-8">
                <br/>
                <div class="info-box" style="margin-bottom:5px;border:1px solid #ccc;border-bottom:2px solid #ccc;">
                  <span class="info-box-icon bg-blue"><i class="fa fa-mail-reply-all"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text" style="font-weight: normal; font-size: 12px;"><b><?php echo $this->lang->line("Total auto reply enabled post");?></b></span><hr style="margin-bottom:2px;">
                    <span class="info-box-number">
                      <?php 
                      	echo number_format($value['auto_reply_enabled_post']);
                      ?>
                    </span>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box" style="margin-bottom:5px;border:1px solid #ccc;border-bottom:2px solid #ccc;">
                  <span class="info-box-icon bg-blue"><i class="fa fa-send"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text" style="font-weight: normal; font-size: 12px;"><b><?php echo $this->lang->line("Total auto reply sent");?></b></span><hr style="margin-bottom:2px;">
                    <span class="info-box-number">
                      <?php
                      	echo number_format($value['autoreply_count']);
                      ?>
                    </span>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
              
              </div>                  
            </div><!-- /.row -->
            <hr>
            <div class="row">             
              <div class="col-xs-12 col-md-6"> 
              	<button class="btn btn-primary btn-sm get_post" table_id="<?php echo $value['id']; ?>"><i class="fa fa-spinner"></i> Get latest posts & enable auto reply</button>
              </div> 
              
              <div class="col-xs-12 col-md-6 clearfix">
              	<div class="pull-right">
                    <?php 
	                    echo "<i class='fa fa-clock-o'></i> Last auto reply sent<br/>";
	                    if($value['last_reply_time']!="0000-00-00 00:00:00") echo "<span style='font-weight:normal;' class='label label-default'>".date("jS M, Y H:i:s a",strtotime($value['last_reply_time']))."<span>";
	                    else echo "<span style='font-weight:normal;' class='label label-warning'>Not replied yet</span>";
	                ?>
                  </div>
              </div> 
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <br/>
    </div>
	<?php   
	$i++;
	if($i%2 == 0)
		echo "</div><div class='row' style='padding:0 15px;'>";
	endforeach;
	?>
</div>
<?php } ?>

<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();	    
	});
	$j(document).ready(function(){

		var base_url = "<?php echo base_url(); ?>";
		var content_counter = 1;
		var edit_content_counter = 1;

		$('[data-toggle="popover"]').popover(); 
		$('[data-toggle="popover"]').on('click', function(e) {e.preventDefault(); return true;});

		$(".get_post").click(function(){
			var table_id = $(this).attr('table_id');
			var loading = '<img src="'+base_url+'assets/pre-loader/custom_lg.gif" class="center-block">';
			$("#post_synch_modal_body").html(loading);
		  	$("#post_synch_modal").modal();
			$.ajax({
			  type:'POST' ,
			  url:"<?php echo site_url();?>facebook_ex_autoreply/import_latest_post",
			  data:{table_id:table_id},
			  dataType:'JSON',
			  success:function(response){
			  	  $("#page_name_div").html(response.page_name);
			  	  $("#post_synch_modal_body").html(response.message);
			  }
			});

		});
		

		$(document.body).on('click','.enable_auto_commnet',function(){
			var page_table_id = $(this).attr('page_table_id');
			var post_id = $(this).attr('post_id');

			$("#auto_reply_page_id").val(page_table_id);
			$("#auto_reply_post_id").val(post_id);
			$(".message").val('');
			$(".filter_word").val('');
			for(var i=2;i<=10;i++)
			{
				$("#filter_div_"+i).hide();
			}
			content_counter = 1;
			$("#content_counter").val(content_counter);
			$("#add_more_button").show();

			$("#response_status").html('');

			$("#auto_reply_message_modal").addClass("modal");
			$("#auto_reply_message_modal").modal();
		});
		


		$("#content_counter").val(content_counter);
		$(document.body).on('click','#add_more_button',function(){
			content_counter++;
			if(content_counter == 10)
				$("#add_more_button").hide();
			$("#content_counter").val(content_counter);

			$("#filter_div_"+content_counter).show();

		});


		$(document.body).on('change','input[name=message_type]',function(){    
        	if($("input[name=message_type]:checked").val()=="generic")
        	{
        		$("#generic_message_div").show();
        		$("#filter_message_div").hide();
        	}
        	else 
        	{
        		$("#generic_message_div").hide();
        		$("#filter_message_div").show();
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
        	// var new_text = textAreaTxt + txtToAdd;
        	$(this).parent().prev().val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });



		$(document.body).on('click','#save_button',function(){
			var post_id = $("#auto_reply_post_id").val();
			var reply_type = $("input[name=message_type]:checked").val();
			
			if (typeof(reply_type)==='undefined')
			{
				alert("You didn't select any option.");
				return false;
			}
			var auto_campaign_name = $("#auto_campaign_name").val().trim();
			if(reply_type == 'generic')
			{
				var content = $("#generic_message").val().trim();
				if(content == '' || auto_campaign_name == ''){
					alert("You didn't provide all information.");
					return false;
				}
			}
			else
			{
				var content1 = $("#filter_word_1").val().trim();
				var content2 = $("#filter_message_1").val().trim();
				if(content1 == '' || content2 == '' || auto_campaign_name == ''){
					alert("You didn't provide all information.");
					return false;
				}
			}

			var loading = '<img src="'+base_url+'assets/pre-loader/custom_lg.gif" class="center-block">';
			$("#response_status").html(loading);

			var queryString = new FormData($("#auto_reply_info_form")[0]);
		    $.ajax({
		    	type:'POST' ,
		    	url: base_url+"facebook_ex_autoreply/ajax_autoreply_submit",
		    	data: queryString,
		    	dataType : 'JSON',
		    	// async: false,
		    	cache: false,
		    	contentType: false,
		    	processData: false,
		    	success:function(response){
		         	if(response.status=="1")
			        {
			         	$("#response_status").html(response.message);
						$("button[post_id="+post_id+"]").removeClass('btn-success').addClass('btn-danger').html('Already Enabled');
			        }
			        else
			        {
			         	$("#response_status").html(response.message);
			        }
		    	}

		    });

		});

		

		$(document.body).on('click','#modal_close',function(){        	
			$("#auto_reply_message_modal").removeClass("modal");
		});

		$(document.body).on('click','#edit_modal_close',function(){        	
			$("#edit_auto_reply_message_modal").removeClass("modal");
		});


		$('#post_synch_modal').on('hidden.bs.modal', function () { 
			location.reload();
		});


		$(document.body).on('click','.edit_reply_info',function(){
			$("#edit_auto_reply_message_modal").addClass("modal");
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
			  	$("#edit_nofilter_word_found_text").html(response.edit_nofilter_word_found_text);
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
			  			var unscape_reply_text = auto_reply_text_array[i]['reply_text'];
			  			$("#edit_filter_message_"+j).html(unscape_reply_text);
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
			if(reply_type == 'generic')
			{
				var content = $("#edit_generic_message").val().trim();
				if(content == '' || edit_auto_campaign_name == ''){
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

		
	});
</script>


<div class="modal fade" id="post_synch_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center"><i class="fa fa-spinner"></i> Latest post for page - <span id="page_name_div"></span></h4>
            </div>
            <div class="modal-body text-center" id="post_synch_modal_body">                

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id='modal_close' class="close">&times;</button>
                <h4 class="modal-title text-center">Please give the following information for post auto private reply</h4>
            </div>
            <form action="#" id="auto_reply_info_form" method="post">
	            <input type="hidden" name="auto_reply_page_id" id="auto_reply_page_id" value="">
	            <input type="hidden" name="auto_reply_post_id" id="auto_reply_post_id" value="">
            <div class="modal-body" id="auto_reply_message_modal_body">                
				<div class="row" style="padding: 10px 20px 10px 20px;">					
					<div class="col-xs-12">
						<input name="message_type" value="generic" id="generic" class="radio_button" type="radio"> Generic message for all <br/>
						<input name="message_type" value="filter" id="filter" class="radio_button" type="radio"> Send message by filtering word/sentence 
					</div>
					<div class="col-xs-12" style="margin-top: 15px;">
						<div class="form-group">
							<label>
								Auto reply campaign name <span class="red">*</span> 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="write your content here"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control" type="text" name="auto_campaign_name" id="auto_campaign_name" placeholder="write your auto reply campaign name here">
						</div>
					</div>
					<div class="col-xs-12" id="generic_message_div" style="display: none;">
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
							<textarea class="form-control message" name="generic_message" id="generic_message" placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id="emotion_container"><?php echo $emotion_list;?></div>
						</div>
					</div>
					<div class="col-xs-12" id="filter_message_div" style="display: none;">

						<div class="form-group" id="filter_div_1" style="border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_1" id="filter_word_1" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_1" id="filter_message_1"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_2" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_2" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_2" id="filter_message_2"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_3" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_3" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_3" id="filter_message_3"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_4" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_4" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_4" id="filter_message_4"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_5" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_5" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_5" id="filter_message_5"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_6" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_6" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_6" id="filter_message_6"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_7" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_7" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_7" id="filter_message_7"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_8" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_8" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_8" id="filter_message_8"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_9" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_9" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_9" id="filter_message_9"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<div class="form-group" id="filter_div_10" style="margin-top : 10px; display : none; border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence 
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="filter_word_10" placeholder="write your filter word here">
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
							<textarea class="form-control message" name="filter_message_10" id="filter_message_10"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>

						<br/>
						<div class="clearfix">
							<input type="hidden" name="content_counter" id="content_counter" />
							<button type="button" class="btn btn-sm btn-success pull-right" id="add_more_button"><i class="fa fa-plus"></i> Add more filtering</button>
						</div>

						<div class="form-group" id="nofilter_word_found_div" style="margin-top: 10px; border: 1px solid #ccc; padding: 10px;">
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
							<textarea class="form-control message" name="nofilter_word_found_text" id="nofilter_word_found_text"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>


					</div>
				</div>
				<div class="col-xs-12 text-center" id="response_status"></div>
            </div>
            </form>
            <div class="modal-footer text-center">                
				<button class="btn btn-lg btn-warning" id="save_button">Save</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id='edit_modal_close' class="close">&times;</button>
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