<script type="text/javascript" >
$(document).ready(function() { 
 	$('#loginerror').modal({
 		backdrop: "static"
 	});
    $('#loginerror').modal('show') 
 
}); 
</script>
				
<div id="loginerror" class="modal hide fade">
	<div class="modal-body">
		<center>
			<div class="alert alert-danger" ><b>Error</b></div>

			<div class="well">
	
					<?php
							
						$local_login = $this->session->userdata('local_login');
						$deny_reason = $this->session->userdata('deny_reason');
						$ldap_error = $this->session->userdata('ldap_error');
					
							if ($local_login == 'denied')
							{
								echo "<h3>Local login has been disabled</h3>";
								echo "<br>";
								echo "Please try logging in with a network login";
								
							}
							elseif ($deny_reason == "notingroup")
							{
								echo "<h3>You are not a member of any authorised groups</h3>";
								echo "<br>";
								echo "Please contact your administrator to resolve this";
							}
							elseif ($deny_reason == "ldapnotset")
							{
								echo "<h3>Active Directory configuration not completely configured</h3>";
								echo "<br>";
								echo "Please contact your administrator and try again later";
							}
							elseif (!empty($ldap_error))
							{
								echo $ldap_error;
							}
							else
							{
								echo "<h3>Username or password is incorrect</h3>";
								echo "<br>";
								echo "Please try again";
							}

						?>
						<br><br>
						<a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
			</div>
		</center>
	</div>
</div>			