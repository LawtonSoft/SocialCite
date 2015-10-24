<?php
	require_once('global.php');
	
	switch($_VARS["TYPE"]) {
	// PAGES
	default:
	case 'PAGE':
		$_VARS["PAGE"]['url_request'] = $_VARS["PATH"];
		$_VARS["PAGE"]['status_code'] = array('id' => 200);
		Module::writeCode('view/page', $_VARS);
		break;
	
	// MODULES
	case 'MODULE':
		$_VARS["MODULE"]['name'] = $_VARS["PATH"];
		Module::writeCode('view/module', $_VARS);
		break;
	
	// RESOURCES
	case 'RESOURCE':
		$_VARS["FILE"]['path'] = $_VARS["PATH"];
		$_VARS["FILE"]['download'] = $_REQUEST["download"];
		Module::writeCode('view/resource', $_VARS);
		break;
	}
	
	$DBI->disconnect();
	//htmlentities(print_r($_VARS));
	//htmlentities(print_r(Log::$status));
?>
