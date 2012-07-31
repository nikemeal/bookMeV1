<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Academic Years</h3></div>
			<div class="label label-info span2">
			<font size="2">Click on a year to edit it</font>
			</div>
			</center>
						<?php
			if (isset($error))
			{
			echo '<div class="alert alert-danger"><h3>This is the current active year.  Please set another year active before deleting this one</h3></div>';	
			} 
			?>
			
			<br><br>
			
				<?php foreach ($years as $year){ ?>


					<a class="btn span2" href="edit_year/<?php echo $year['year_id'];?>"> 
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
							<h5><b><i><font color="red">This is the current active year</font></i></b></h5>
						<?php }?>
		
					</a>

				<?php }?>

				<div class="span10">
					<br>
					<div class="form-actions">
						<a class="btn btn-primary" href="add_year"><i class="icon-plus"></i> Add a new academic year</a>
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
