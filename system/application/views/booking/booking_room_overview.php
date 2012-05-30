<style>

.ui-selecting { background: #FECA40; }
.ui-selected { background: #F39814;  }

	</style>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			<div class="span10">

				<center><h4 class="span8">Bookings for the week commencing <?php echo $week_commencing;?></h4></center>
				<br><br>
				<table class="table span8 table-bordered" id="selectable">

  				<thead>
   					<tr style="width:60px;">
						<th width="9%">&nbsp;</th>
						<th width="13%"><div>Monday</div></th>
						<th width="13%"><div>Tuesday</div></th>
						<th width="13%"><div>Wednesday</div></th>
						<th width="13%"><div>Thursday</div></th>
						<th width="13%"><div>Friday</div></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($periods as $period)
				{
				?>
					<tr 
					<?php
	 				if ($period['period_bookable'] == true) 
					{
						echo 'style="height:60px"';
					}
					else
					{
						echo 'style="height:10px"';
					}
					?>
					>
	
					<td>		
					<?php
					echo '<center><div>'.$period['period_name'].'<br />';
					if ($period['period_bookable'] == true)
					{
						echo '<em><small>'.$period['period_start'].' - '.$period['period_end'].'</small></em>';
					}
					echo '</div></center>';
					?>
					</td>
		
					<?php for ($i = 0; $i <= 4; $i++)
					{
						echo '<td ';
						$bookable = 1; // Needs to be reset to 1 each time the loop is run
						list($year,$month,$day) = explode('-', $date);
						$time = mktime(0,0,0,$month,$day+$i,$year);
						$newdate = date('Y-m-d', $time);
			
						foreach ($bookings as $booking) 
						{
							$bookable = 1;
							// Find all bookings that are block bookings for this item.
							if ($booking['booking_isblock'] == true) 
							{
								// Split down the date to figure out which day the block booking should
								// appear on, i.e. Fri which would return the number 5. Because our loop starts
								// at 0, we need to subtract one from the figure
								list($tmpyear,$tmpmonth,$tmpday) = explode('-', $booking['booking_date']);
								$daynum = date('w',mktime(0,0,0,$tmpmonth,$tmpday,$tmpyear)) - 1;
							}
							// If the current loop matches the exact and period, or is block booking and
							// matches the day number and period, we echo it to the table 
							if ($booking['period_id'] == $period['period_id'] && $booking['booking_date'] == $newdate || $booking['booking_isblock'] == true && $booking['period_id'] == $period['period_id'] && $daynum == $i)
							{
							// Find out if the user wants booked lessons to be shaded differently
								if ($booking['subject_use_shading'] == 1)
								{
									echo 'style="background-color:#'.$booking['subject_colour'].';height:90px;">';
								}
								else 
								{
							//if no shading, just close the <td>
									echo 'style="height:90px">';
								}

								
								
								echo '<div class="bookable" style="height:100%;">';
								echo $booking['booking_classname'].'<br />'.$booking['subject_name'].'<br />'.$booking['booking_displayname'];
								if ($booking['booking_isblock'] == true)
								{
									//echo '<div>';
									echo '<br><i class="icon-retweet"></i>';
									//echo '</div>';
								}
								echo '</div>';
						
								//if ($this->session->userdata('authenticated'))
								//{
//									if ($this->session->userdata('accesslevel') == 'admin' || $this->session->userdata('username') == $booking['booking_username'])
									//{
										//echo '<div>';
										//echo '<a href="delete" title="Delete Booking">';
										//echo '<i class="icon-minus pull-right"></i>';
										//echo '</a>';
									//}
								//}
						
						
								// This cell is not bookable now, so we mark it as such and break
								$bookable = 0;
								break; // No point in keep looping, we've already found our booking for today
							}
							
						}
	
						// However, if a booking has not been found, and this cell is marked as bookable
						// we will show an add link, allowing the user to book this available space
						if ($bookable == 1 && $period['period_bookable'] == true && $this->session->userdata('authenticated'))
						{
							echo 'style="height:90px"><div class="bookable" style="height:100%;">';
							echo '<center><br><br><i class="icon-plus"></i></center>';
							echo '</div>';
						}
			
					   /*
						* not needed just yet as users not logged in cannot see the booking pages
						* this might change in the future so non-authenticated users can still
						* see the timetable
						* 
						*
						*elseif ($bookable == 1 && $period['period_bookable'] == true && !$this->session->userdata('authenticated'))
						*{
						*	echo '<div style="color:#CCC;"><small><i>You need to login to book this session</i></small></div>';
						*} 
						*/
						echo '</td>';
					}
					?>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
			
				<div class="span2">
<p id="feedback">
<span>You've selected:</span> <span id="select-result">none</span>.
</p>
				</div>
			
			</div>
			

			<div class="span1">
				&nbsp;
			</div>
			
		</div>
	</div>
</div>


	
	
	<script>
	$(function() 
	{
		$("table").selectable({
			  filter: ".bookable",
				stop: function() {
					var result = $( "#select-result" ).empty();
					$( ".ui-selected", this ).each(function() {
						var index = $( "#selectable div" ).index( this );
						result.append( " #" + ( index + 1 ) );
					});
				}
			});
		$( "#datepicker" ).datepicker(
		{
			dateFormat: 'yy-mm-dd',
			showOtherMonths: true,
			selectOtherMonths: true,
			beforeShowDay: $.datepicker.noWeekends,
			showOn: "button",
			buttonImage: "<?php echo base_url('javascript/images/calendar.gif');?>",
			buttonImageOnly: true,
			onSelect: function(date, instance) 
			{
				window.location = "<?php echo site_url('booking/booking/booking_room_overview/' . $room_id) ?>/" + date;
    		}
		});
	});
	</script>

