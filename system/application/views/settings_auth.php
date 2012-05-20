<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Authorisation Settings</h3></div>
			</center>
				 <form class="form-horizontal" method="get" action="submit_auth_settings">
        			<fieldset>
          				<div class="control-group">
            				<label class="control-label" for="input01">LDAP server/s</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" name="ldap_server">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Server name/s used to authenticate users and check group membership.  Separate names with a comma (server1,server2)"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">LDAP account suffix</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input02" name="ldap_account_suffix">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Your internal DNS name.  Include the @ symbol (@yourschool.internal)"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input03">LDAP base DN</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input03" name="ldap_basedn">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Your base domain name (DC=yourschool,DC=internal"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input04">LDAP username</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input04" name="ldap_username">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="A username with administrative priviliges to search LDAP, commonly Administrator"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input05">LDAP password</label>
            				<div class="controls">
              					<input type="password" class="input-xlarge" id="input05" name="ldap_password">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Password for the above named user"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input06">BookMe standard group/s</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input06" name="ldap_standard_users">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="LDAP group/s allowed basic access to BookMe to view bookings and create/alter/delete their own bookings"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input07">BookMe admin group/s</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input07" name="ldap_admins_users">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="LDAP group/s allowed full access to BookMe.  Can create bookings as other users, amend/delete any bookings plus gain access to site settings"></i>
            				</div>
          				</div>
						<div class="form-actions">
            				<button type="submit" class="btn btn-primary">Save changes</button>
            			</div>
        			</fieldset>
      			</form>
			</div>
			
				<script type="text/javascript"> 
  					$(document).ready(function () { 
    				$("[rel=tooltip]").tooltip(); 
  					}); 
				</script> 

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>