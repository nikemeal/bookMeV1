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
						
MIDDLE SECTION FOR ADMIN MEMBER<br><br>
<ul>
<li>bookings for $room_name for w/c $start_date of this week</li>
<li>timetable view of room getting this weeks date - showing each cell as a period - x.axis=days / y.axis=periods</li>
<li>ability to multi select rooms and book all under one subject/name - or single click and select "make booking"</li>
<li>button options : book period/s - view booking info</li>
</ul>
						
					</div>
				
				<?php
				}
				elseif ($accesslevel == 'staff')
				{
				?>
					<div class="span10">
									
MIDDLE SECTION FOR STAFF MEMBER - which will show <br><br>
<ul>
<li>bookings for $room_name for w/c $start_date of this week</li>
<li>timetable view of room getting this weeks date - showing each cell as a period - x.axis=days / y.axis=periods</li>
<li>ability to multi select rooms and book all under one subject/name - or single click and select "make booking"</li>
<li>button options : book period/s - view booking info</li>
</ul>
	
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


	
 

