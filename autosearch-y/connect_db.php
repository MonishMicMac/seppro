<?php
if (!isset($_SESSION)) {
    session_start();
}
if (file_exists("../include/db_config.php")) {
    include_once("../include/db_config.php");
} elseif (file_exists("../../include/db_config.php")) {
    include_once("../../include/db_config.php");
}

$host = !empty($_SESSION["HOST"]) ? $_SESSION["HOST"] : (defined('DB_HOST') ? DB_HOST : 'seppro_db');
if ($host === 'localhost' && defined('DB_HOST') && DB_HOST !== 'localhost') {
    $host = DB_HOST;
}
$user = !empty($_SESSION["DBUSR"]) ? $_SESSION["DBUSR"] : (defined('DB_USER') ? DB_USER : 'root');
$pass = isset($_SESSION["DBPWD"]) ? $_SESSION["DBPWD"] : (defined('DB_PASS') ? DB_PASS : '$3pp60@2016');
$dbname = !empty($_SESSION["DBNAME"]) ? trim($_SESSION["DBNAME"]) : (defined('DB_NAME') ? DB_NAME : '');

if (!defined("DB_HOST")) define("DB_HOST", $host);
if (!defined("DB_USER")) define("DB_USER", $user);
if (!defined("DB_PASS")) define("DB_PASS", $pass);
if (!defined("DB_NAME")) define("DB_NAME", $dbname);
?>
