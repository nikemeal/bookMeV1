<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Holidays</h3></div>
			
			<div class="label label-info span2">
			<font size="2">Click on a holiday to edit it</font>
			</div>
			</center>
			<br><br>

				<?php foreach ($holidays as $holiday){ ?>


					<a class="btn span2" href="edit_holiday/<?php echo $holiday['holiday_id'];?>"> 
						<h5><?php echo $holiday['holiday_name'] ?></h5>
						
						<?php
							$temp_start_date= $holiday['holiday_start'];
 							$arr =explode("-",$temp_start_date);
 							$arr=array_reverse($arr);
 							$start_date =implode($arr,"-");
 						?>
						<h5>Start Date : <?php echo $start_date ?></h5>
						
						<?php
							$temp_end_date= $holiday['holiday_end'];
 							$arr =explode("-",$temp_end_date);
 							$arr=array_reverse($arr);
 							$end_date =implode($arr,"-");
 						?>
						<h5>End Date : <?php echo $end_date ?></h5>
						
						
						
						

					</a>

				<?php }?>

				<div class="span10">
					<br>
					<div class="form-actions">
						<a class="btn btn-primary" href="add_holiday"><i class="icon-plus"></i> Add a new holiday</a>
					</div>
				</div>
				
			</div>
		</div>
			

			<div class="span1">
				&nbsp;
			</div>

		</div>
		
	</div>
</div>
