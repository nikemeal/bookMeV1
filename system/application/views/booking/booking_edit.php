<?php $accesslevel = $this->session->userdata('accesslevel'); ?>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">
				<div class="span2">&nbsp;</div>
				
				
				
			<div class="span8 well">
				<center>
				<div class="alert alert-info">
					<h3>Booking to edit</h3>
				</div>
									<?php 
					if ($bookingtype == "block"){?>
					<h4 class="alert alert-danger">You are editing a block booking - this will edit the entire block!</h4>
					<?php }?>
					</center>
					<br>
					<form class="form" id="booking" method="post" action="<?php echo site_url('booking/booking/edit_booking'); ?>">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="booking_classname">Class</label>
            				<div class="controls">
              					<input type="text" class="input" value="<?php echo $classname; ?>" name="booking_classname">
              				
            				</div>
            				<br>
            				
            				<div class="control-group">
            					<label class="control-label" for="subject_id">Subject</label>
            					<div class="controls">
              						<select name= "subject_id">
                					<?php 
                					
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
								<input type="text" name="booking_username" class="required" value="<?php echo $username;?>">
            					</div>
            					<br>
            					<label class="control-label" for="block_displayname">Display name</label>
            					<div class="controls">
            						 <input type="text" name="booking_displayname" class="required" value="<?php echo $displayname;?>">
            					</div>
            					<?php }?>
          					</div>
            			
            				<?php if($accesslevel !== 'admin'){?>
							<input type="hidden" name="booking_username" value="<?php echo $username;?>">
            				<input type="hidden" name="booking_displayname" value="<?php echo $displayname;?>">
							<?php }	?>
            				    				            			
							<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">
        					<input type="hidden" name="booking_id" value="<?php echo $booking_id;?>">
        					
        					<?php if ($bookingtype == "single") {?>
        					<div class="form-actions">
            					<input type="hidden" name="edit_type" value="single">
            					<button type="submit" class="btn btn-primary">Edit booking</button>&nbsp;
            					<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
			           		</div>
			           		<?php 
        					}else{?>
	           				<div class="form-actions">
            					<input type="hidden" name="edit_type" value="block">
            					<button type="submit" class="btn btn-danger">Edit block booking</button>&nbsp;
            					<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
			           		</div>
	           		<?php }?>
			           		
            			</div>
        			</fieldset>
      			</form>
					
					
				</div>
				
				<div class="span2">
					&nbsp;
				</div>
			</div>

		</div>
	</div>
</div>
<script>
$(document).ready(function () 
{ 
	$("#booking").validate();
});
</script>