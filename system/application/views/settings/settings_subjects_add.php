<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Add a subject</h3></div>
			</center>
			
			<?php if ($error != ' ') { ?>
			<div class="alert alert-error"><?php echo $error; ?></div>
			<?php }?>
			
				<form class="form-horizontal" id="subject" method="post" action="submit_new_subject">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Subject name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" id="input01" name="subject_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the subject which will show up in the booking and add booking view"></i></p>
            				</div>
            				<br>
            				<div class="control-group">
            					<label class="control-label" for="bookable">Use subject shading colour</label>
            					<div class="controls">
              						<select name= "subject_use_shading" id="subject_use_shading">
										<option value="1">Yes</option>
										<option value="0">No</option>
		        				    </select>
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If yes, bookings made under this subject will have the background shaded with the colour chosen"></i></p>
            					</div>
          					</div>
            				<label class="control-label" for="input02">Subject shading colour</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge color" id="subject_colour" name="subject_colour">
              				</div>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Add subject</button>
            					<a class="btn btn-info" href="subject_settings">back</a>
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
  					$("#subject").validate();
				</script> 
				
				

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
