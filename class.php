<?php
	// Page Class
	class Page Extends Instance {
		protected static $instance = NULL;
		
		public static function get404() {
			global $_VARS;
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			$_VARS["PAGE"]['status_code'] = array('id' => 404);
			$DBI->execute('SELECT * FROM view_page page WHERE id = ' . $_VARS["WEBSITE"]["404_page_id"] . ';', MYSQL_ASSOC);
			return Log::$statusLast['data']['result'][0];
		}
		
		public static function template() {
			$args = func_get_args();
			global $_VARS;
			if(isset($args[0])) $templateID = $args[0];
			else $templateID = $_VARS["WEBSITE"]['template_id'];
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			if($_VARS["PAGE"]['page_type_id'] < 3) {
				$code = $DBI->execute('SELECT code FROM template WHERE id =' . $templateID . ';',MYSQL_ASSOC);
				eval('?>' . $code['data']['result'][0]['code']);
			}
			else {
				eval('?>' . $_VARS["PAGE"]['body']);
			}
		}
		
		public static function permissions(/* [ int $pageID [, $userID = null ]] */) {
			$args = func_get_args();
			$pageID = $args[0];
			if(isset($args[1])) $userID = $args[1];
			
			$DBI = Instance::get('DBI');
			//$DBI->execute('SELECT permissions.* FROM permissions JOIN page_permissions ON permissions.id = page_permissions.permissions_id JOIN page ON page_permissions.page_id = page.id WHERE page.id = ' . $pageID . ';',MYSQL_ASSOC);
			//$permissions = Log::$statusLast["data"]["result"];
			$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN page_permissions ON permissions.id = page_permissions.permissions_id JOIN page ON page_permissions.page_id = page.id WHERE page.id = ' . $pageID . ') UNION (SELECT DISTINCT permissions.* FROM permissions JOIN page_group_permissions ON permissions.id = page_group_permissions.permissions_id JOIN page_group ON page_group_permissions.page_group_id = page_group.id JOIN page_group_member ON page_group.id = page_group_member.page_group_id JOIN page ON page_group_member.page_id = page.id WHERE page.id = ' . $pageID . ');',MYSQL_ASSOC);
			return Log::$statusLast["data"]["result"];
		}
	}
	
	// Module Class
	class Module Extends Instance {
		protected static $instance = NULL;
		
		// Get Module Values
		public static function getInfo(/* int $id or string $url */) {
			$args = func_get_args();
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			if(is_numeric($args[0])) $DBI->execute("SELECT * FROM module WHERE id = " . $args[0] . ";", MYSQL_ASSOC);
			else $DBI->execute("SELECT * FROM module WHERE LOWER(url) = '" . strtolower($args[0]) . "';", MYSQL_ASSOC);
			
			$moduleInfo = Log::$statusLast['data']['result'][0];
			$vals = Log::$statusLast['data']['result'][0]['values'];
			try {
				$values = json_decode($vals, true);
			}
			catch (Exception $e) {
				$values = $vals;
			}
			
			$moduleInfo["values"] = $values;
			
			return $moduleInfo;
		}
		
		// Check Module Position for Modules (requires template ID and position name)
		public static function check($template_id, $position_name /* int $template_id, string $position_name */) {
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			$DBI->execute("SELECT module_code.id id FROM module_code JOIN module ON module_code.module_id = module.id WHERE module_code.id IN (SELECT module_code_id FROM template_module_code_position WHERE template_position_id IN (SELECT id FROM template_position WHERE template_id = " . $template_id . " AND name = '" . $position_name . "'));", MYSQL_ASSOC);
			return Log::$statusLast['data']['result'];
		}
		
		// Get Module Code
		public static function getCode(/* int $id or string $url */) {
			$args = func_get_args();
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			if(is_numeric($args[0])) $DBI->execute("SELECT module_code.*, module.name module_name, module.url module_url FROM module_code JOIN module ON module_code.module_id = module.id WHERE module_code.id = " . $args[0] . ";", MYSQL_ASSOC);
			else $DBI->execute("SELECT module_code.*, module.name module_name, module.url module_url FROM module_code JOIN module ON module_code.module_id = module.id WHERE (module.url IS NULL OR module.url = '') AND module_code.url = '" . $args[0] . "' OR CONCAT(module.url, '/', module_code.url) = '" . $args[0] . "';", MYSQL_ASSOC);
			
			$moduleCode = Log::$statusLast["data"]["result"][0];
			if(!empty($moduleCode)) {
				$moduleCode["url"] = (isset($moduleCode["module_url"]) && !empty($moduleCode["module_url"]) ? $moduleCode["module_url"] . '/' : '') . $moduleCode["url"];
				return $moduleCode;
			}
		}
		
		// Write Module Code (evals PHP or pastes code)
		public static function writeCode(/* int $id or string $url [, mixed $data = null] */) {
			$args = func_get_args();
			$DBI = Instance::get('DBI');
			$DBI->connect();
			
			if(isset($args[1]) && !empty($args[1])) $data = $args[1];
			
			require('global.php');
			global $_VARS;
			
			// Get module code
			$moduleCode = self::getCode($args[0]);
			// Set $_VARS["MODULE"] with module info
			if($moduleCode["module_url"] != null) $_VARS["MODULE"][$moduleCode["module_url"]] = Module::getInfo($moduleCode["module_url"]);
			
			// For module pages where page will still need data after module code is written [UNTESTED]
			//if(isset($_VARS["MODULE"][$moduleCode["module_url"]]) && $_VARS["MODULE"][$moduleCode["module_url"]] != null) $originalModule = $_VARS["MODULE"][$moduleCode["module_url"]];
			// Join module and parsed values
			
			switch($moduleCode["data_format_id"]) {
				case 3:
					eval('?>' . $moduleCode["code"]);
					break;
				case 2:
					echo $moduleCode["code"];
					break;
				case 4:
					echo $moduleCode["code"];
					break;
				case 1:
				default:
					echo htmlentities($moduleCode["code"]);
			}
			
			// For module pages where page will still need data after module code is written
			//if(isset($originalModule)) $_VARS["MODULE"][$module] = $originalModule;
		}
		
		// Get Permissions
		public static function permissions(/* int $moduleCodeID [, $userID = null ] */) {
			$args = func_get_args();
                        $moduleCodeID = $args[0];
			
			if(isset($args[1])) $userID = $args[1];
			
			$DBI = Instance::get('DBI');
			$DBI->execute('SELECT permissions.* FROM permissions JOIN module_code_permissions ON permissions.id = module_code_permissions.permissions_id JOIN module_code ON module_code_permissions.module_code_id = module_code.id WHERE module_code.id = ' . $moduleCodeID . ';',MYSQL_ASSOC);
			return Log::$statusLast["data"]["result"];
		}
	}
	
	// (User) Account Class
	class Account Extends Instance {
		protected static $instance = NULL;
		
		// Get User Info
		public static function getUser($username) {
			$DBI = Instance::get('DBI');
			$result["success"] = 0;
			
			if(isset($username)) {
				$DBI->execute('SELECT * FROM user WHERE lower(username) = "' . strtolower($username) . '";',MYSQL_ASSOC);
				if(!empty(Log::$statusLast["data"]["result"][0])) {
					$result["data"] = Log::$statusLast["data"]["result"][0];
					$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN user_permissions ON permissions.id = user_permissions.permissions_id JOIN user ON user_permissions.user_id = user.id WHERE user.id = "' . $user['id'] . '") UNION (SELECT DISTINCT permissions.* FROM permissions JOIN user_group_permissions ON permissions.id = user_group_permissions.permissions_id JOIN user_group ON user_group_permissions.user_group_id = user_group.id JOIN user_group_member ON user_group.id = user_group_member.user_group_id JOIN user ON user_group_member.user_id = user.id WHERE user.id = "' . $user['id'] . '");',MYSQL_ASSOC);
					$result["permissions"] = Log::$statusLast["data"]["result"];
					$result["message"] = "Account verified";
					$result["success"] = 1;
				}
				else $result["message"] = "No User Found";
			}
			else $result["message"] = "Insufficient Data";
			return $result;
		}
		
		// Sign In
		public static function signIn(/* string $username, string $password, int $timeout [, mixed $options = null ] */) {
			global $_VARS;
			$args = func_get_args();
			$username = strtolower($args[0]);
			$password = $args[1];
			$timeout = $args[2];
			$options = $args[3];
			
			$DBI = Instance::get('DBI');
			$result = self::verify($username, $password);
			
			if($result["success"]) {
				Instance::get('Session');
				Session::setCookies('username', $result["data"]["username"], $timeout, $_VARS["WEBSITE"]['cookie_path'], $_VARS["WEBSITE"]['cookie_domain'], $_VARS["WEBSITE"]['cookie_secure']);
				Session::setCookies('password', $result["data"]["password"], $timeout, $_VARS["WEBSITE"]['cookie_path'], $_VARS["WEBSITE"]['cookie_domain'], $_VARS["WEBSITE"]['cookie_secure']);
			}
			
			return $result;
		}
		
		// Sign Out
		public static function signOut() {
			global $_VARS;
			Instance::get('Session');
			Session::unsetCookies('username', $_VARS["WEBSITE"]['cookie_path'], $_VARS["WEBSITE"]['cookie_domain'], $_VARS["WEBSITE"]['cookie_secure']);
			Session::unsetCookies('password', $_VARS["WEBSITE"]['cookie_path'], $_VARS["WEBSITE"]['cookie_domain'], $_VARS["WEBSITE"]['cookie_secure']);
			$_VARS["WEBSITE"]["account"] = array("success" => 0, "message" => "Insufficient Data");
			return TRUE;
		}
		
		// Verify Account
		public static function verify(/* [string $username, string $password] */) {
			require_once('password.php');
			$args = func_get_args();
			if(isset($args[0])) $username = strtolower($args[0]);
			elseif(isset($_COOKIE["username"])) $username = $_COOKIE["username"];
			
			$DBI = Instance::get('DBI');
			$result["success"] = 0;
			
			if(isset($username) && !empty($username)) {
				$DBI->execute('SELECT * FROM user WHERE lower(username) = "' . strtolower($username) . '" OR lower(email_address) = "' . strtolower($username) . '";',MYSQL_ASSOC);
				if($data = Log::$statusLast["data"]["result"][0]) {
					if(isset($args[1])) $verify = password_verify($args[1], $data["password"]);
					elseif(isset($_COOKIE["password"])) $verify = ($data["password"] == $_COOKIE["password"]);
					if(isset($verify) && $verify) {
						$result["data"] = $data;
						$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN user_permissions ON permissions.id = user_permissions.permissions_id WHERE user_id = "' . $user['id'] . '") UNION (SELECT DISTINCT permissions.* FROM permissions JOIN user_group_permissions ON permissions.id = user_group_permissions.permissions_id JOIN user_group ON user_group_permissions.user_group_id = user_group.id JOIN user_group_member ON user_group.id = user_group_member.user_group_id WHERE user_id = "' . $user['id'] . '");',MYSQL_ASSOC);
						$result["permissions"] = Log::$statusLast["data"]["result"];
						$result["message"] = "Account verified";
						$result["success"] = 1;
					}
					else $result["message"] = "Bad Credentials";
				}
				else $result["message"] = "User Not Found";
			}
			else $result["message"] = "Insufficient Data";
			
			return $result;
		}
	}
?>
