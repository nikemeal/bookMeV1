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

			<div class="span7">
			
			<div class="alert alert-info"><h4><center>Room usage report for <?php echo $room_name; ?> between <?php echo $date_from_readable; ?> and <?php echo $date_to_readable; ?></center></h4></div>
				<div class="tabbable">
    				<ul class="nav nav-pills">
    					<li class="active"><a href="#dept" data-toggle="tab">Department Reports</a></li>
    					<li><a href="#user" data-toggle="tab">User Reports</a></li>
    				</ul>

    			<div class="tab-content">
    				<div class="tab-pane active" id="dept">
    					<table class="span4 table table-striped table-bordered table-condensed">
							<thead>
								<td><strong>Department</strong></td><td><strong># of bookings</strong></td>
							</thead>
							<?php 
							foreach ($dept_report as $report)
							{?>
								<tr>
									<td><?php echo $report['Subject'];?></td><td><?php echo $report['Count'];?></td>
								</tr>
							<?php 
							}
							?>
						</table>
    				</div>
    				<div class="tab-pane" id="user">
    					<table class="span4 table table-striped table-bordered table-condensed">
							<thead>
								<td><strong>User</strong> <em>( department)</em></td><td><strong># of bookings</strong></td>
							</thead>
							<?php 
							foreach ($user_report as $report)
							{?>
								<tr>
									<td><?php echo $report['Name']." (<em>".$report['Subject']."</em>)";?></td><td><?php echo $report['Count'];?></td>
								</tr>
							<?php 
							}
							?>
						</table>
	    			</div>
    			</div>
    		</div>
	
			<div class="span3 alert alert-danger"><strong>Total bookings for this period</strong> : <?php echo $dept_report_count['Count']; ?></div>

			</div>
							
			<div class="span3">
			<div class="alert alert-info"><h4><center>Refine search</center></h4></div>
				this area for the search features
			</div>	
	
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>


<?php 
}?>
