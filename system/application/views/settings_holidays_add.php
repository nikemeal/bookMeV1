<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Add a holiday</h3></div>
			</center>
			
			<?php if ($error != ' ') { ?>
			<div class="alert alert-error"><?php echo $error; ?></div>
			<?php }?>
			
				<form class="form-horizontal" method="post" action="submit_new_holiday">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Holiday name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" name="holiday_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the holiday which will show up in the booking view"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Holiday start date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " id="holiday_start" name="holiday_start">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the holiday start?  This will mark the first unbookable day in the holiday"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Holiday end date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " id="holiday_end" name="holiday_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the holiday end?  This will mark the last unbookable day in the holiday"></i></p>
            				</div>
            				<br>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Add holiday</button>
            					<a class="btn btn-info" href="holiday_settings">back</a>
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
