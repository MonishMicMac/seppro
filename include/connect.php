<?php
error_reporting(0);
if(!isset($_SESSION)) { 
	session_start(); 
} 

if (file_exists(dirname(__FILE__) . '/db_config.php')) {
   include_once(dirname(__FILE__) . '/db_config.php');
} elseif (file_exists(dirname(dirname(__FILE__)) . '/include/db_config.php')) {
   include_once(dirname(dirname(__FILE__)) . '/include/db_config.php');
}

$db_host = !empty($_SESSION["HOST"]) ? $_SESSION["HOST"] : (defined('DB_HOST') ? DB_HOST : 'seppro_db');
if ($db_host === 'localhost' && defined('DB_HOST') && DB_HOST !== 'localhost') {
   $db_host = DB_HOST;
}
$db_user = !empty($_SESSION["DBUSR"]) ? $_SESSION["DBUSR"] : (defined('DB_USER') ? DB_USER : 'root');
$db_pass = isset($_SESSION["DBPWD"]) ? $_SESSION["DBPWD"] : (defined('DB_PASS') ? DB_PASS : '$3pp60@2016');
$db_name = !empty($_SESSION["DBNAME"]) ? trim($_SESSION["DBNAME"]) : (defined('DB_NAME') ? DB_NAME : '');

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!empty($db_name)) {
   mysql_select_db($db_name, $con);
}
?>
