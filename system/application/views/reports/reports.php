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

			<div class="span10">
				<div class="alert alert-info"><h4><center>Usage Reports</center></h4></div>
				<br>
				<center>
				<a class="btn btn-info btn-large" href="<?php echo site_url('/reports/reports/room_report_overview')?>">Room / Resource reports</a>
				<br><br>
				<a class="btn btn-info btn-large" href="<?php echo site_url('/reports/reports/dept_report_overview')?>">Department reports</a>
				<br><br>
				<a class="btn btn-info btn-large" href="<?php echo site_url('/reports/reports/user_reports')?>">User reports</a>
				</center>
			</div>
		
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>


<?php 
}?>


