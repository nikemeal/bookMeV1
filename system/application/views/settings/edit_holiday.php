<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>
			
			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Edit holiday - <?php echo $holiday_name; ?></h3></div>
			</center>
			
				<form class="form-horizontal" id="holiday" method="post" action="../update_holiday">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Holiday name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" value="<?php echo $holiday_name; ?>" id="input01" name="holiday_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the holiday which will show up in the booking view"></i></p>
            				</div>
            				<br>
            				<?php
								$temp_start_date= $holiday_start;
 								$arr =explode("-",$temp_start_date);
 								$arr=array_reverse($arr);
 								$start_date =implode($arr,"-");
 							?>
            				<label class="control-label" for="input02">Holiday start date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" value="<?php echo $start_date; ?>" id="holiday_start" name="holiday_start">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the holiday start?  This will mark the first unbookable day in the holiday"></i></p>
            				</div>
            				<br>
            				<?php
								$temp_end_date= $holiday_end;
 								$arr =explode("-",$temp_end_date);
 								$arr=array_reverse($arr);
 								$end_date =implode($arr,"-");
 							?>
            				<label class="control-label" for="input02">Holiday end date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" value="<?php echo $end_date; ?>" id="holiday_end" name="holiday_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the holiday end?  This will mark the last unbookable day in the holiday"></i></p>
            				</div>
            				<br>
          					<input type="hidden" name="holiday_id" value="<?php echo $holiday_id;?>">
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Update holiday</button>
            					<a class="btn btn-danger" data-toggle="modal" href="#deletebox" id="deletehint" data-content="Delete room">Delete holiday</a>
            					<a class="btn btn-info" href="../holiday_settings">back</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
			
			<script>
					$(function() 
					{
					var dates = $( "#holiday_start, #holiday_end" ).datepicker(
						{
							dateFormat: "dd-mm-yy",
							defaultDate: "+1w",
							changeMonth: true,
							numberOfMonths: 2,
							onSelect: function( selectedDate ) 
								{
									var option = this.id == "holiday_start" ? "minDate" : "maxDate",
									instance = $( this ).data( "datepicker" ),
									date = $.datepicker.parseDate(
									instance.settings.dateFormat ||
									$.datepicker._defaults.dateFormat,
									selectedDate, instance.settings );
									dates.not( this ).datepicker( "option", option, date );
								}
						});
					});
  					$(document).ready(function () 
  		  			{ 
  	    				$("[rel=tooltip]").tooltip(); 
  	  				});
			</script> 
			<div id="deletebox" class="modal hide fade">
					<div class="modal-body">
						<button class="close" data-dismiss="modal">×</button>
					<br><br>
						<center>
						<button class="btn btn-danger span5" >WARNING!</button>
					<br><br>
						<form class="well" action="<?php echo site_url('settings/holidays/holiday_delete/'.$holiday_id); ?>" method="post" id="holiday_delete" name="holiday_delete">
							Are you sure you want to delete this holiday? 
					<br><br>
							Users will now be able to make bookings for the 
							time period this holiday covered
					<br><br>
						<button type="submit" class="btn btn-danger">OK</button>
						<button class="btn btn-info" data-dismiss="modal">Cancel</button>
						</form>
						</center>
					</div>
				</div>
				<script type="text/javascript" language="JavaScript">
					$('#deletebox').on('shown', function () {
					});
					$("#holiday").validate();
				</script>
			
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
