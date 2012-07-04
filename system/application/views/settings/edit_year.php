<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			
			<div class="span1">
				&nbsp;
			</div>
			
			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Edit academic year - <?php echo $year_name; ?></h3></div>
			</center>
			
				<form class="form-horizontal" id="year" method="post" action="../update_year">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">Year name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge required" value="<?php echo $year_name; ?>" id="input01" name="year_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name of the academic year"></i></p>
            				</div>
            				<br>
            				<?php
								$temp_start_date= $year_start;
 								$arr =explode("-",$temp_start_date);
 								$arr=array_reverse($arr);
 								$start_date =implode($arr,"-");
 							?>
            				<label class="control-label" for="input02">Year start date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " value="<?php echo $start_date; ?>" id="year_start" name="year_start">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the academic year start?  This will mark the first bookable day in the year"></i></p>
            				</div>
            				<br>
            				<?php
								$temp_end_date= $year_end;
 								$arr =explode("-",$temp_end_date);
 								$arr=array_reverse($arr);
 								$end_date =implode($arr,"-");
 							?>
            				<label class="control-label" for="input02">Year end date</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge " value="<?php echo $end_date; ?>" id="year_end" name="year_end">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="What day does the academic year end?  This will mark the last bookable day in the year"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="subject_id">Active academic year</label>
            					<div class="controls">
              						<select name= "active_year" class="span2">
	                		            <?php
	                		            if ($year_isactive == 0)
	                		            {
	                		            ?>
	                		            <option value="0">no</option>
	                		            <option value="1">yes</option>
	                		            <?php
	                		            }
	                		            else
	                		            {
	                		            ?>
	                		            <option value="1">yes</option>
	                		            <?php
	                		            }
	                		            ?>
	                		           
		                			</select>
                				    <p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Is this the current active academic year?  This will determine which year block bookings are made"></i></p>
					            	
            					</div>
            					
            					
            				<br>
            				<input type="hidden" name="year_id" value="<?php echo $year_id;?>">
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Update academic year</button>
            					<a class="btn btn-danger" data-toggle="modal" href="#deletebox" id="deletehint" data-content="Delete room">Delete academic year</a>
            					<a class="btn btn-info" href="../year_settings">back</a>
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
			<div id="deletebox" class="modal hide fade">
					<div class="modal-body">
						<button class="close" data-dismiss="modal">×</button>
					<br><br>
						<center>
						<button class="btn btn-danger span5" >WARNING!</button>
					<br><br>
						<form class="well" action="<?php echo site_url('settings/years/year_delete/'.$year_id); ?>" method="post" id="year_delete" name="year_delete">
							Are you sure you want to delete this academic year? 
					<br><br>
							This could cause undesired effects on any bookings made
							within this year
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
				</script>
			
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
