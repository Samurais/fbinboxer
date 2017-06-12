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
                <img src="<?php echo $profile_picture;?>" alt="" class='' style='padding:2px;border:1px solid #ccc;' height="140" width="135">
                
              	<a style="display: block; margin-top: 5px;" target="_blank" href="<?php echo base_url('facebook_ex_autoreply/auto_reply_report').'/'.$value['id']; ?>" class="btn btn-success btn-sm view_repo"><i class="fa fa-binoculars"></i> View report</a>
             
              </div>
              <div class="col-xs-12 col-md-8">
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
              	<button style="margin-top: 4px;" class="manual_auto_reply" page_name="<?php echo $value['page_name']; ?>" page_table_id="<?php echo $value['id']; ?>">Enable reply by post id</button>
              	<button style="margin-top: 4px;" class="manual_edit_reply" page_name="<?php echo $value['page_name']; ?>" page_table_id="<?php echo $value['id']; ?>">Edit reply by post id</button>
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


		// enable and edit auto reply by post id
		$(".manual_auto_reply").click(function(){
			var page_name = $(this).attr('page_name');
			var page_table_id = $(this).attr('page_table_id');
			$("#manual_reply_error").html('');
			$("#manual_page_name").html(page_name);
			$("#manual_table_id").val(page_table_id);
			$("#manual_post_id").val('');
			// #manual_auto_reply is the id for (enable auto reply button of modal)
			$("#manual_auto_reply").attr('page_table_id',page_table_id);
			$("#manual_auto_reply").attr('post_id','');

			$("#manual_auto_reply").hide();
			$("#check_post_id").show();

			$("#manual_auto_reply").removeClass('btn-danger').addClass('btn-info').html('Enable Auto Reply');
			$("#manual_reply_by_post").addClass('modal');
			$("#manual_reply_by_post").modal();
		});

		$("#check_post_id").click(function(){
			$("#manual_reply_error").html('');		
			var post_id = $("#manual_post_id").val();
			var page_table_id = $("#manual_table_id").val();
			$.ajax({
			  type:'POST' ,
			  url:"<?php echo site_url();?>facebook_ex_autoreply/checking_post_id",
			  data:{page_table_id:page_table_id,post_id:post_id},
			  dataType:'JSON',
			  success:function(response){
			  	if(response.error == 'yes')
			  		$("#manual_reply_error").html("<h4 class='red'><div class='alert alert-danger text-center'><i class='fa fa-close'></i> "+response.error_msg+"</div></h4>");
			  	else
			  	{
				  	$("#manual_auto_reply").attr('post_id',post_id);
				  	$("#manual_auto_reply").attr('manual_enable','yes');
				  	$("#check_post_id").hide();
				  	$("#manual_auto_reply").show();
			  	}
			  }
			});
		});

		$(".manual_edit_reply").click(function(){
			var page_name = $(this).attr('page_name');
			var page_table_id = $(this).attr('page_table_id');
			$("#manual_edit_page_name").html(page_name);
			$("#manual_edit_table_id").val(page_table_id);
			$("#manual_edit_error").html('');
			$("#manual_edit_post_id").val('');
			$("#manual_edit_reply_by_post").addClass('modal');
			$("#manual_edit_reply_by_post").modal();
		});

		$("#manual_edit_post_id").keyup(function(){
			$("#manual_edit_auto_reply").hide();
			$("#manual_edit_error").html('');
			var post_id = $("#manual_edit_post_id").val();
			var page_table_id = $("#manual_edit_table_id").val();
			$.ajax({
			  type:'POST' ,
			  url:"<?php echo site_url();?>facebook_ex_autoreply/get_tableid_by_postid",
			  data:{page_table_id:page_table_id,post_id:post_id},
			  dataType:'JSON',
			  success:function(response){
			  	if(response.error == 'yes')
			  		$("#manual_edit_error").html("<h4 class='red'><div class='alert alert-danger text-center'><i class='fa fa-close'></i> This post ID is not found in database or this post ID is not associated with the page you are working.</div></h4>");
			  	else
				  	$("#manual_edit_auto_reply").attr('table_id',response.table_id);
			  	
			  	$("#manual_edit_auto_reply").show();
			  }
			});

		});
		// end of enable and edit auto reply by post id



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
			var manual_enable = $(this).attr('manual_enable');

			if(typeof(post_id) === 'undefined' || post_id == '')
			{
				alert("Please provide post ID.");
				return false;
			}

			$("#auto_reply_page_id").val(page_table_id);
			$("#auto_reply_post_id").val(post_id);
			$("#manual_enable").val(manual_enable);
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

			$("#manual_reply_by_post").removeClass('modal');
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
			var manual_post_id = $("#manual_post_id").val();
			if(manual_post_id != '')
			{
				$("#auto_reply_message_modal").modal("hide");
				$("#manual_reply_by_post").modal("hide");
				$("#manual_post_id").val('');
			}
			else
				$("#auto_reply_message_modal").removeClass("modal");
		});

		$(document.body).on('click','#edit_modal_close',function(){        	
			// $("#edit_auto_reply_message_modal").removeClass("modal");
			var manual_post_id = $("#manual_edit_post_id").val();
			if(manual_post_id != '')
			{
				$("#edit_auto_reply_message_modal").modal("hide");
				$("#manual_edit_reply_by_post").modal("hide");
				$("#manual_edit_post_id").val('');
			}
			else
				$("#edit_auto_reply_message_modal").removeClass("modal");
		});


		$('#post_synch_modal').on('hidden.bs.modal', function () { 
			location.reload();
		});


		$(document.body).on('click','.edit_reply_info',function(){
			$("#manual_edit_reply_by_post").removeClass('modal');
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


			  	$("#edit_"+response.reply_type).prop('checked', true);
			  	// added by mostofa on 27-04-2017
			  	if(response.comment_reply_enabled == 'no')
			  		$("#edit_comment_reply_enabled_no").attr('checked','checked');
			  	else
			  		$("#edit_comment_reply_enabled_yes").attr('checked','checked');

			  	if(response.multiple_reply == 'no')
			  		$("#edit_multiple_reply_no").attr('checked','checked');
			  	else
			  		$("#edit_multiple_reply_yes").attr('checked','checked');

			  	if(response.auto_like_comment == 'no')
			  		$("#edit_auto_like_comment_no").attr('checked','checked');
			  	else
			  		$("#edit_auto_like_comment_yes").attr('checked','checked');


			  	if(response.reply_type == 'generic')
			  	{
			  		$("#edit_generic_message_div").show();
			  		$("#edit_filter_message_div").hide();
			  		var i=1;
			  		edit_content_counter = i;
			  		var auto_reply_text_array_json = JSON.stringify(response.auto_reply_text);
			  		auto_reply_text_array = JSON.parse(auto_reply_text_array_json,'true');
			  		$("#edit_generic_message").html(auto_reply_text_array[0]['comment_reply']);	
			  		$("#edit_generic_message_private").html(auto_reply_text_array[0]['private_reply']);
			  	}
			  	else
			  	{
			  		var edit_nofilter_word_found_text = JSON.stringify(response.edit_nofilter_word_found_text);
			  		edit_nofilter_word_found_text = JSON.parse(edit_nofilter_word_found_text,'true');
			  		$("#edit_nofilter_word_found_text").html(edit_nofilter_word_found_text[0]['comment_reply']);
			  		$("#edit_nofilter_word_found_text_private").html(edit_nofilter_word_found_text[0]['private_reply']);

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
			  			// added by mostofa 25-04-2017
			  			var unscape_comment_reply_text = auto_reply_text_array[i]['comment_reply_text'];
			  			$("#edit_comment_reply_msg_"+j).html(unscape_comment_reply_text);
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
			// else
			// {
			// 	var content1 = $("#edit_filter_word_1").val().trim();
			// 	var content2 = $("#edit_filter_message_1").val().trim();
			// 	if(content1 == '' || content2 == '' || edit_auto_campaign_name == ''){
			// 		alert("You didn't provide all information.");
			// 		return false;
			// 	}
			// }

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
	            <input type="hidden" name="manual_enable" id="manual_enable" value="">
            <div class="modal-body" id="auto_reply_message_modal_body">                
				<div class="row" style="padding: 10px 20px 10px 20px;">
					<!-- added by mostofa on 26-04-2017 -->
					<div class="col-xs-12">
						<div class="col-xs-9" style="padding: 0px;"><label>Do you want to send reply message to a user multiple times?</label></div>
						<div class="col-xs-3">
							<label class="radio-inline"><input name="multiple_reply" value="no" id="multiple_reply_no" class="radio_button" type="radio" checked>No</label>
							<label class="radio-inline"><input name="multiple_reply" value="yes" id="multiple_reply_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="col-xs-6" style="padding: 0px;">
							<label>Do you want to enable comment reply?</label>
						</div>
						<div class="col-xs-6">							
							<label class="radio-inline"><input name="comment_reply_enabled" value="no" id="comment_reply_enabled_no" class="radio_button" type="radio" checked>No</label>
							<label class="radio-inline"><input name="comment_reply_enabled" value="yes" id="comment_reply_enabled_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="col-xs-6" style="padding: 0px;">
							<label>Do you want to like on comment by page?</label>
						</div>
						<div class="col-xs-6">							
							<label class="radio-inline"><input name="auto_like_comment" value="no" id="auto_like_comment_no" class="radio_button" type="radio" checked>No</label>
							<label class="radio-inline"><input name="auto_like_comment" value="yes" id="auto_like_comment_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>

					<br/><br/>

					<div class="col-xs-12">
						<input name="message_type" value="generic" id="generic" class="radio_button" type="radio"> <label for="generic">Generic message for all</label> <br/>
						<input name="message_type" value="filter" id="filter" class="radio_button" type="radio"> <label for="filter">Send message by filtering word/sentence</label>
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
								Message for comment reply <span class="red">*</span>
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

							<br/>
							<label>
								Message for private reply <span class="red">*</span>
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
							<textarea class="form-control message" name="generic_message_private" id="generic_message_private" placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id="emotion_container"><?php echo $emotion_list;?></div>
						</div>
					</div>
					<div class="col-xs-12" id="filter_message_div" style="display: none;">
						<?php for ($i=1; $i <= 10 ; $i++) : ?>
								<div class="form-group" id="filter_div_<?php echo $i; ?>" style="border: 1px solid #ccc; padding: 10px;">
									<label>
										Filter Word/Sentence <span class="red">*</span>
										<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when"><i class='fa fa-info-circle'></i> </a>
									</label>
									<input class="form-control filter_word" type="text" name="filter_word_<?php echo $i; ?>" id="filter_word_<?php echo $i; ?>" placeholder="write your filter word here">
									<br/>
									<label>
										Msg for private reply<span class="red">*</span>
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
									<textarea class="form-control message" name="filter_message_<?php echo $i; ?>" id="filter_message_<?php echo $i; ?>"  placeholder="Type your message here..." style="height:170px;"></textarea>
									<div class='text-center' id=""><?php echo $emotion_list;?></div>
									<!-- new feature comment reply section -->
									<br/>
									<label>
										Msg for comment reply<span class="red">*</span>
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
									<textarea class="form-control message" name="comment_reply_msg_<?php echo $i; ?>" id="comment_reply_msg_<?php echo $i; ?>"  placeholder="Type your message here..." style="height:170px;"></textarea>
									<div class='text-center' id=""><?php echo $emotion_list;?></div>
								</div>
						<?php endfor; ?>
						

						<br/>
						<div class="clearfix">
							<input type="hidden" name="content_counter" id="content_counter" />
							<button type="button" class="btn btn-sm btn-success pull-right" id="add_more_button"><i class="fa fa-plus"></i> Add more filtering</button>
						</div>

						<div class="form-group" id="nofilter_word_found_div" style="margin-top: 10px; border: 1px solid #ccc; padding: 10px;">
							<label>
								Comment reply if no matching found
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
							<br/>
							<label>
								Private reply if no matching found
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
							<textarea class="form-control message" name="nofilter_word_found_text_private" id="nofilter_word_found_text_private"  placeholder="Type your message here..." style="height:170px;"></textarea>
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
					<!-- added by mostofa on 26-04-2017 -->
					<div class="col-xs-12">
						<div class="col-xs-9" style="padding: 0px;"><label>Do you want to send reply message to a user multiple times?</label></div>
						<div class="col-xs-3">
							<label class="radio-inline"><input name="edit_multiple_reply" value="no" id="edit_multiple_reply_no" class="radio_button" type="radio">No</label>
							<label class="radio-inline"><input name="edit_multiple_reply" value="yes" id="edit_multiple_reply_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="col-xs-6" style="padding: 0px;">
							<label>Do you want to enable comment reply?</label>
						</div>
						<div class="col-xs-6">							
							<label class="radio-inline"><input name="edit_comment_reply_enabled" value="no" id="edit_comment_reply_enabled_no" class="radio_button" type="radio">No</label>
							<label class="radio-inline"><input name="edit_comment_reply_enabled" value="yes" id="edit_comment_reply_enabled_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="col-xs-6" style="padding: 0px;">
							<label>Do you want to like on comment by page?</label>
						</div>
						<div class="col-xs-6">							
							<label class="radio-inline"><input name="edit_auto_like_comment" value="no" id="edit_auto_like_comment_no" class="radio_button" type="radio" checked>No</label>
							<label class="radio-inline"><input name="edit_auto_like_comment" value="yes" id="edit_auto_like_comment_yes" class="radio_button" type="radio">Yes</label>
						</div>
					</div>

					<br/><br/>

					<div class="col-xs-12">
						<input name="edit_message_type" value="generic" id="edit_generic" class="radio_button" type="radio"> <label for="edit_generic">Generic message for all</label> <br/>
						<input name="edit_message_type" value="filter" id="edit_filter" class="radio_button" type="radio"> <label for="edit_filter">Send message by filtering word/sentence</label>
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
								Message for comment reply <span class="red">*</span>
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

							<br/>
							<label>
								Message for private reply <span class="red">*</span>
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
							<textarea class="form-control message" name="edit_generic_message_private" id="edit_generic_message_private" placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id="emotion_container"><?php echo $emotion_list;?></div>
						</div>
					</div>
					<div class="col-xs-12" id="edit_filter_message_div" style="display: none;">
					<?php for($i=1;$i<=10;$i++) :?>
						<div class="form-group" id="edit_filter_div_<?php echo $i; ?>" style="border: 1px solid #ccc; padding: 10px;">
							<label>
								Filter Word/Sentence <span class="red">*</span>
								<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="Message" data-content="Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, want to know, when"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input class="form-control filter_word" type="text" name="edit_filter_word_<?php echo $i; ?>" id="edit_filter_word_<?php echo $i; ?>" placeholder="write your filter word here">
							<br/>
							<label>
								Msg for private reply<span class="red">*</span>
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
							<textarea class="form-control message" name="edit_filter_message_<?php echo $i; ?>" id="edit_filter_message_<?php echo $i; ?>"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
							<br/>
							<label>
								Msg for comment reply<span class="red">*</span>
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
							<textarea class="form-control message" name="edit_comment_reply_msg_<?php echo $i; ?>" id="edit_comment_reply_msg_<?php echo $i; ?>"  placeholder="Type your message here..." style="height:170px;"></textarea>
							<div class='text-center' id=""><?php echo $emotion_list;?></div>
						</div>
					<?php endfor; ?>
						

						<br/>
						<div class="clearfix">
							<input type="hidden" name="edit_content_counter" id="edit_content_counter" />
							<button type="button" class="btn btn-sm btn-success pull-right" id="edit_add_more_button"><i class="fa fa-plus"></i> Add more filtering</button>
						</div>

						<div class="form-group" id="edit_nofilter_word_found_div" style="margin-top: 10px; border: 1px solid #ccc; padding: 10px;">
							<label>
								Comment reply if no matching found
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
							<br/>
							<label>
								Private reply if no matching found
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
							<textarea class="form-control message" name="edit_nofilter_word_found_text_private" id="edit_nofilter_word_found_text_private"  placeholder="Type your message here..." style="height:170px;"></textarea>
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


<div class="modal fade" id="manual_reply_by_post" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Please Provide a Post ID of Page (<span id="manual_page_name"></span>)</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-xs-12" id="waiting_div"></div>
                    <div class="col-xs-12 col-md-8 col-md-offset-2 well">
                        <form>
                            <div class="form-group">
                              <label for="manual_post_id">Post ID :</label>
                              <input type="text" class="form-control" id="manual_post_id" placeholder="Please give a post ID" value="">
                              <input type="hidden" id="manual_table_id">
                            </div><br/>
                            <div class="text-center" id="manual_reply_error"></div>
                            <div class="form-group text-center">
                              <button type="button" class="btn btn-warning" id="check_post_id"><i class=""></i> Check Existance</button>
                            </div>
                            <div class="form-group text-center">
                              <button type="button" class="btn btn-success enable_auto_commnet" id="manual_auto_reply"><i class="fa fa-plus"></i> Enable Auto Reply</button>
                            </div>
                          </form>
                        
                    </div>                    
                </div>               
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="manual_edit_reply_by_post" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Please Provide a Post ID of Page (<span id="manual_edit_page_name"></span>)</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-xs-12" id="waiting_div"></div>
                    <div class="col-xs-12 col-md-8 col-md-offset-2 well">
                        <form>
                            <div class="form-group">
                              <label for="manual_post_id">Post ID :</label>
                              <input type="text" class="form-control" id="manual_edit_post_id" placeholder="Please give a post ID" value="">
                              <input type="hidden" id="manual_edit_table_id">
                            </div><br/>
                            <div class="text-center" id="manual_edit_error"></div>
                            <div class="form-group text-center">
                              <button type="button" class="btn btn-info edit_reply_info" id="manual_edit_auto_reply"><i class="fa fa-pencil"></i> Edit Auto Reply</button>
                            </div>
                          </form>
                        
                    </div>                    
                </div>               
            </div>
        </div>
    </div>
</div>