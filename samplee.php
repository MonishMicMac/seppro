<?php
define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS",""); // set database password
define ("DB_NAME","lupin"); // set database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
	
	
	ini_set('memory_limit', '-1');
	ini_set('max_execution_time', 15000);
	$SQL=mysql_query("SELECT id,state_id,district_id,pin_id,rep_id FROM tbl_customer_master");
	while($RS=mysql_fetch_object($SQL)){
		mysql_query("UPDATE areawise_temp SET rep_id='".$RS->rep_id."',state_id='".$RS->state_id."',district_id='".$RS->district_id."',pin_id='".$RS->pin_id."' WHERE our_cust_id = '".$RS->id."'");
	}
	echo mysql_error();
?>