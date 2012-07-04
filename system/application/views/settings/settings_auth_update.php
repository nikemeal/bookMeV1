<?php if (isset($test_ldap)){?>
<script type="text/javascript" >
$(document).ready(function() { 
 	$('#testldap').modal({
 		backdrop: "static"
 	});
    $('#testldap').modal('show') 
 
}); 
</script>
<div id="testldap" class="modal hide fade">
	<div class="modal-body">
		<center>
			<div class="alert alert-info" ><b>LDAP Test result</b></div>

			<div class="well">
				<?php if ($test_ldap == 'Success'){?>
				BookMe successfully connected to your LDAP server using the settings
				you provided<br><br>
				<?php }else{
				echo $test_ldap;?>
				<br><br>
				<?php }?>
					<br>
					<a class="btn btn-info" href="<?php echo site_url('settings/authentication/auth_settings'); ?>">OK</a>
				
			</div>
		</center>
	</div>
</div>
<?php }
else
{
	redirect('/settings/authentication/auth_settings/', 'refresh');
}
?>
