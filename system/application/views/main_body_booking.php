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
			
			<div class="alert alert-info"><h4>Click on a room or resource to make a booking for it</h4></div>
			<br>

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

<div id="loginbox" class="modal hide fade">
	<div class="modal-body">
		<button class="close" data-dismiss="modal">×</button>
		<br><br>
		<center>
			<button class="btn btn-danger span5" >Please enter your login details</button>
		<br><br>
			<form class="well" action="<?php echo site_url(); ?>/main/processlogin" method="post" id="processlogin" name="login">
				<label>Username</label>
				<input class="span2" id="username" size="16" type="text" name="username">
					<br>
				<label>Password</label>
				<input class="span2" id="password" size="16" type="password" name="password">
					<br>
					<br>
				<button type="submit" class="btn">Submit</button>
			</form>
		</center>
	</div>
</div>
	<script type="text/javascript" language="JavaScript">
		$('#loginbox').on('shown', function () {
		$("input#username").focus();
		});
		
	</script>
	
 

