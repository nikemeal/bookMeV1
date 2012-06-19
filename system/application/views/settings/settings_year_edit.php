<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Academic Years</h3></div>
			</center>
			<div class="alert alert-danger">don't forget to select an active year in general settings</div>
			<h4>Click on a year to edit it</h4>
			
			<br>
			
				<?php foreach ($years as $year){ ?>


					<a class="btn span4" href="edit_year/<?php echo $year['year_id'];?>"> 
						<h5><?php echo $year['year_name'] ?></h5>
						
						<?php
							$temp_start_date= $year['year_start'];
 							$arr =explode("-",$temp_start_date);
 							$arr=array_reverse($arr);
 							$start_date =implode($arr,"-");
 						?>
						<h5>Start Date : <?php echo $start_date ?></h5>
						
						<?php
							$temp_end_date= $year['year_end'];
 							$arr =explode("-",$temp_end_date);
 							$arr=array_reverse($arr);
 							$end_date =implode($arr,"-");
 						?>
						<h5>End Date : <?php echo $end_date ?></h5>
						
						<?php 
							if ($year['year_isactive'])
							{?>
							<h5><b><i>This is the current active year</i></b></h5>
						<?php }?>
						
						
					
						
						
						
						

					</a>
<div class="span10">&nbsp;</div>
				<?php }?>

				<div class="span10">
					<br>
					<a class="btn btn-primary" href="add_year"><i class="icon-plus"></i> Add a new academic year</a>

				</div>
				
			</div>
		</div>
			

			<div class="span1">
				&nbsp;
			</div>

		</div>
		
	</div>
</div>
