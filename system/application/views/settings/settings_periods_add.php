<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Add a period</h3></div>
			</center>
			
			<?php if ($error != ' ') { ?>
			<div class="alert alert-error"><?php echo $error; ?></div>
			<?php }?>
			
				<form class="form-horizontal" id="period" method="post" action="submit_new_period">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Period name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="input01" name="period_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the period which will show up in the booking view"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Period start time</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="periodstart" name="period_start">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="When does the period start?  This is displayed next to the period name to remind users, and is used to order the periods"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Period end time</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="periodend" name="period_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="When does the period end?  This is displayed next to the period name to remind users, and is used to order the periods"></i></p>
            				</div>
            				<br>
            				<div class="control-group">
            					<label class="control-label" for="bookable">Is period bookable</label>
            					<div class="controls">
              						<select name= "period_bookable" id="period_bookable">
										<option value="1">Yes</option>
										<option value="0">No</option>
		        				    </select>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Should BookMe display the period (such as 'Lunch') just for layout purposes but block users being able to book it"></i></p>
            					</div>
          					</div>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Add period</button>
            					<a class="btn btn-info" href="period_settings">back</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
			
				<script type="text/javascript"> 
  					$(document).ready(function () { 
    				$("[rel=tooltip]").tooltip(); 
  					}); 
  					$('#periodstart').timepicker({});
  					$('#periodend').timepicker({});
  					$("#period").validate();
				</script> 
				
				

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
