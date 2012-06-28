<br><br><br>
<br><br><br><div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span4">
				&nbsp;
			</div>
			
			<div class="span4">
				<div class="well">
				
				<?php 
				$local_login = $this->session->userdata('local_login');
				$deny_reason = $this->session->userdata('deny_reason');
				$ldap_error = $this->session->userdata('ldap_error');
				if ($local_login == 'denied')
				{
				?>
				Local logins have been disabled
				<br>
				Please try again with a network login
				<br><br>
				<a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
				<br>
				
				<?php 
				}elseif ($deny_reason == "notingroup")
				{
				?>
					You are not a member of the authorised security groups
					<br>
					Please contact your administrator and try again
					<br><br><a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
					<br>	
				<?php 
				}
				elseif ($deny_reason == "ldapnotset")
				{
				?>
					Active Directory authentication is not completely configured
					<br>
					Please contact your administrator and try again later
					<br><br><a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
					<br>	
				<?php 
				}
				elseif (!empty($ldap_error))
				{
					echo $ldap_error;
				?>
					
					<br><br><a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
					<br>	
				<?php 
				}
				else
				{
				?>
				Your username or password is incorrect
				<br>
				Please try again
				<br><br><a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
				<br>
				<?php 		
				} 
				?>
				
				</div>
			</div>
			
			<div class="span4">
				&nbsp;
			</div>
			
		</div>
	</div>
</div>