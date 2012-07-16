<script type="text/javascript" >
$(document).ready(function() { 
 	$('#error').modal({
 		backdrop: "static"
 	});
    $('#testldap').modal('show') 
 
}); 
</script>
<div id="error" class="modal hide fade">
	<div class="modal-body">
		<center>
			<div class="alert alert-danger" ><b>Error</b></div>

			<div class="well">
				
					
					
					<?php
							if ($error_reason == "no period selected")
							{
								echo "<h3>No periods selected</h3>";
								echo "<br>";
								echo "You did not select any periods to book";
								
							}
							elseif ($error_reason == "period already booked")
							{
								echo "<h3>Period already booked</h3>";
								echo "<br>";
								echo "The period you selected is already booked";
							}
							elseif ($error_reason == "not admin block delete")
							{
								echo "<h3>Only administrator users can edit / delete block bookings</h3>";
								echo "<br>";
								echo "Please contact an administrator to make any changes";
								
							}
							elseif ($error_reason == "not your booking")
							{
								echo "<h3>This booking does not belong to you</h3>";
								echo "<br>";
								echo "You are only allowed to edit / delete your own bookings";
								
							}
							elseif ($error_reason == "multiple cells selected")
							{
								echo "<h3>You selected multiple bookings to edit / delete</h3>";
								echo "<br>";
								echo "You can only edit / delete one booking at a time";
								
							}
							elseif ($error_reason == "no bookings selected")
							{
								echo "<h3>You didn't select any bookings</h3>";
								echo "<br>";
								echo "Please select a booking before clicking the edit / delete buttons";
								
							}
							elseif ($error_reason == "cell is empty")
							{
								echo "<h3>You selected an empty cell</h3>";
								echo "<br>";
								echo "The cell you selected is empty, please select a cell with a booking";
								
							}
						?>
						<br><br>
						<a class="btn btn-info" href="<?php echo $previous_url;?>">back</a>
			</div>
		</center>
	</div>
</div>




<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
	
		</div>
	</div>
</div>