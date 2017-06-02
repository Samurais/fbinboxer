<div class="container-fluid">
	<div class="row">
		<div class="text-center blue"><h2 style="font-weight:900;"><?php echo $this->lang->line('Lifetime Sammary'); ?></h2></div>
	</div>
	<hr>
	<div class="row" style="padding-top:10px;">
		
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid green;border-bottom:2px solid green;">
				<span class="info-box-icon bg-green"><i class="fa fa-check-circle"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Total Subscriber");?></span>
					<span class="info-box-number">
						<?php echo number_format($subscriber_number); ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #DD4B39;border-bottom:2px solid #DD4B39;">
				<span class="info-box-icon bg-red"><i class="fa fa-times"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Total Unsubscriber");?></span>
					<span class="info-box-number">
						<?php echo number_format($unsubscriber_number); ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #3C8DBC;border-bottom:2px solid #3C8DBC;">
				<span class="info-box-icon bg-blue"><i class="fa fa-envelope" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Total messages sent");?></span>
					<span class="info-box-number">
						<?php echo number_format($message_number); ?>						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
	</div>
	<br/>
	<div class="row" style="padding-top:10px;">
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box bg-green">
				<span class="info-box-icon"><i class="fa fa-check-circle"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number"><?php echo $campaign_details_completed; ?></span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("campaign completed"); ?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>

		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box bg-orange">
				<span class="info-box-icon"><i class="fa fa-spinner" aria-hidden="true"></i></span>
				<div class="info-box-content">				
					<span class="info-box-number"><?php echo $campaign_details_processing; ?></span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("Campaign Processing"); ?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>

		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box bg-red">
				<span class="info-box-icon"><i class="fa fa-times"></i></span>
				<div class="info-box-content">				
					<span class="info-box-number"><?php echo $campaign_details_pending; ?></span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("Campaign Pending"); ?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>

	</div>
	<br/><br/>
	<div class="row">
		<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('MESSAGE SENT VS CAMPAIGN CREATED REPORT FOR LAST 12 MONTHS'); ?></h2></div>
		<div id='div_for_bar'></div>
	</div>
	<?php
		$bar = $chart_bar;		
	?>
	
	<br/><br/>
	<div class="row" style="padding-top:10px;">
  		
  		
  		<div class="col-md-6">
  			<!-- DONUT CHART -->
			<div class="box box-success box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Recently Completed Campaign</h3>					
				</div>
				<div class="box-body chart-responsive" style="display: block;">
					<div class="box-body">
						<div class="row">
							<?php 
				  				
				  				//print_r($last_campaign_completed_info);

				  				echo "</pre>";

				  				echo "<div class='table-responsive'><table class='table table-bordered table-hover table-striped table-condensed'>";

				  				echo "<tr>";
			  						echo "<th>SL</th>";
			  						echo "<th>Campaign name</th>";
			  						echo "<th>Created at</th>";
			  						echo "<th>Total Message sent</th>";
			  					echo "</tr>";

				  				$sl=0;
				  				foreach ($last_campaign_completed_info as $key => $value) 
				  				{
				  					$sl++;
				  					echo "<tr>";
				  						echo "<td>".$sl."</td>";
				  						echo "<td>".$value["campaign_name"]."</td>";
				  						echo "<td>".$value["added_at"]."</td>";
				  						echo "<td>".$value["successfully_sent"]."</td>";
				  					echo "</tr>";
				  				}
				  				if($sl==0) echo "<tr><td class='text-center' colspan='4'>No data found.</td></tr>";
				  				echo "</table></div>";
				  			?>
						</div><!-- /.row -->
					</div><!-- /.box-body -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->	
  		</div>
  		
  		<div class="col-md-6">
  			<!-- DONUT CHART -->
			<div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Pending Campaign </h3>					
				</div>
				<div class="box-body chart-responsive" style="display: block;">
					<div class="box-body">
						<div class="row">
							<?php 
				  				
				  				// echo "<pre>";
				  				// print_r($last_campaign_pending_info);
// 
				  				// echo "</pre>";

				  				echo "<div class='table-responsive'><table class='table table-bordered table-hover table-striped table-condensed'>";

				  				echo "<tr>";
			  						echo "<th>SL</th>";
			  						echo "<th>Campaign name</th>";
			  						echo "<th>Schedule Time</th>";
			  						echo "<th>Selected Message</th>";
			  					echo "</tr>";

				  				$sl=0;
				  				foreach ($last_campaign_pending_info as $key => $value) 
				  				{
				  					$sl++;
				  					echo "<tr>";
				  						echo "<td>".$sl."</th>";
				  						echo "<td>".$value["campaign_name"]."</td>";
				  						echo "<td>".$value["schedule_time"]."</td>";
				  						echo "<td>".$value["total_thread"]."</td>";
				  					echo "</tr>";
				  				}
				  				if($sl==0) echo "<tr><td class='text-center' colspan='4'>No data found.</td></tr>";
				  				echo "</table></div>";
				  			?>
						</div><!-- /.row -->
					</div><!-- /.box-body -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
  		</div>
	</div>
	<br/><br/>
	<div class="row">
		<div class="text-center blue"><h2 style="font-weight:900;">Monthly Sammary (<?php echo date("M-Y");?>)</h2></div>
	</div>
	<hr>
	<div class="row" style="padding-top:10px;">
		
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid green;border-bottom:2px solid green;">
				<span class="info-box-icon bg-green"><i class="fa fa-check-circle"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Campaign Complete");?></span>
					<span class="info-box-number">
						<?php echo $campaign_completed_this_month; ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #00C0EF;border-bottom:2px solid #00C0EF;">
				<span class="info-box-icon bg-aqua"><i class="fa fa-user" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Total Subscriber");?></span>
					<span class="info-box-number">
						<?php echo $subscribergained_this_month; ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #3C8DBC;border-bottom:2px solid #3C8DBC;">
				<span class="info-box-icon bg-blue"><i class="fa fa-comments" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Total messages sent");?></span>
					<span class="info-box-number">
						<?php echo $message_number_month; ?>						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
	</div>
	<br/><br/>
	<div class="row">
		<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('Lead Generation Information'); ?></h2></div>
	</div>
	<div class="row" style="padding-top:10px;">
		<div class="col-md-12">
			<!-- DONUT CHART -->
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Last Auto Reply</h3>					
				</div>
				<div class="box-body chart-responsive" style="display: block;">
					<div class="box-body">
						<div class="row">
							<?php 
				  				
				  				//print_r($last_campaign_completed_info);

				  				echo "</pre>";

				  				echo "<div class='table-responsive'><table class='table table-bordered table-hover table-striped table-condensed'>";

				  				echo "<tr>";
			  						echo "<th>SL</th>";
			  						echo "<th>Reply To</th>";
			  						echo "<th>Reply Time</th>";
			  						echo "<th>Post Name</th>";
			  					echo "</tr>";

				  				$sl=0;
				  				foreach ($my_last_auto_reply_data as $key => $value) 
				  				{
				  					$sl++;
				  					echo "<tr>";
				  						echo "<th>".$sl."</th>";
				  						echo "<th>".$value["name"]."</th>";
				  						echo "<th>".$value["reply_time"]."</th>";
				  						echo "<th>".$value["post_name"]."</th>";
				  					echo "</tr>";
				  				}
				  				if($sl==0) echo "<tr><td class='text-center' colspan='4'>No data found.</td></tr>";
				  				echo "</table></div>";
				  			?>
						</div><!-- /.row -->
					</div><!-- /.box-body -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->		

  			
  		</div>
	</div>
	<br/><br/>
	<div class="row" style="padding-top:10px;">
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #00C0EF;border-bottom:2px solid #00C0EF;">
				<span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Auto Reply Enabled Post");?></span>
					<span class="info-box-number">
						<?php echo $auto_reply_enable; ?>	
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid green;border-bottom:2px solid green;">
				<span class="info-box-icon bg-green"><i class="fa fa-reply-all" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Auto Reply Sent");?></span>
					<span class="info-box-number">
						<?php echo $total_auto_replay; ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div class="info-box" style="border:1px solid #0073B7;border-bottom:2px solid #0073B7;">
				<span class="info-box-icon bg-blue"><i class="fa fa-comments" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("Chat Plugin Enabled");?></span>
					<span class="info-box-number">
						<?php echo $chat_plugin_enable; ?>
						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
	</div>

</div>
<script>
	$j("document").ready(function(){
		var pieOptions = {
			//Boolean - Whether we should show a stroke on each segment
			segmentShowStroke: true,
			//String - The colour of each segment stroke
			segmentStrokeColor: "#fff",
			//Number - The width of each segment stroke
			segmentStrokeWidth: 2,
			//Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 25, // This is 0 for Pie charts
			//Number - Amount of animation steps
			animationSteps: 100,
			//String - Animation easing effect
			animationEasing: "easeOutBounce",
			//Boolean - Whether we animate the rotation of the Doughnut
			animateRotate: true,
			//Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale: false,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: true,
			// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: false
	  	};

		//-------------
		//- PIE CHART -
		//-------------
		// var campaign_info_chart_data = $("#campaign_info_chart_data").val();
		// // Get context with jQuery - using jQuery's .get() method.
		// var pieChartCanvas = $("#campaign_data_pieChart").get(0).getContext("2d");
		// var pieChart = new Chart(pieChartCanvas);
		// var PieData = JSON.parse(campaign_info_chart_data);

		// You can switch between pie and douhnut using the method below.  
		// pieChart.Doughnut(PieData, pieOptions);

		Morris.Bar({
	  		element: 'div_for_bar',
	  		data: <?php echo json_encode($bar); ?>,
	  		xkey: 'year',
	  		ykeys: ['sent_message', 'sent_campaign'],
	  		labels: ['Total Message Sent', 'Total Campaign Created']
		});

	});
</script>