<?php
ob_start();
@session_start();

$timezone='Asia/Kolkata';
date_default_timezone_set($timezone);
define("HOST", "localhost"); 
define("DB_NAME", "espl"); 
define("USER", "root"); 
define("PASS", "");

//define('DB_TYPE', 'mysql');
//define('DB_CHARSET','utf8');
//define('ADMIN_EMAIL','hr@abts.co.in');

//define ("SUCCESS", 1);  // Don't edit
//define ("FAILED", -1);  // Don't edit

define("ROOT_PATH", "http://localhost/dinesh/final/");
//define("ROOT_PATH", "http://10.0.0.4/chettinad/");
define("BASE_PATH", "C:\Program Files\Zend\Apache2\htdocs\dinesh" );
define("TITLE",'ESPL');
//define("BASE_PATH", "F:\\wamp\\www\\chettinad1");
//$dbHandle = DbHandler::getInstance();

// Executes Insert Query
class DbHandler
{

private static $instance;
	private $host=HOST;
	private $user=USER;
	private $password=PASS;
	private $dbName=DB_NAME;
	
	private $query;
	private $connection;
	private $str;


	public function insertQuery($table, $insertArray)
	{
		if(!$this->connection) throw(new Exception("Connection not Established"));
		$columns = implode(",", array_keys($insertArray));
		$values  = implode(",", array_values($insertArray));
		
		$insertQuery = "insert into $table ($columns) values ($values)";
		//echo $insertQuery;exit;
		$resultSet=mysql_query($insertQuery,$this->connection);
		if($resultSet)
		return true;
		else
		return false;
	}
}	
	?>