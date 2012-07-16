<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Periods</h3></div>
			</center>
			<h4>Click on a period to edit it</h4>
			<br>

				<?php foreach ($periods as $period){ ?>


					<a class="btn span2" href="edit_period/<?php echo $period['period_id'];?>"> 
						
						
						<?php if ($period['period_bookable'] == 1){ ?>
						<h4><?php echo $period['period_name'] ?></h4>
						<h5>Start Time : <?php echo $period['period_start'] ?></h5>
						<h5>End Time : <?php echo $period['period_end'] ?></h5>
						<?php }else{?>
						<h6><?php echo $period['period_name'] ?></h6>
						<h6>Start Time : <?php echo $period['period_start'] ?></h6>
						<h6>End Time : <?php echo $period['period_end'] ?></h6>
						<?php }?>
						
						
					
						<h5>Bookable : 
							<?php if ($period['period_bookable'] == true){?>
							<i class="icon-ok"></i>
							<?php }else{?>
							<i class="icon-remove"></i>
							<?php }?>
						</h5>
					</a>

				<?php }?>

				<div class="span10">
					<br>
					<a class="btn btn-primary" href="add_period"><i class="icon-plus"></i> Add a new period</a>

				</div>
				
			</div>
		</div>
			

			<div class="span1">
				&nbsp;
			</div>

		</div>
		
	</div>
</div>
