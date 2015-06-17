<?php
	class Page Extends Instance {
		protected static $instance = NULL;
		
		public static function get404() {
			global $_VARS;
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			$_VARS["PAGE"]['status_code'] = array('id' => 404);
			return Log::$status[$DBI->execute('SELECT * FROM page WHERE id = -404;',MYSQL_ASSOC)]['data']['result'][0];
		}
		
		public static function template() {
			global $_VARS;
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			if($_VARS["PAGE"]['page_type_id'] < 3) {
				eval('?>' . Log::$status[$DBI->execute('SELECT code FROM template WHERE id =' . $_VARS["WEBSITE"]['template_id'] . ';',MYSQL_ASSOC)]['data']['result'][0]['code']);
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
			//$permissions = Log::$status[$DBI->execute('SELECT permissions.* FROM permissions JOIN page_permissions ON permissions.id = page_permissions.permissions_id JOIN page ON page_permissions.page_id = page.id WHERE page.id = ' . $pageID . ';',MYSQL_ASSOC)]["data"]["result"];
			$permissions = Log::$status[$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN page_permissions ON permissions.id = page_permissions.permissions_id JOIN page ON page_permissions.page_id = page.id WHERE page.id = ' . $pageID . ') UNION (SELECT DISTINCT permissions.* FROM permissions JOIN page_group_permissions ON permissions.id = page_group_permissions.permissions_id JOIN page_group ON page_group_permissions.page_group_id = page_group.id JOIN page_group_member ON page_group.id = page_group_member.page_group_id JOIN page ON page_group_member.page_id = page.id WHERE page.id = ' . $pageID . ');',MYSQL_ASSOC)]["data"]["result"];
			return $permissions;
		}
	}
	
	class Module Extends Instance {
		protected static $instance = NULL;
		
		// Get Module Variables
		public static function variables($url /* string $url */) {
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			$vars = Log::$status[$DBI->execute("SELECT * FROM module WHERE LOWER(url) = '" . strtolower($url) . "';", MYSQL_ASSOC)]['data']['result'][0];
			try {
				$variables = json_decode($vars['variables'], true);
			}
			catch (Exception $e) {
				$variables = $vars['variables'];
			}
			
			return $variables;
		}
		
		// Check Module Position for Modules (requires template ID and position name)
		public static function check($template_id, $position_name /* int $template_id, string $position_name */) {
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			$modules = Log::$status[$DBI->execute("SELECT CONCAT(module.url, '/', module_code.url) url FROM module_code JOIN module ON module_code.module_id = module.id WHERE module_code.id IN (SELECT module_script_id FROM template_module_script_position WHERE template_position_id IN (SELECT id FROM template_position WHERE template_id = " . $template_id . " AND name = '" . $position_name . "'));", MYSQL_ASSOC)]['data']['result'];
			return $modules;
		}
		
		// Get Module Code
		public static function get(/* string $url */) {
			$args = func_get_args();
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			$url = $args[0];
			
			//$module = Log::$status[$DBI->execute('SELECT * FROM module_code WHERE url = "' . $url . '";', MYSQL_ASSOC)]['data']['result'][0];
			$module = Log::$status[$DBI->execute("SELECT module_code.*, module.name module_name, module.url module_url FROM module_code JOIN module ON module_code.module_id = module.id WHERE (module.url IS NULL OR module.url = '') AND module_code.url = '" . $url . "' OR CONCAT(module.url, '/', module_code.url) = '" . $url . "';", MYSQL_ASSOC)]["data"]["result"][0];
			if(!empty($module)) {
				$module["url"] = (isset($module["module_url"]) && !empty($module["module_url"]) ? $module["module_url"] . '/' : '') . $module["url"];
				//unset($module["module_url"]);
				return $module;
			}
		}
		
		// Write Module Code (evals PHP or pastes code)
		public static function write(/* string $url [, mixed $data = null] */) {
			$args = func_get_args();
			$DBI = Instance::get('DBI');
			$id = Log::$status[$DBI->connect()];
			
			$url = $args[0];
			if(isset($args[1]) && !empty($args[1])) $data = $args[1];
			
			$module_url = self::get($url);
			
			require('global.php');
			$_VARS["MODULE"][$module_url["module_url"]] = array_merge((array)Module::variables($module_url["module_url"]), (array)$module_url);
			$module_url = $module_url["module_url"];
			switch($_VARS["MODULE"][$module_url]["data_format_id"]) {
				case 3:
					eval('?>' . $_VARS["MODULE"][$module_url]["code"]);
					break;
				case 2:
					echo $_VARS["MODULE"][$module_url]["code"];
					break;
				case 4:
					echo $_VARS["MODULE"][$module_url]["code"];
					break;
				case 1:
				default:
					echo htmlentities($_VARS["MODULE"][$module_url]["code"]);
			}
			unset($_VARS["MODULE"][$module_url]);
			unset($module_url);
		}
		
		// Get Permissions
		public static function permissions(/* int $moduleCodeID [, $userID = null ] */) {
			$args = func_get_args();
                        $moduleCodeID = $args[0];
			
			if(isset($args[1])) $userID = $args[1];
			
			$DBI = Instance::get('DBI');
			$permissions = Log::$status[$DBI->execute('SELECT permissions.* FROM permissions JOIN module_code_permissions ON permissions.id = module_code_permissions.permissions_id JOIN module_code ON module_code_permissions.module_code_id = module_code.id WHERE module_code.id = ' . $moduleCodeID . ';',MYSQL_ASSOC)]["data"]["result"];
			return $permissions;
		}
	}
	
	// User Class
	class Account Extends Instance {
		protected static $instance = NULL;
		
		// Get User Info
		public static function getUser($username) {
			$DBI = Instance::get('DBI');
			$result["success"] = 0;
			
			if(isset($username)) {
				$user = Log::$status[$DBI->execute('SELECT * FROM user WHERE lower(username) = "' . strtolower($username) . '";',MYSQL_ASSOC)]["data"]["result"][0];
				if(isset($user) && !empty($user)) {
					$result["data"] = $user;
					$result["permissions"] = Log::$status[$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN user_permissions ON permissions.id = user_permissions.permissions_id JOIN user ON user_permissions.user_id = user.id WHERE user.id = "' . $user['id'] . '") UNION (SELECT DISTINCT permissions.* FROM permissions JOIN user_group_permissions ON permissions.id = user_group_permissions.permissions_id JOIN user_group ON user_group_permissions.user_group_id = user_group.id JOIN user_group_member ON user_group.id = user_group_member.user_group_id JOIN user ON user_group_member.user_id = user.id WHERE user.id = "' . $user['id'] . '");',MYSQL_ASSOC)]["data"]["result"];
					$result["message"] = "Account verified";
					$result["success"] = 1;
				}
				else $result["message"] = "No User Found";
			}
			else $result["message"] = "Insufficient Data";
			return $result;
		}
		
		// Login
		public static function login(/* string $username, string $password, int $timeout [, mixed $options = null ] */) {
			$args = func_get_args();
			$username = $args[0];
			$password = $args[1];
			$timeout = $args[2];
			$options = $args[3];
			
			$DBI = Instance::get('DBI');
			$result["success"] = 0;
			
			if(isset($username) && isset($password)) {
				$verify = Log::$status[$DBI->execute('SELECT * FROM user WHERE lower(username) = "' . strtolower($username) . '" AND password = "' . md5($password) . '";',MYSQL_ASSOC)]["data"]["result"][0];
				if(isset($verify) && !empty($verify)) {
					$result["data"] = $verify;
					$result["permissions"] = Log::$status[$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN user_permissions ON permissions.id = user_permissions.permissions_id JOIN user ON user_permissions.user_id = user.id WHERE user.id = "' . $user['id'] . '") UNION (SELECT DISTINCT permissions.* FROM permissions JOIN user_group_permissions ON permissions.id = user_group_permissions.permissions_id JOIN user_group ON user_group_permissions.user_group_id = user_group.id JOIN user_group_member ON user_group.id = user_group_member.user_group_id JOIN user ON user_group_member.user_id = user.id WHERE user.id = "' . $user['id'] . '");',MYSQL_ASSOC)]["data"]["result"];
					self::logout();
					
					Instance::get('Session');
					Session::setCookies('username', $username, $timeout);
					Session::setCookies('password', md5($password), $timeout);
					setCookie('timeout', $timeout, time() + $timeout);
					$result["message"] = "Account verified";
					$result["success"] = 1;
				}
				else $result["message"] = "Bad Credentials";
			}
			else $result["message"] = "Insufficient Data";
			
			return $result;
		}
		
		// Logout
		public static function logout() {
			global $_VARS;
			Instance::get('Session');
			Log::$status[Session::unsetCookies('username')]['data'];
			Log::$status[Session::unsetCookies('password')]['data'];
			$_VARS["WEBSITE"]["account"] = array("success" => 0, "message" => "Insufficient Data");
			return TRUE;
		}
		
		// Verify Account
		public static function verify() {
			$DBI = Instance::get('DBI');
			$result["success"] = 0;
			
			if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
				$verify = Log::$status[$DBI->execute('SELECT id, username, password, email_address, first_name, last_name FROM user WHERE username = "' . $_COOKIE["username"] . '" AND password = "' . $_COOKIE["password"] . '";',MYSQL_ASSOC)]["data"]["result"][0];
				if(isset($verify) && !empty($verify)) {
					$result["data"] = $verify;
					$result["permissions"] = Log::$status[$DBI->execute('(SELECT DISTINCT permissions.* FROM permissions JOIN user_permissions ON permissions.id = user_permissions.permissions_id JOIN user ON user_permissions.user_id = user.id WHERE user.id = "' . $user['id'] . '") UNION (SELECT DISTINCT permissions.* FROM permissions JOIN user_group_permissions ON permissions.id = user_group_permissions.permissions_id JOIN user_group ON user_group_permissions.user_group_id = user_group.id JOIN user_group_member ON user_group.id = user_group_member.user_group_id JOIN user ON user_group_member.user_id = user.id WHERE user.id = "' . $user['id'] . '");',MYSQL_ASSOC)]["data"]["result"];
					$result["message"] = "Account verified";
					$result["success"] = 1;
				}
				else $result["message"] = "Bad Credentials";
			}
			else $result["message"] = "Insufficient Data";
			
			return $result;
		}
	}
?>
