<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			<div class="span10 well">
			<center>
				<div class="alert alert-info"><h3>Autentication Settings</h3></div>
			</center>
				 <form class="form-horizontal span5" method="post" action="submit_auth_settings">
        			<fieldset>
        			<center>
						<div class="alert alert-info">
							<h4>LDAP Settings</h4>
						</div>
					</center>
          				<div class="control-group">
            				<label class="control-label" for="input01">LDAP server/s</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input01" name="ldap_servers" value="<?php echo $ldap_server;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Server name/s used to authenticate users and check group membership.  Separate names with a comma (server1,server2)"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input02">LDAP account suffix</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input02" name="ldap_account_suffix" value="<?php echo $ldap_account_suffix;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Your internal DNS name.  Include the @ symbol (@yourschool.internal)"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input03">LDAP base DN</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input03" name="ldap_basedn" value="<?php echo $ldap_basedn;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Your base domain name (DC=yourschool,DC=internal"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input04">LDAP username</label>
            				<div class="controls">
              					<input type="text" class="input-xlarge" id="input04" name="ldap_username" value="<?php echo $ldap_username;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="A username with administrative priviliges to search LDAP, commonly Administrator"></i></p>
            				</div>
            				<br>
            				<label class="control-label" for="input05">LDAP password</label>
            				<div class="controls">
              					<input type="password" class="input-xlarge" id="input05" name="ldap_password" value="<?php echo $ldap_password;?>">
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="Password for the above named user"></i></p>
            				</div>
            				<br>
            			</div>
						<div class="form-actions">
            				<button type="submit" class="btn btn-primary">Save and test settings</button>
            					<a class="btn btn-info" href="<?php echo base_url().index_page();?>">back</a>
            			</div>
        			</fieldset>
      			</form>
      	
      			<?php 
					if (empty($ldap_groups))
					{
					?>
						<center>
							<div class="alert alert-info">
								<h4>Cannot show LDAP groups - LDAP settings not configured correctly</h4>
							</div>
						</center>
					<?php 	
					}
					else
					{ 
      				?>
      			 <form class="form-horizontal span6" method="post" action="submit_auth_users">
        			<fieldset>
      				<center>
						<div class="alert alert-info">
							<h4>LDAP Groups</h4>
						</div>
					</center>
					<h2>Select standard groups</h2>
					Standard users can create single bookings within any item.<br />
					<small><i>Hold Ctrl to select multiple groups</i></small><br />
					<select multiple size="10" name="standard_users[]" class="span5">
						<?php
							foreach ($ldap_groups as $group) {
								if (!empty($group[0])) {
									echo '<option ';
									foreach ($ldap_standard_users as $user) {
										if ($user == $group) { echo 'selected'; }
									}
									echo ' value="'.$group.'">'.$group.'</option>';
								}
							}
						?>
					</select>
					<br><br>
					
					<h2>Select admin groups</h2>
					Administrator users can carry out any activity on BookMe.<br />
					<small><i>Hold Ctrl to select multiple groups</i></small><br />
					<select multiple size="10" name="admin_users[]" class="span5">
						<?php
							foreach ($ldap_groups as $group) {
								if (!empty($group[0])) {
									echo '<option ';
									foreach ($ldap_admin_users as $user) {
										if ($user == $group) { echo 'selected'; }
									}
									echo ' value="'.$group.'">'.$group.'</option>';
								}
							}
						?>
					</select>
					<br><br>
					<div class="form-actions">
					<button type="submit" class="btn btn-primary">Submit user selections</button>
            	</div>
            			
      			</fieldset>
      			</form>
      			<?php } ?>
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