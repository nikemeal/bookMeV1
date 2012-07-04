<?php 

if (isset($error))
{?>
	<script type="text/javascript" >
$(document).ready(function() { 
 	$('#year_error').modal({
 		backdrop: "static"
 	});
    $('#year_error').modal('show') 
 
}); 
</script>
<div id="year_error" class="modal hide fade">
	<div class="modal-body">
		<center>
			<div class="alert alert-danger" ><b>Cannot delete year</b></div>

			<div class="well">
				This year is set as the current active academic year.  Please set another year as active
				before trying to delete this year
					<br>
					<a class="btn btn-info" href="<?php echo site_url('settings/years/year_settings'); ?>">OK</a>
				
			</div>
		</center>
	</div>
</div>
<?php 
}
else 
{
	$this->load->helper('url');
	redirect('/settings/years/year_settings/', 'refresh');
}
?>
