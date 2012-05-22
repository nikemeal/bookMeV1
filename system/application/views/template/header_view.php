<head>
	<title>BookMe - Booking System</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui-timepicker-addon.css">
		
	<?php $data['bg_colour'] = $this->Settings_model->get_bg_colour(); ?>
	<style type="text/css">body {background-color: #<?php echo $data['bg_colour'];?>;}</style>
	
	<script src="<?php echo base_url(); ?>javascript/jquery.js"></script>
	<script src="<?php echo base_url(); ?>javascript/jquery-ui.js"></script>
	<script src="<?php echo base_url(); ?>javascript/jquery-ui-timepicker-addon.js"></script>
	<script src="<?php echo base_url(); ?>javascript/bootstrap-dropdown.js"></script>
	<script src="<?php echo base_url(); ?>javascript/bootstrap-modal.js"></script>
	<script src="<?php echo base_url(); ?>javascript/bootstrap-transition.js"></script>
	<script src="<?php echo base_url(); ?>javascript/bootstrap-tooltip.js"></script>
	<script src="<?php echo base_url(); ?>javascript/bootstrap-popover.js"></script>
	<script src="<?php echo base_url(); ?>javascript/jscolor.js"></script>
</head>