<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>General Settings</h3></div>
			</center>
				<form class="form-horizontal" method="post" action="submit_general_settings">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">School name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" value="<?php echo $school_name;?>" id="input01" name="school_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Used by BookMe for the title in the menu bar above.  Leave blank to remove the '@ YourSchoolName' text"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">BookMe background colour</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge color" value="<?php echo $bg_colour;?>" id="input02" name="bg_colour">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The background colour on all BookMe pages"></i></p>
            				</div>
            				<br>
            				<div class="control-group">
            					<label class="control-label" for="allow_local_login">Allow local login</label>
            					<div class="controls">
              						<select name= "allow_local_login" id="allow_local_login">
                					<?php if ($allow_local_login == 1)
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
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If set to yes, 'bookme_admin' can log in even if LDAP isn't configured.  If set to no, 'bookme_admin' is denied login completely"></i></p>
            					</div>
          					</div>
            				<label class="control-label" for="disabledInput">BookMe version</label>
      						<div class="controls">
              					<input class="input-xlarge disabled" id="disabledInput" value="<?php echo $bookme_version;?>" type="text" disabled>
							</div>
							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Save changes</button>
            					<a class="btn btn-danger pull-right" data-toggle="modal" href="#loginbox" id="loginhint" data-content="Click here to log in">Delete all bookings</a>
            				</div>
            			</div>
        			</fieldset>
      			</form>
			</div>
			
				<script type="text/javascript"> 
  					$(document).ready(function () { 
    				$("[rel=tooltip]").tooltip(); 
  					}); 
				</script> 
				<div id="loginbox" class="modal hide fade">
	<div class="modal-body">
		<button class="close" data-dismiss="modal">×</button>
		<br><br>
		<center>
			<button class="btn btn-danger span5" >WARNING!</button>
		<br><br>
			<form class="well" action="<?php echo site_url(); ?>/settings/deleteallbookings" method="post" id="deleteallbookings" name="login">
				Clicking OK will wipe ALL the bookings in the database.  
				<br><br>
				Other settings such as holidays, periods, 
				subjects, etc. will be kept
					<br>
					<br>
				<button type="submit" class="btn">OK</button>
			</form>
		</center>
	</div>
</div>
	<script type="text/javascript" language="JavaScript">
		$('#loginbox').on('shown', function () {
		$("input#username").focus();
		});
		
	</script>

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>
