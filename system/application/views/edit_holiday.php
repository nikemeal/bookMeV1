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
			
				<form class="form-horizontal" method="post" action="../update_holiday">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Holiday name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" value="<?php echo $holiday_name; ?>" id="input01" name="holiday_name">
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
              					<input type="text" class="input-xlarge " value="<?php echo $start_date; ?>" id="holiday_start" name="holiday_start">
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
              					<input type="text" class="input-xlarge " value="<?php echo $end_date; ?>" id="holiday_end" name="holiday_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the holiday end?  This will mark the last unbookable day in the holiday"></i></p>
            				</div>
            				<br>
          					<input type="hidden" name="holiday_id" value="<?php echo $holiday_id;?>">
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Update holiday</button>
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
			
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
