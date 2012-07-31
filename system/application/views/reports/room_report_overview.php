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
			
				<div class="label label-info span5">
					<font size="2">Click on a room or resource to view detailed usage reports for it</font>
				</div>
				<br><br>

				<?php foreach ($rooms as $room){ ?>

					<a class="btn span2" href="<?php echo site_url('reports/reports/room_report/'.$room['room_id']); ?>"> 
					
					<?php
						echo "<h4>".$room['room_name']."</h4>";
						if ($room['room_pc_count'] > 1)
							{echo "<h5>".$room['room_pc_count']." machines available</h5>";}
				  		elseif ($room['room_pc_count'] ==1)
				  			{echo "<h5>".$room['room_pc_count']." machine available</h5>";}
						else
							{echo "<br>";}
					?>
					
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
