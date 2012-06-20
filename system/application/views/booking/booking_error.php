


<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">

			<div class="span12">
				<div class="span2">&nbsp;</div>
				<div class="span8 well">
					<div>
						<?php
							if ($error_reason == "no period selected")
							{
								echo "<h3>No periods selected</h3>";
							}
							elseif ($error_reason == "period already booked")
							{
								echo "<h3>Period already booked</h3>";
							}
							elseif ($error_reason == "not admin block delete")
							{
								echo "<h3>Only administrator users can edit/delete block bookings</h3>";
							}
							elseif ($error_reason == "not your booking")
							{
								echo "<h3>This booking does not belong to you</h3>";
							}
							elseif ($error_reason == "multiple cells selected")
							{
								echo "<h3>You selected multiple bookings to delete</h3>";
							}
							elseif ($error_reason == "no bookings selected")
							{
								echo "<h3>You didn't select any bookings</h3>";
							}
							elseif ($error_reason == "cell is empty")
							{
								echo "<h3>You selected an empty cell</h3>";
							}
						?>
					</div>
					<div>
						<p>error info here</p>
					</div>
					<div>
						<a href="<?php echo $previous_url ;?>" class="btn">back</a>
					</div>
				</div>
				<div class="span2">&nbsp;</div>
			</div>
			
		</div>
	</div>
</div>