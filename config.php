<?php
	// ====     DEFAULTS     ====
	
	// ---      PHP MODE      ---
	error_reporting(E_STRICT);
	
	
	// ==== DEFINE CONSTANTS ====

	//  ---    DIRECTORIES    ---
	
	//       BASE DIRECTORY
	define('BASE_DIR', realpath($_SERVER["PHP_SELF"]));
	//          FRAM3W0RK
	define('FRAM3W0RK_DIR', '/var/www/Fram3w0rk/');

	//  ---        DBI        ---
	define('DBI_LANG', 'mysql');
	define('DBI_SERVER', 'localhost');
	define('DBI_USER', 'user');
	define('DBI_PASS', 'password');
	define('DBI_DB', 'dbname');
	define('DBI_PREFIX', '');
	
	//  ---        FTP        ---
	define('FTP_SERVER', 'localhost');
	define('FTP_USER', 'user');
	define('FTP_PASS', 'password');
	
	define('CMS_MODE', 'dev');
	
	//  ---     SECURITY      ---
	//       PASSWORD HASH
	define('PASSWORD_HASH_OPTIONS', Array(
		'cost' => 11,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	));
?>
