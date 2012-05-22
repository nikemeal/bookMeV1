<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>
			
			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Edit period - <?php echo $period_name; ?></h3></div>
			</center>
			
				<form class="form-horizontal" method="post" action="../update_period">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Period name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" value="<?php echo $period_name;?>" name="period_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the period which will show up in the booking view"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Period start time</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" disabled id="periodstart" value="<?php echo $period_start;?>" name="period_start">
              				</div>
            				<br>
            				<label class="control-label" for="input02">Period end time</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" disabled id="periodend" value="<?php echo $period_end;?>" name="period_end">
              					
            				</div>
            				<br>
            				<div class="control-group">
            					<label class="control-label" for="bookable">Is period bookable</label>
            					<div class="controls">
              						<select name= "period_bookable" id="period_bookable">
									<?php if ($period_bookable == 1)
                					{ ?>
                					<option value="1">Yes</option>
                					<option value="0">No</option>
                					<?php 
                					} else 
                					{
                					?>
                					<option value="0">No</option>
                					<option value="1">Yes</option>
                					<?php 
                					}?>
	               				    </select>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Should BookMe display the period (such as 'Lunch') just for layout purposes but block users being able to book it"></i></p>
            					</div>
          					</div>
          					<input type="hidden" name="period_id" value="<?php echo $period_id;?>">
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Update period</button>
            					<a class="btn btn-info" href="../period_settings">back</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
				
			</div>
			
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
