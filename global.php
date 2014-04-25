<?php
	// Require Configuration File
	require_once('config.php');
	
	// Require Fram3w0rk
	require_once('Fram3w0rk/index.php');
	Instance::$import = array('class.php');
	Instance::load();
	
	// Create global array
	$_VARS = array();
	
	$_VARS['PHP']['version'] = phpversion();
	$_VARS['PAGE']['request']['get'] = $_GET;
	$_VARS['PAGE']['request']['post'] = $_POST;
	
	// Create default connect to DB
	DBI::setDefaults(DBI_SERVER, DBI_USER, DBI_PASS, DBI_DB);
	$DBI = Instance::get('DBI');
	$id = Log::$status[$DBI->connect()];
	
	// Pull in CMS variables
	$vars = Log::$status[$DBI->execute("SELECT * FROM module JOIN module_variable ON module.id = module_variable.module_id;", MYSQL_ASSOC)]['data']['result'];
	foreach($vars as $var) {
		switch ($var['type']) {
			case 'bool':
			case 'boolean':
			//	$_VARS[$var["module"]][$var['name']] = ((mb_strtoupper(trim($var['value'])) === mb_strtoupper("true")) ? TRUE : FALSE);
			//	break;
			case 'int':
			case 'integer':
			//	$_VARS[$var["module"]][$var['name']] = intval($var['value']);
			//	break;
			case 'json':
				$_VARS[$var["name"]] = json_decode($var['value'], true);
				break;
			case 'str':
			default:
				$_VARS[$var["module"]][$var['name']] = $var['value'];
		}
	}
	unset($vars);
	
	date_default_timezone_set($_VARS["WEBSITE"]['time_zone']);
	
	Instance::get('Session');
	$_VARS['WEBSITE']['account'] = Account::verify();
	$_VARS["WEBSITE"]['cookies'] = Log::$status[Session::getCookies()]['data'];
?>
