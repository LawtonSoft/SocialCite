<?php
	// Require Configuration File
	require_once('config.php');
	
	// Require Fram3w0rk and necessary classes
	require_once(FRAM3W0RK_DIR . 'index.php');
	Instance::$import = array('class.php');
	Instance::load();
	Log::$blnLog = TRUE;
	
	// Create global array
	$_VARS = array();
	
	// Create defaults for DBI
	$DBI = Instance::get('DBI');
	DBI::setDefaults(array("lang"=>DBI_LANG, "host"=>DBI_SERVER, "user"=>DBI_USER, "pass"=>DBI_PASS, "database"=>DBI_DB));
	$DBI->connect();
	
	// Create defaults for FTP
	FTP::setDefaults(FTP_SERVER, FTP_USER, FTP_PASS);
	$FTP = Instance::get('FTP');
	$FTP->connect();
	
	// Pull in CMS variables
	$_VARS["WEBSITE"] = Module::getInfo('');
	$_VARS["WEBSITE"] = $_VARS["WEBSITE"]["values"];
	
	$_VARS['PHP']['version'] = phpversion();
	if($_VARS["WEBSITE"]['mode'] == "DEV") $_VARS['PHP']['extensions'] = get_loaded_extensions();
	$_VARS['PAGE']['request']['get'] = $_GET;
	$_VARS['PAGE']['request']['post'] = $_POST;
	$_VARS['PAGE']['request']['all'] = $_REQUEST;
	
	// Unset rewrite variables
	unset($_VARS['PAGE']['request']['get']["TYPE"]);
	unset($_VARS['PAGE']['request']['post']["TYPE"]);
	unset($_VARS['PAGE']['request']['both']["TYPE"]);
	unset($_VARS['PAGE']['request']['get']["PATH"]);
	unset($_VARS['PAGE']['request']['post']["PATH"]);
	unset($_VARS['PAGE']['request']['both']["PATH"]);
	$_VARS["TYPE"] = $_REQUEST["TYPE"];
	$_VARS["PATH"] = $_REQUEST["PATH"];
	
	unset($_GET["TYPE"]);
	unset($_POST["TYPE"]);
	unset($_REQUEST["TYPE"]);
	unset($_GET["PATH"]);
	unset($_POST["PATH"]);
	unset($_REQUEST["PATH"]);
	
	date_default_timezone_set($_VARS["WEBSITE"]['time_zone']);
	
	Instance::get('Session');
	$_VARS['WEBSITE']['account'] = Account::verify();
	$_VARS["WEBSITE"]['cookies'] = Session::getCookies();
	$_VARS["WEBSITE"]['cookies'] = $_VARS["WEBSITE"]['cookies']['data'];
?>
