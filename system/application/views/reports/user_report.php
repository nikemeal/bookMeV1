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
			
			<div class="alert alert-info"><h4><center>User usage report between <?php echo $date_from_readable; ?> and <?php echo $date_to_readable; ?></center></h4></div>


    				<div>
    					<table class="span4 table table-striped table-bordered table-condensed">
							<thead>
								<td><strong>User</strong></td><td><strong># of bookings</strong></td>
							</thead>
							<?php 
							foreach ($user_report as $report)
							{?>
								<tr>
									<td><?php echo $report['Name'];?></td><td><?php echo $report['Count'];?></td>
								</tr>
							<?php 
							}
							?>
						</table>
    				</div>
    					
			<div class="span3 alert alert-danger"><strong>Total bookings for this period</strong> : <?php echo $user_report_count['Count']; ?></div>

			</div>
							
			<div class="span3 well">
			<div class="alert alert-info"><h4><center>Select search date</center></h4></div>
				<div>
					<form class="form" id="search" method="post" action="<?php echo site_url('reports/reports/user_report'); ?>">
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
