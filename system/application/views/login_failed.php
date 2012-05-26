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
				}else{
				?>
				Your username or password is incorrect
				<br>
				Please try again
				<br><br><a class="btn btn-info" href="<?php echo base_url().index_page();?>/login/reset">back</a>
				<br>
				<?php } ?>
				
				</div>
			</div>
			
			<div class="span4">
				&nbsp;
			</div>
			
		</div>
	</div>
</div>