<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Add a room</h3></div>
			</center>
			
			<?php if ($error != ' ') { ?>
			<div class="alert alert-error"><?php echo $error; ?></div>
			<?php }?>
			
				<form class="form-horizontal" method="post" action="submit_new_room" enctype="multipart/form-data">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Room name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" name="room_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the room which will be seen by all users when making bookings"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Computer count</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " id="input02" name="pc_count">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="How many computers are available to the user when they book this room?"></i></p>
            				</div>
            				<br>
            				<div class="control-group">
            					<label class="control-label" for="allow_local_login">Room picture</label>
            					<div class="controls">
              						<input type="file" class="span4" name="userfile"><br>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="JPG/PNG/GIF (less than 100k) image of the room.  A thumbnail of this image will be used on the main booking page"></i></p>
            					</div>
          					</div>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Add room</button>
            					<a class="btn btn-info" href="room_settings">back</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
			
				<script type="text/javascript"> 
  					$(document).ready(function () { 
    				$("[rel=tooltip]").tooltip(); 
  					}); 
				</script> 

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
