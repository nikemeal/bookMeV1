<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Subjects</h3></div>
			</center>
			<h4>Click on a subject to edit it</h4>
			<br>

				<?php foreach ($subjects as $subject){ ?>
					
					<?php if ($subject['subject_use_shading'] == 1){?>
					<a class="btn span2" style="background-color: <?php echo "#".$subject['subject_colour'];?>" href="edit_subject/<?php echo $subject['subject_id'];?>"> 
					<?php }else{?>
					<a class="btn span2" href="edit_subject/<?php echo $subject['subject_id'];?>">
					<?php }?>
					<h4><?php echo $subject['subject_name'] ?></h4>
					</a>

				<?php }?>
				
				<div class="span10">
					<br>
					<a class="btn btn-primary" href="add_subject"><i class="icon-plus"></i> Add a new subject</a>

				</div>
				
			</div>
		</div>
			

			<div class="span1">
				&nbsp;
			</div>

		</div>
		
	</div>
</div>
