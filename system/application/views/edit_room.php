<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<?php if ($room_image <> 'no-image.png'){?>
			<div class="span6 well">
			<?php }else{?>
			<div class="span10 well">
			<?php }?>
			
			<center>
				<div class="alert alert-info"><h3>Edit room - <?php echo $room_name; ?></h3></div>
			</center>
			
				<form class="form-horizontal" method="post" action="../update_room" enctype="multipart/form-data">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Room name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" name="room_name" value="<?php echo $room_name;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the room which will be seen by all users when making bookings"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Computer count</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " id="input02" name="pc_count" value="<?php echo $room_pc_count;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="How many computers are available to the user when they book this room?"></i></p>
            				</div>
            				<br>
            				
            				<div class="control-group">
            					<label class="control-label" for="input03">Room picture</label>
            					<div class="controls">
              						<input type="file" class="span4" name="userfile" value="<?php echo $room_image;?>"><br>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If left blank, currently stored image is used"></i></p>
            					</div>
          					</div>
          		
          					<div class="control-group">
            					<label class="control-label" for="deleteimage">Delete room image</label>
            					<div class="controls">
              						<select name= "deleteimage" id="deleteimage">
										<option value="0">No</option>
                						<option value="1">Yes</option>
            					
	               				    </select>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If yes, images associated with this room will be removed"></i></p>
            					</div>
          					</div>
          					 
          					 <input type="hidden" name="room_id" value="<?php echo $room_id;?>">
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Update room</button>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
			
			<?php if ($room_image <> 'no-image.png'){?>
			<div class="span4 well"><img src="<?php echo base_url();?>img/room_images/<?php echo $room_image;?>"></div>
			<?php }?>
			
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
