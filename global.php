<?php
	// Require Configuration File
	require_once('config.php');
	
	// Require Fram3w0rk and necessary classes
	require_once(FRAM3W0RK_DIR . 'index.php');
	Instance::$import = array('class.php');
	Instance::load();
	
	// Create global array
	$_VARS = array();
	
	// Create defaults for DBI
	$DBI = Instance::get('DBI');
	DBI::setDefaults(array("lang"=>DBI_LANG, "host"=>DBI_SERVER, "user"=>DBI_USER, "pass"=>DBI_PASS, "database"=>DBI_DB));
	$DBI->connect();
	
	// Create defaults for FTP
	FTP::setDefaults(FTP_SERVER, FTP_USER, FTP_PASS);
	$FTP = Instance::get('FTP');
	Log::$status[$FTP->connect()];
	
	// Pull in CMS variables
	$_VARS["SOCIALCITE"] = Module::variables('socialcite');
	$_VARS["WEBSITE"] = Module::variables('');
	
	$_VARS['PHP']['version'] = phpversion();
	if($_VARS["WEBSITE"]['mode'] == "DEV") $_VARS['PHP']['extensions'] = get_loaded_extensions();
	$_VARS['PAGE']['request']['get'] = $_GET;
	$_VARS['PAGE']['request']['post'] = $_POST;
	
	date_default_timezone_set($_VARS["WEBSITE"]['time_zone']);
	
	Instance::get('Session');
	$_VARS['WEBSITE']['account'] = Account::verify();
	$_VARS["WEBSITE"]['cookies'] = Log::$status[Session::getCookies()]['data'];
?>
