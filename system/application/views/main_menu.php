	<?php 
	$authenticated = $this->session->userdata('authenticated'); 
	$accesslevel = $this->session->userdata('accesslevel');
	$school_name = $data['school_name'] = $this->Settings_model->get_school_name();
	?>
	
	<div class="container-fluid">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					
					<?php 
					if ($school_name == '') 
					{ ?>
					<a class="brand" href="<?php echo base_url();?>">Book<i class="icon-calendar icon-white"></i>Me</a>
					<?php 
					} else {
					?>
					<a class="brand" href="<?php echo base_url();?>">Book<i class="icon-calendar icon-white"></i>Me @ <?php echo $school_name;?></a>
					<?php 
					}
					?>
					
					
					<ul class="nav">
					 	<li class="divider-vertical"></li>
           				
           				
           				<!-- if user is already logged in, show the log out option -->
           				<?php if ($authenticated == 1) { ?>
           				<li class="navbar-text">Logged in as : <?php echo $this->session->userdata('fullname');?></li>
           				<li class="divider-vertical"></li>
           				<li><a href="<?php echo site_url(); ?>/main/logout"><i class="icon-eye-close icon-white"></i> Log out</a></li>
           				
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
           				
       
           				
           				<!-- if the user is an admin, show the settings options, else hide them -->
           				<?php if ($accesslevel == 'admin') {?>
           				<li class="dropdown">
              				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i> Settings <b class="caret"></b></a>
              				<ul class="dropdown-menu">
              					<li><a href="<?php echo site_url(); ?>/settings/general_settings">General</a></li>
                				<li><a href="<?php echo site_url(); ?>/settings/auth_settings">Authorisation</a></li>
                				<li><a href="<?php echo site_url(); ?>/settings/room_settings">Rooms</a></li>
                				<li><a href="<?php echo site_url(); ?>/settings/period_settings">Periods</a></li>
                				<li><a href="<?php echo site_url(); ?>/settings/subject_settings">Subjects</a></li>
                				<li><a href="<?php echo site_url(); ?>/settings/holiday_settings">Holidays</a></li>
                			</ul>
            			</li>
            			<?php } ?>
            			
					</ul>
				</div>
			</div>
		</div>
	</div>