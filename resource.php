<?php
	require_once('global.php');
	
	//$_VARS["FILE"]['type'] = $_REQUEST["TYPE"];
	//$_VARS["FILE"]['name'] = $_REQUEST["NAME"];
	$_VARS["FILE"]['path'] = $_REQUEST["PATH"];
	$_VARS["FILE"]['download'] = $_REQUEST["download"];
	
	// Pull file data
	if(isset($_VARS["FILE"]['path']) && !empty($_VARS["FILE"]['path'])) $file = Log::$status[$DBI->execute('SELECT * FROM resource_size WHERE name = "' . $_VARS["FILE"]['path'] . '";',MYSQL_ASSOC)]['data']['result'][0];
	if(!isset($file) || empty($file)) {
		header('HTTP/1.0 404 Not Found');
		$page = Log::$status[$DBI->execute('SELECT * FROM page WHERE id = -404;',MYSQL_ASSOC)]['data']['result'][0];
		$_VARS["PAGE"] = array_merge((array)$_VARS["PAGE"], (array)$page);
		unset($page);
		Page::template($_VARS);
	}
	else {
		$_VARS["FILE"] = array_merge((array)$_VARS["FILE"], (array)$file);
		unset($file);
		$_VARS["FILE"]['size'] = @filesize($_VARS["FILE"]['content']);
		
		header("Content-type: " . $_VARS["FILE"]['type']);
		//header("Content-length: " . $_VARS["FILE"]['size']);
		//header('Content-Disposition: inline; filename=' . $_VARS["FILE"]['name']);
		if(isset($_VARS["FILE"]['download']) && (empty($_VARS["FILE"]['download']) || $_VARS["FILE"]['download'] == 'true')) header("Content-Disposition: attachment; filename=" . $_VARS["FILE"]['name']);
		print $_VARS["FILE"]['content'];
		//print_r($_VARS);
	}
	
	$DBI->disconnect();
?>
