<?php $accesslevel = $this->session->userdata('accesslevel'); ?>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">
				<div class="span2">&nbsp;</div>
				
				
				
			<div class="span8 well">
				<center>
				<div class="alert alert-info"><h3>Booking to delete</h3></div>
					</center>
					<br>
					<div class="alert alert-info">
						<?php 
							echo 'Booked by : '.$displayname.'<br>'
							.'Date : '.$prettydate.'<br>'
							.'Period : '.$periodname.'<br>'
							.'Room : '.$roomname.'<br>'
							.'Class : '.$classname.'<br>'
							.'Subject : '.$subjectname
						;?>
						
					</div>
					
					<?php 
					if ($delete_type == "single")
					{?>
					<form class="form" method="post" action="<?php echo site_url('booking/booking/delete_booking'); ?>">
        			<fieldset>
        			<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">
        			<input type="hidden" name="booking_id" value="<?php echo $booking_id;?>">
        			<input type="hidden" name="delete_type" value="single">
        			<div class="form-actions">
            			<button type="submit" class="btn btn-danger">Confirm deletion</button>&nbsp;
            			<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
	           		</div>
	           		</fieldset>
	           		</form>
	           		<?php 
					}else{
						?>
					<form class="form" method="post" action="<?php echo site_url('booking/booking/delete_booking'); ?>">
        			<fieldset>
        				<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">
        				<input type="hidden" name="booking_id" value="<?php echo $booking_id;?>">
        				<input type="hidden" name="delete_type" value="block-single">
        				<button type="submit" class="btn btn-danger">Delete single booking</button>&nbsp;
            			<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
	           		</fieldset>
	           		</form>	
	           		
	           		<form class="form" method="post" action="<?php echo site_url('booking/booking/delete_booking'); ?>">
        			<fieldset>
	        			<input type="hidden" name="previous_url" value="<?php echo $previous_url;?>">
	        			<input type="hidden" name="booking_id" value="<?php echo $booking_id;?>">
	        			<input type="hidden" name="delete_type" value="block-all">
	        			<button type="submit" class="btn btn-danger">Delete entire block booking</button>&nbsp;
            		</fieldset>
	           		</form>	
					
					<?php }?>
				</div>
				
				<div class="span2">
					&nbsp;
				</div>
			</div>

		</div>
	</div>
</div>
