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
				<form class="form-horizontal" id="general" method="post" action="submit_general_settings">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">School name</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" value="<?php echo $school_name;?>" id="input01" name="school_name">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Used by BookMe for the title in the menu bar above.  Leave blank to remove the '@ YourSchoolName' text"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">Background colour</label>
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
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If set to yes, 'bookme_admin' and 'bookme_staff' can log in even if LDAP isn't configured.  If set to no, 'bookme_admin' and 'bookme_staff' are denied login completely"></i></p>
            					</div>
          					</div>
          					<div class="control-group">
            					<label class="control-label" for="user_reports">Users can view reports</label>
            					<div class="controls">
              						<select name= "user_reports" id="user_reports">
                					<?php if ($user_reports == 1)
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
					            	<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="If set to yes, standard users can view usage reports. otherwise only admin users can view them"></i></p>
            					</div>
          					</div>
            					
		
							<label class="control-label">Users can book ahead</label>
      						<div class="controls">
              					<input class="input" value="<?php echo $book_ahead;?>" type="number" name="book_ahead">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="How many weeks ahead can standard users book?  Set to -1 for unlimited"></i></p>
							</div>


							<div class="form-actions">
            					<button type="submit" class="btn btn-primary">Save changes</button>
            					<a class="btn btn-info" href="<?php echo base_url().index_page();?>">back</a>
            					
            					<?php if ($booking_count == 0){?>
            					<div class="btn btn-danger pull-right disabled">Delete all bookings</div>
            					<?php }else{?>
            					<a class="btn btn-danger pull-right" data-toggle="modal" href="#deletebox" id="deletehint" data-content="Click here to log in">Delete all bookings</a>
            					<?php }?>
            					
            				</div>
            			</div>
        			</fieldset>
      			</form>
			</div>
			
				<script type="text/javascript"> 
  					$(document).ready(function () { 
    				$("[rel=tooltip]").tooltip(); 
    				$('#general').validate(); 
  					}); 
				</script> 
				<div id="deletebox" class="modal hide fade">
					<div class="modal-body">
						<button class="close" data-dismiss="modal">×</button>
					<br><br>
						<center>
						<button class="btn btn-danger span5" >WARNING!</button>
					<br><br>
						<form class="well" action="<?php echo site_url(); ?>/settings/general/deleteallbookings" method="post" id="deleteallbookings" name="delete">
						<input type="hidden" name="action" value="delete_all_bookings">
							Clicking OK will wipe ALL the bookings in the database.  This cannot be undone and is completely destructive 
					<br><br>
							Other settings such as holidays, periods, 
							subjects, etc. will be kept
					<br><br>
						<button type="submit" class="btn">OK</button>
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