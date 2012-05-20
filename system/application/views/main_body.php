<?php
/* this page will need a view for non logged in users
 * showing a login box which will forward on to a login
 * processor.  that will then redirect back to this page
 * 
 * once logged in, the page will show the main body of
 * the site with thumbnail pictures for each bookable room
 */


// is the user authenticated and logged in?
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');

//if yes, show the following 
if ($authenticated == 1) {
?>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span1">
				&nbsp;
			</div>

			<div class="span10">
				<?php 
				if ($room_count == 0 && $accesslevel == 'admin')
				{
					?>
					<div class="alert alert-error">
						<h1><center>There are no rooms defined, you can add them in the settings menu above</center></h1>
					</div>
				<?php 
				} ?>
				
								<?php 
				if ($room_count == 0 && $accesslevel == 'staff')
				{
					?>
					<div class="alert alert-error">
						<h1><center>There are no rooms defined, please contact your administrator</center></h1>
					</div>
				<?php 
				} ?>
				
			</div>

			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>


<?php 
//else show a blank page waiting for them to log in
}else {
?>
<div class="row-fluid">
	
</div>
<?php 
} 
?>

<div id="loginbox" class="modal hide fade">
	<div class="modal-body">
		<button class="close" data-dismiss="modal">×</button>
		<br><br>
		<center>
			<button class="btn btn-danger span5" >Please enter your login details</button>
		<br><br>
			<form class="well" action="<?php echo site_url(); ?>/main/processlogin" method="post" id="processlogin" name="login">
				<label>Username</label>
				<input class="span2" id="username" size="16" type="text" name="username">
					<br>
				<label>Password</label>
				<input class="span2" id="password" size="16" type="password" name="password">
					<br>
					<br>
				<button type="submit" class="btn">Submit</button>
			</form>
		</center>
	</div>
</div>
	<script type="text/javascript" language="JavaScript">
		$('#loginbox').on('shown', function () {
		$("input#username").focus();
		});
		
	</script>
	
 

