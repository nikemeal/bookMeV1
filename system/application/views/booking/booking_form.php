<?php $accesslevel = $this->session->userdata('accesslevel'); ?>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">
				<div class="span2">&nbsp;</div>
				
				<div class="span4 well">
			<center>
				<div class="alert alert-info"><h3>Booking information</h3></div>
			</center>
				<form class="form" method="post" action="<?php echo site_url('booking/booking/add_booking'); ?>">
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
            					
                				<?php if ($accesslevel == 'admin') {?>
            					<br>
            					<label class="control-label" for="block_username">Username</label>
            					<div class="controls">
								<input type="text" name="booking_username" value="<?php echo $this->session->userdata('username');?>">
            					</div>
            					<br>
            					<label class="control-label" for="block_displayname">Display name</label>
            					<div class="controls">
            						 <input type="text" name="booking_displayname" value="<?php echo $this->session->userdata('fullname');?>">
            					</div>
            					<br>
            					<label class="control-label" for="block_booking">Block Booking?</label>
            					<div class="controls">
            						 <input type="checkbox" id="booking_isblock" name="booking_isblock" value="true">
            					</div>
            					<?php }?>
          					</div>
            			
            				<input type="hidden" name="period_id" value="<?php echo $period_id;?>">
            				<input type="hidden" name="room_id" value="<?php echo $room_id;?>">  
            				<?php if($accesslevel !== 'admin'){?>
							<input type="hidden" name="booking_username" value="<?php echo $this->session->userdata('username');?>">
            				<input type="hidden" name="booking_displayname" value="<?php echo $this->session->userdata('fullname');?>">
							<?php }	?>
            				<input type="hidden" name="booking_date" value="<?php echo $booking_date;?>">
            				<input type="hidden" name="booking_type" value="<?php echo $booking_type;?>">
            				<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">  
            			
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
					<div class="alert alert-info">
					<!-- need to add a foreach loop here to accomodate multi bookings -->
						<?php echo $booking_period . '<br>' . $booking_dayname . ' ' . $prettydate .'<br>' . $booking_room;?>
					</div>
				</div>
				
				<div class="span2">
					&nbsp;
				</div>
			</div>

		</div>
	</div>
</div>
