<style>

.ui-selecting { background: #FECA40; }
.ui-selected { background: #F39814; color: white; }


	</style>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			<table class="span10" border="1">
  				<tbody>
   					<tr style="background-color:#ABABAB;">
						<th width="5%">&nbsp;</th>
						<th width="10%"><div class="btn btn-inverse ">Monday</div></th>
						<th width="10%"><div class="btn btn-inverse ">Tuesday</div></th>
						<th width="10%"><div class="btn btn-inverse ">Wednesday</div></th>
						<th width="10%"><div class="btn btn-inverse ">Thursday</div></th>
						<th width="10%"><div class="btn btn-inverse ">Friday</div></th>
					</tr>

				<?php foreach ($periods as $period)
				{
				?>
					<tr 
					<?php
	 				if ($period['period_bookable'] == true) 
					{
						echo 'style="height:60px;"';
					}
					else
					{
						echo 'style="background-color:#D0D0D0;"';
					}
					?>
					>
	
					<td>		
					<?php
					echo '<center><div class="btn btn-inverse">'.$period['period_name'].'<br />';
					if ($period['period_bookable'] == true)
					{
						echo '<i><small>'.$period['period_start'].' - '.$period['period_end'].'</small></i>';
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
									echo 'style="background-color:#'.$booking['subject_colour'].';">';
								}
								echo '<div>';
								echo $booking['booking_classname'].'<br />'.$booking['subject_name'].'<br />'.$booking['booking_displayname'];
								if ($booking['booking_isblock'] == true)
								{
									//echo '<div>';
									echo '<br><i class="icon-retweet"></i>';
									//echo '</div>';
								}
								echo '</div>';
						
								if ($this->session->userdata('authenticated'))
								{
									if ($this->session->userdata('accesslevel') == 'admin' || $this->session->userdata('username') == $booking['booking_username'])
									{
										//echo '<div>';
										echo '<a href="#delete" title="Delete Booking">';
										echo '<i class="icon-minus pull-right"></i>';
										echo '</a>';
									}
								}
						
						
								// This cell is not bookable now, so we mark it as such and break
								$bookable = 0;
								break; // No point in keep looping, we've already found our booking for today
							}
							
						}
	
						// However, if a booking has not been found, and this cell is marked as bookable
						// we will show an add link, allowing the user to book this available space
						if ($bookable == 1 && $period['period_bookable'] == true && $this->session->userdata('authenticated'))
						{
							echo 'style="height:90px"><div class="tdItem" style="height:100%;"></div>';
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

			<div class="span1">
				&nbsp;
			</div>
			
		</div>
	</div>
</div>

<script>
$("table").selectable({
  filter: ".tdItem"
});
</script>