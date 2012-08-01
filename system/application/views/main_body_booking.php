<?php

// is the user authenticated and logged in?
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');

//if yes, show the following 
if ($authenticated == 1) {
?>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

					<div class="span10 well">
			<center>
			<div class="label label-info span4"><font size="2">Click on a room or resource to make a booking for it</font></div>
			</center>
			<br><br>

				<?php foreach ($rooms as $room){ ?>

					
					<a class="btn span2" href="<?php echo site_url('booking/booking/booking_room_overview/'.$room['room_id']); ?>"> 
					
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
				
				
			</div>

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>

<?php 
}?>


	
 

