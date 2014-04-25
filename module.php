<?php
	require_once('global.php');
	
	$_VARS["MODULE"]['name'] = $_REQUEST["PATH"];
	// Pull module data
	if(isset($_VARS["MODULE"]['name']) && !empty($_VARS["MODULE"]['name'])) $module = Module::get($_VARS["MODULE"]["name"]);
	if(!isset($module) || empty($module)) $page = Page::get404();
	
	$_VARS["MODULE"]['permissions'] = Module::permissions($module['id']);
	$_VARS["MODULE"]['allow'] = 1;
	if($_VARS["MODULE"]['permissions'] != null) {
		if($_VARS["WEBSITE"]['account']['success'] == 1) {
			foreach($_VARS["MODULE"]["permissions"] as $i=>$page_permission) {
				$allow = false;
				foreach($_VARS["WEBSITE"]['account']['permissions'] as $user_permission) {
					if($page_permission == $user_permission) $allow = true;
				}
				if(!$allow) {
					$_VARS["MODULE"]['allow'] = 0;
					$page = Page::get404();
					unset($allow);
					break;
				}
				unset($allow);
			}
		}
		else {
			$_VARS["MODULE"]['allow'] = 0;
			$page = Page::get404();
		}

	}
	if(isset($page['id'])) {
		$_VARS["PAGE"] = array_merge((array)$_VARS["PAGE"], (array)$page);
		unset($page);
		Page::template($_VARS);
	}
	else {
		$_VARS["MODULE"] = array_merge((array)$_VARS["MODULE"], (array)$module);
		unset($module);
		header('Content-type: ' . $_VARS["MODULE"]['content_type']);
		Module::write($_VARS["MODULE"]['name']);
	}
	$DBI->disconnect();
?>
