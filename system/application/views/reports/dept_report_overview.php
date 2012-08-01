<?php
// is the user authenticated and logged in?
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');

//if yes, show the page
	if ($authenticated == 1 AND $accesslevel == "admin" OR $authenticated == 1 AND $accesslevel == "staff" AND $user_reports == 1) {
?>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			
				
					<div class="span10 well">
			
			<div class="alert alert-info"><h4>Click on a department to view usage reports for it</h4></div>
			<br>

				<?php foreach ($depts as $subject){ ?>

					
					<?php if ($subject['subject_use_shading'] == 1){?>
					<a class="btn span2" style="background-color: <?php echo "#".$subject['subject_colour'];?>" href="<?php echo site_url('reports/reports/dept_report/'.$subject['subject_id']); ?>"> 
					<?php }else{?>
					<a class="btn span2" href="edit_subject/<?php echo $subject['subject_id'];?>">
					<?php }?>
					<h4><?php echo $subject['subject_name'] ?></h4>
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
