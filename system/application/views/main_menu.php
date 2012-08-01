	<?php 
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');
	
	?>
	
	<div class="container-fluid">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					
					<?php 
					if ($school_name == '') 
					{ ?>
					<a class="brand" href="<?php echo base_url().index_page();?>">Book<i class="icon-calendar icon-white"></i>Me</a>
					<?php 
					} else {
					?>
					<a class="brand" href="<?php echo base_url().index_page();?>">Book<i class="icon-calendar icon-white"></i>Me @ <?php echo $school_name;?></a>
					<?php 
					}
					?>
					
					
					<ul class="nav">
					 	<li class="divider-vertical"></li>
           				
           				<?php 
           					if ($authenticated == 1) { ?>
           					<li class="navbar-text">Logged in as : <?php echo $this->session->userdata('fullname');?></li>
           					<li class="divider-vertical"></li>
	           				<?php 
	           					if (isset($user_reports) && $user_reports == 1 && $accesslevel != 'admin') { ?>
	           					<li><a href="<?php echo site_url('reports/reports'); ?>"><i class="icon-th-list icon-white"></i> Reports</a></a></li>
	           				<?php }?>
	           				<!-- if the user is an admin, show the settings options -->
	           				<?php if ($accesslevel == 'admin') {?>
	              				<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i> Settings <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="<?php echo site_url('settings/general/general_settings'); ?>">General</a></li>
	                				<li><a href="<?php echo site_url('settings/authentication/auth_settings'); ?>">Authentication</a></li>
	                				<li><a href="<?php echo site_url('settings/rooms/room_settings'); ?>">Rooms &amp; Resources</a></li>
	                				<li><a href="<?php echo site_url('settings/periods/period_settings'); ?>">Periods</a></li>
	                				<li><a href="<?php echo site_url('settings/subjects/subject_settings'); ?>">Subjects</a></li>
									<li><a href="<?php echo site_url('settings/years/year_settings'); ?>">Academic Years</a></li>
	                				<li><a href="<?php echo site_url('settings/holidays/holiday_settings'); ?>">Holidays</a></li>
	                			</ul>
	            				</li>
	            				<li><a href="<?php echo site_url('reports/reports'); ?>"><i class="icon-th-list icon-white"></i> Reports</a></a></li>
	            			<?php } ?>
	           				<li><a href="<?php echo site_url(); ?>/login/logout"><i class="icon-eye-close icon-white"></i> Log out</a></li>
	           				
           				<!-- but if the user isn't logged in, show the login button for them to use -->
           				<?php } else { ?>
           				<li><a data-toggle="modal" href="#loginbox" id="loginhint" data-content="Click here to log in"><i class="icon-eye-open icon-white"></i> Log in</a></li>
           	         				
           				<script>
							$(function (){
								$("#loginhint").popover({placement:'bottom'});  
								$("#loginhint").popover('show');
							});
						</script>
           		
           				<?php }?>
           				
       
           				
           				
            			
					</ul>
					<div class="pull-right navbar-text"><a data-toggle="modal" href="#aboutme" id="about" data-content="About BookMe"><i class="icon-question-sign icon-white"></i></a></div>
				</div>
			</div>
		</div>
	</div>
		
	<div id="aboutme" class="modal hide fade">
	<div class="modal-body">
		

		<center>
			<div class="alert alert-info" >About BookMe</div>
			<div>
				<h5>Currently running Version: 1.1.8</h5>
			</div>
			<br><br>
			<button class="btn btn-success" data-dismiss="modal">close</button>	
		</center>
	</div>
</div>
	
<div id="loginbox" class="modal hide fade">
	<div class="modal-body">
		<button class="close" data-dismiss="modal">×</button>
		<br><br>
		<center>
			<div class="alert alert-danger" >Please enter your login details</div>
			<form class="well" action="<?php echo base_url().index_page();?>/login/processlogin" method="post" id="processlogin" name="login">
				<label>Username</label>
				<input class="span2" id="username" size="16" type="text" name="username">
					<br>
				<label>Password</label>
				<input class="span2" id="password" size="16" type="password" name="password">
					<br>
					<br>
				<button type="submit" class="btn btn-success">Submit</button>
			</form>
		</center>
	</div>
</div>

	<script type="text/javascript" language="JavaScript">
	$('#loginbox').on('shown', function () {
		$("input#username").focus();
		});
		
	</script>