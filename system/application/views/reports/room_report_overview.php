<?php
// is the user authenticated and logged in?
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');

//if yes, show the page
if ($authenticated == 1 AND $accesslevel == "admin") {
?>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			
				
					<div class="span10 well">
			
			<div class="alert alert-info"><h4>Click on a room or resource to view usage reports for it</h4></div>
			<br>

				<?php foreach ($rooms as $room){ ?>

					
					<a class="btn span2" href="<?php echo site_url('reports/reports/room_report/'.$room['room_id']); ?>"> 
					
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
