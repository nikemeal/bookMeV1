<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">
				<div class="span2">&nbsp;</div>
				
				<div class="span4 well">
			<center>
				<div class="alert alert-info"><h3>Booking multi-information</h3></div>
			</center>
				<form class="form" id="booking" method="post" action="<?php echo site_url('booking/booking/add_booking'); ?>">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="booking_classname">Class</label>
            				<div class="controls">
              					<input type="text" class="input" value="" name="booking_classname">
              				
            				</div>
            				<br>
            				
            				<div class="control-group">
            					<label class="control-label" for="subject_id">Subject</label>
            					<div class="controls">
              						<select name= "subject_id">
                					<?php 
                					$subjects = $this->Settings_model->get_all_subjects();
                					foreach ($subjects as $subject)
                					{
                						echo '<option value="'.$subject['subject_id'].'">'.$subject['subject_name'].'</option>';
                					}
                					?>
                				    </select>
					            	
            					</div>
          					</div>
          					<?php 
          					$count = '1';
          					foreach ($bookings as $booking)
          					{?>
            				<input type="hidden" name="booking[<?php echo $count;?>][period_id]" value="<?php echo $booking['period_id'];?>">
            				<input type="hidden" name="booking[<?php echo $count;?>][room_id]" value="<?php echo $booking['room_id'];?>">  
            				<input type="hidden" name="booking[<?php echo $count;?>][booking_username]" value="<?php echo $this->session->userdata('username');?>">
            				<input type="hidden" name="booking[<?php echo $count;?>][booking_displayname]" value="<?php echo $this->session->userdata('fullname');?>">
            				<input type="hidden" name="booking[<?php echo $count;?>][booking_date]" value="<?php echo $booking['booking_date'];?>">
            				<input type="hidden" name="booking_type" value="<?php echo $booking_type;?>">
            				<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">  
            			<?php 
          					$count = $count + 1;
          					}
          					
          					?>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Confirm booking</button>
            					<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
	           				</div>
            		
            			</div>
        			</fieldset>
      			</form>
			</div>
				
			<div class="span4 well">
				<center>
				<div class="alert alert-info"><h3>Your selection/s</h3></div>
					</center>
					<br>
					
				<?php 
				foreach ($bookings as $booking)
				{?>
					<div class="alert alert-info">
					<?php echo $booking['booking_period'] . '<br>' . $booking['booking_dayname'] . ' ' . $booking['prettydate'] .'<br>' . $booking['booking_room'];?>
					</div>
				<?php }	?>
				</div>
				
				<div class="span2">
					&nbsp;
				</div>
			</div>
			
		</div>
	</div>
</div>