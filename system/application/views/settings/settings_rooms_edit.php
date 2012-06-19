<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Rooms &amp; Resources</h3></div>
			</center>
			<h4>Click on a room/resource to edit it</h4>
			<br>

				<?php foreach ($rooms as $room){ ?>

					
					<a class="btn span2" href="edit_room/<?php echo $room['room_id'];?>"> 
					
					<h4><?php echo $room['room_name'] ?></h4>
					
					<?php if ($room['room_pc_count'] > 1)
					{?>
					<h5><?php echo $room['room_pc_count'] ?> machines available</h5>
			  		<?php } elseif ($room['room_pc_count'] ==1) { ?>
					<h5><?php echo $room['room_pc_count'] ?> machine available</h5>
					<?php }else {?> 
					<br><?php }?>
					
					<img src="<?php echo base_url('/img/room_images')?>/<?php echo $room['room_image_tn'];?>">
					
					</a>

				<?php }?>
				
				<div class="span10">
					<br>
					<a class="btn btn-primary" href="add_room"><i class="icon-plus"></i> Add a new room / resource</a>

				</div>
				
			</div>
		</div>
			

			<div class="span1">
				&nbsp;
			</div>

		</div>
		
	</div>
</div>
