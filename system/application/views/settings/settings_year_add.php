<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Add an academic year</h3></div>
			</center>
			
			<?php if ($error != ' ') { ?>
			<div class="alert alert-error"><?php echo $error; ?></div>
			<?php }?>
			
				<form class="form-horizontal" id="year" method="post" action="submit_new_year">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Year name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="input01" name="year_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the academic year"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Year start date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="year_start" name="year_start">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the academic year start?  This will mark the first bookable day in the year"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Year end date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="year_end" name="year_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the academic year end?  This will mark the last bookable day in the year"></i></p>
            				</div>
            				<br>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Add academic year</button>
            					<a class="btn btn-info" href="year_settings">back</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
				
				<script>
					$(function() 
					{
					var dates = $( "#year_start, #year_end" ).datepicker(
						{
							dateFormat: "dd-mm-yy",
							defaultDate: "+1w",
							changeMonth: true,
							numberOfMonths: 2,
							onSelect: function( selectedDate ) 
								{
									var option = this.id == "year_start" ? "minDate" : "maxDate",
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
  	    				$("#year").validate();
  	  				});
				</script>

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
