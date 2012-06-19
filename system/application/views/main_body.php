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
						<a class="btn span12 btn-warning" href="<?php echo base_url().index_page();?>/settings/rooms/add_room">
						<h4><center>There are no rooms defined, click this button to add one</center></h4>
						</a>
						<?php }?>

						<div class="span1">&nbsp;</div>
						
						<?php if ($period_count == 0){?>								
						<a class="btn span12 btn-warning" href="<?php echo base_url().index_page();?>/settings/periods/add_period">
						<h4><center>There are no periods defined, click this button to add one</center></h4>
						</a>
						<?php }?>
						
						<div class="span1">&nbsp;</div>
						
						<?php if ($subject_count == 0){?>				
						<a class="btn span12 btn-warning" href="<?php echo base_url().index_page();?>/settings/subjects/add_subject">
						<h4><center>There are no subjects defined, click this button to add one</center></h4>
						</a>
						<?php }?>
						
						<div class="span1">&nbsp;</div>
						
						<?php if ($year_count == 0){?>				
						<a class="btn span12 btn-warning" href="<?php echo base_url().index_page();?>/settings/years/add_year">
						<h4><center>There are no academic years defined, click this button to add one</center></h4>
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


	
 

