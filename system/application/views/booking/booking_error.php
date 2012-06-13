


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