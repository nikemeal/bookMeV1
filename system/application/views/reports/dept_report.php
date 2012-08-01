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

			<div class="span7 well">
			
			<div class="alert alert-info"><h4><center>Department usage report for <?php echo $subject_name; ?> between <?php echo $date_from_readable; ?> and <?php echo $date_to_readable; ?></center></h4></div>
				<div class="tabbable">
    				<ul class="nav nav-pills">
    					<li class="active"><a href="#room" data-toggle="tab">Room Reports</a></li>
    					<li><a href="#user" data-toggle="tab">User Reports</a></li>
    				</ul>

    			<div class="tab-content">
    				<div class="tab-pane active" id="room">
    					<table class="span4 table table-striped table-bordered table-condensed">
							<thead>
								<td><strong>Room</strong></td><td><strong># of bookings</strong></td>
							</thead>
							<?php 
							foreach ($dept_report as $report)
							{?>
								<tr>
									<td><?php echo $report['Room'];?></td><td><?php echo $report['Count'];?></td>
								</tr>
							<?php 
							}
							?>
						</table>
    				</div>
    				<div class="tab-pane" id="user">
    					<table class="span4 table table-striped table-bordered table-condensed">
							<thead>
								<td><strong>User</strong> <em>(room)</em></td><td><strong># of bookings</strong></td>
							</thead>
							<?php 
							foreach ($user_report as $report)
							{?>
								<tr>
									<td><?php echo $report['Name']." (<em>".$report['Room']."</em>)";?></td><td><?php echo $report['Count'];?></td>
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
							
			<div class="span3 well">
			<div class="alert alert-info"><h4><center>Select search date</center></h4></div>
				<div>
					<form class="form" id="search" method="post" action="<?php echo site_url('reports/reports/dept_report/'.$this->uri->segment(4)); ?>">
					<label for="from" class="label label-info">From</label>
					<input type="text" id="from" name="date_from"/>
					<br><br>
					<label for="to" class="label label-info">To</label>
					<input type="text" id="to" name="date_to"/>
					<br>
					<button type="submit" class="btn btn-primary">Search</button>
            		<button type="reset" class="btn btn-danger">Clear</button>
				</div>
			</div>	
	
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>

<script>
	$(function() {
		$( "#from" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
	
<?php 
}?>
