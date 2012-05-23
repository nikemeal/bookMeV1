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

			
				<?php 
				if ($accesslevel == 'admin')
				{
				?>
					<div class="span10">
						<?php if ($room_count == 0){?>
						<a class="btn span12 btn-warning" href="<?php echo index_page();?>/settings/add_room">
						<h4><center>There are no rooms defined, click this button to add one</center></h4>
						</a>
						<?php }?>

						<div class="span1">&nbsp;</div>
						
						<?php if ($period_count == 0){?>								
						<a class="btn span12 btn-warning" href="<?php echo index_page();?>/settings/add_period">
						<h4><center>There are no periods defined, click this button to add one</center></h4>
						</a>
						<?php }?>
						
						<div class="span1">&nbsp;</div>
						
						<?php if ($subject_count == 0){?>				
						<a class="btn span12 btn-warning" href="<?php echo index_page();?>/settings/add_subject">
						<h4><center>There are no subjects defined, click this button to add one</center></h4>
						</a>
						<?php }?>
						
					</div>
				
				<?php
				}
				elseif ($accesslevel == 'staff')
				{
				?>
					<div class="span10">
									
						<div class="alert span12 alert-error">
						<h4><center>BookMe has not been fully configured, please contact your administrator</center></h4>
						</div>
	
					</div>
					
				<?php } ?>
	
			<div class="span1">
				&nbsp;
			</div>

		</div>
	</div>
</div>


<?php 
}?>

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
	
 

