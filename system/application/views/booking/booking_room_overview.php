<style>

.ui-selecting { background: #FECA40; }
.ui-selected { background: #F39814;  }

	</style>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">

				<center><h4 class="span10">Bookings for the week commencing <?php echo $week_commencing;?></h4></center>
				<br><br>
				<table class="table span10 table-bordered" id="selectable">

  				<thead>
   					<tr style="width:100px;">
						<th width="6%">&nbsp;</th>
						<th width="10%"><div>Monday</div></th>
						<th width="10%"><div>Tuesday</div></th>
						<th width="10%"><div>Wednesday</div></th>
						<th width="10%"><div>Thursday</div></th>
						<th width="10%"><div>Friday</div></th>
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
						echo 'style="height:10px;"';
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
							
							// If the current loop matches the exact and period, or is block booking and
							// matches the day number and period, we echo it to the table 
							if ($booking['period_id'] == $period['period_id'] && $booking['booking_date'] == $newdate )
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

								
								
								echo '<div class="selectable" data-day="'.$i.'" data-period="'.$period['period_id'].'" data-bookingid="'.$booking['booking_id'].'" data-room="'.$room_id.'" data-date="'.$newdate.'" data-bookable="0" style="height:100%;">';
								if ($booking['booking_isblock'] == true)
								{
									echo "<b>";
								}
								echo $booking['booking_classname'].'<br />'.$booking['subject_name'].'<br />'.$booking['booking_displayname'];
								if ($booking['booking_isblock'] == true)
								{
									
									echo '<br><i class="icon-retweet"></i>';
									
								}
								echo '</div>';
					
								// This cell is not bookable now, so we mark it as such and break
								$bookable = 0;
								break; // No point in keep looping, we've already found our booking for today
							}
							
						}
	
						// However, if a booking has not been found, and this cell is marked as bookable
						// we will show an add link, allowing the user to book this available space
						if ($bookable == 1 && $period['period_bookable'] == true && $this->session->userdata('authenticated'))
						{
							echo 'style="height:90px"><div data-day="'.$i.'" data-date="'.$newdate.'" data-period="'.$period['period_id'].'" data-room="'.$room_id.'" data-bookable="1" class="selectable" style="height:100%;">';
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
				<div id="datepicker">
				</div>
				<br>

					
					<form  method="post" action="<?php echo site_url('booking/booking/process_booking'); ?>" id="add">
						<input type="hidden" name="url" value="<?php echo current_url()?>">
						<button type="submit" class="btn btn-success">Book selected period(s)</button>
      				</form>
      				
      				<form  method="post" action="<?php echo site_url('booking/booking/process_edit_booking'); ?>" id="edit">
						<input type="hidden" name="url" value="<?php echo current_url()?>">
						<button type="submit" class="btn btn-info">Edit selected booking</button>
      				</form>
      				
      				<form  method="post" action="<?php echo site_url('booking/booking/process_delete_booking'); ?>" id="delete">
						<input type="hidden" name="url" value="<?php echo current_url()?>">
						<button type="submit" class="btn btn-danger">Delete selected booking</button>
      				</form>
      				

		
				</div>
			
			</div>
			
		</div>
	</div>
</div>


	<script>
	$(function() 
	{
		 $( "#selectable" ).selectable({ 
		     filter: ".selectable", 

			unselected: (function(){
				//in the future, see if there's a way to allow de-selection
				//of individual cells rather than blanket removal
					$('div').removeClass('ui-selected');
					$(".js-added").remove();
	
			}),
				    
		     stop: function() { 
		
             var count = 0;
		            $( ".ui-selected", this ).each(function() { 

		            	var data = $(this).data(); 
		                $(data).each(function(key, value){ 
		                	var room_id = document.createElement("input"); 
		                    room_id.setAttribute("type", "hidden"); 
		                    room_id.setAttribute("name", "booking["+count+"][room]"); 
		                    room_id.setAttribute("value", data.room);
		                    room_id.setAttribute("class", "js-added");  
		                    document.getElementById("add").appendChild(room_id);
		                    var date_id = document.createElement("input"); 
		                    date_id.setAttribute("type", "hidden"); 
		                    date_id.setAttribute("name", "booking["+count+"][date]"); 
		                    date_id.setAttribute("value", data.date); 
		                    date_id.setAttribute("class", "js-added");
		                    document.getElementById("add").appendChild(date_id);
		                    var period_id = document.createElement("input"); 
		                    period_id.setAttribute("type", "hidden"); 
		                    period_id.setAttribute("name", "booking["+count+"][period]"); 
		                    period_id.setAttribute("value", data.period);
		                    period_id.setAttribute("class", "js-added"); 
		                    document.getElementById("add").appendChild(period_id); 
		                    var day_id = document.createElement("input"); 
		                    day_id.setAttribute("type", "hidden"); 
		                    day_id.setAttribute("name", "booking["+count+"][day]"); 
		                    day_id.setAttribute("value", data.day);
		                    day_id.setAttribute("class", "js-added"); 
		                    document.getElementById("add").appendChild(day_id); 
		                    var bookable_id = document.createElement("input"); 
		                    bookable_id.setAttribute("type", "hidden"); 
		                    bookable_id.setAttribute("name", "booking["+count+"][bookable]"); 
		                    bookable_id.setAttribute("value", data.bookable);
		                    bookable_id.setAttribute("class", "js-added"); 
		                    document.getElementById("add").appendChild(bookable_id);
		                    var bookable_id_delete = document.createElement("input"); 
		                    bookable_id_delete.setAttribute("type", "hidden"); 
		                    bookable_id_delete.setAttribute("name", "booking["+count+"][bookable]"); 
		                    bookable_id_delete.setAttribute("value", data.bookable);
		                    bookable_id_delete.setAttribute("class", "js-added"); 
		                    document.getElementById("delete").appendChild(bookable_id_delete);
		                    var booking_id_delete = document.createElement("input"); 
		                    booking_id_delete.setAttribute("type", "hidden"); 
		                    booking_id_delete.setAttribute("name", "booking["+count+"][booking_id]"); 
		                    booking_id_delete.setAttribute("value", data.bookingid);
		                    booking_id_delete.setAttribute("class", "js-added"); 
		                    document.getElementById("delete").appendChild(booking_id_delete);
		                    var bookable_id_edit = document.createElement("input"); 
		                    bookable_id_edit.setAttribute("type", "hidden"); 
		                    bookable_id_edit.setAttribute("name", "booking["+count+"][bookable]"); 
		                    bookable_id_edit.setAttribute("value", data.bookable);
		                    bookable_id_edit.setAttribute("class", "js-added"); 
		                    document.getElementById("edit").appendChild(bookable_id_edit);
		                    var booking_id_edit = document.createElement("input"); 
		                    booking_id_edit.setAttribute("type", "hidden"); 
		                    booking_id_edit.setAttribute("name", "booking["+count+"][booking_id]"); 
		                    booking_id_edit.setAttribute("value", data.bookingid);
		                    booking_id_edit.setAttribute("class", "js-added"); 
		                    document.getElementById("edit").appendChild(booking_id_edit);
		                    count = count + 1;
		               }); 
		 	       }); 
		        } 
	        });

		$( "#datepicker" ).datepicker(
		{
			dateFormat: 'yy-mm-dd',
			showOtherMonths: true,
			showButtonPanel: true,
			selectOtherMonths: true,
			beforeShowDay: $.datepicker.noWeekends,
			<?php 
				if (!$datepicker == '')
				{
					echo "defaultDate: '".$datepicker."',";
				}
			?>
			onSelect: function(date, instance) 
			{
				window.location = "<?php echo site_url('booking/booking/booking_room_overview/' . $room_id) ?>/" + date;
    		}
		});
	});
	function clearselection()
	{
		$('div').removeClass('ui-selected');
		$(".js-added").remove();
	}	
	</script>

