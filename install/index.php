<?php


$db_config_path = '../system/application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod /application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
			$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
     		$redir .= "://".$_SERVER['HTTP_HOST'];
      		$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      		$redir = str_replace('install/','',$redir);
			header( 'Location: ' . $redir) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="../css/bootstrap.css" />
		<script src="../javascript/jquery.js"></script>
		<script src="../javascript/bootstrap-tooltip.js"></script>
		<script src="../javascript/bootstrap-popover.js"></script>
		<title>BookMe Installer</title>
	</head>
	
	<body>
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">	
				<div class="span1">&nbsp;</div>
   					<div class="span10 well">
						<center>
						<div class="alert alert-info"><h3>Database Settings</h3>
						</div>
						</center>
    				<?php if(is_writable($db_config_path)):?>
    				
						<div class="alert alert-info">
							You must manually create a database, username and password for BookMe in MySQL before continuing.
							Fill out the form below once this has been done
						</div>
    				
    				<?php if(isset($message)) {echo '<p class="alert alert-error">' . $message . '</p>';}?>
						<form class="form-horizontal" id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<fieldset>
						<div class="control-group">
          					<label class="control-label" for="hostname">Hostname</label>
           					<div class="controls">
              					<input type="text" class="input-xlarge" value="localhost" id="hostname" name="hostname" />
              					<p class="help-block"><i class="icon-question-sign" rel="tooltip" title="The hostname MySQL is installed on, typically localhost"></i></p>
            				</div>
          				</div>
          
						<div class="control-group">
          					<label class="control-label" for="username">Username</label>
           					<div class="controls">
              					<input type="text" class="input-xlarge" id="username" name="username" />
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The username you created for BookMe in MySQL"></i></p>
            				</div>
          				</div>
          				
          				<div class="control-group">
          					<label class="control-label" for="password">Password</label>
           					<div class="controls">
              					<input type="text" class="input-xlarge" id="password" name="password" />
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The password you created for BookMe in MySQL"></i></p>
            				</div>
          				</div>
          				
          				<div class="control-group">
          					<label class="control-label" for="database">Database name</label>
           					<div class="controls">
              					<input type="text" class="input-xlarge" id="database" name="database" />
              					<p class="help-block"><i class="icon-question-sign"rel="tooltip" title="The name you gave the database for BookMe"></i></p>
            				</div>
          				</div>
          				
          				<div class="form-actions">
            					<button type="submit" class="btn btn-primary" id="submit">Install</button>
            			</div>
						</fieldset>
		 				</form>
		 				<div class="alert alert-info">
							After installation is complete, you can log in for the first time with the default local admin login of <br>
							Username - <b>bookme_admin</b> <br>
							Password - <b>cr3ation</b>
						</div>
		  			<script type="text/javascript"> 
  						$(document).ready(function () { 
    					$("[rel=tooltip]").tooltip(); 
  						}); 
					</script> 
				</div>
			</div>
		</div>
	</div>
	
	<div class="span1">	
		&nbsp;
	</div>
	  <?php else: ?>
      <p class="alert alert-error">Please make the /system/application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 system/application/config/database.php</code></p>
	  <?php endif; ?>

	</body>
</html>

