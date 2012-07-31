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
				
				<center>
					<div class="alert alert-info"><h3>Usage Reports</h3></div>
				
				<div class="label label-info span6">
					<font size="2">All reports are based on single bookings and not block bookings made by admin users</font>
				</div>
				</center>
				<br><br>
				<a class="btn btn-info span2" href="<?php echo site_url('/reports/reports/room_report_overview')?>">Room / Resource reports</a>
				<br><br>
				<a class="btn btn-info span2" href="<?php echo site_url('/reports/reports/dept_report_overview')?>">Department reports</a>
				<br><br>
				<a class="btn btn-info span2" href="<?php echo site_url('/reports/reports/user_report')?>">User reports</a>
				
			</div>
		
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>


<?php 
}?>


