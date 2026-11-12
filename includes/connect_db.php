<?php 
$hostname=$_SESSION['host'];
$username=$_SESSION['user'];
$password=$_SESSION['pwd'];
$database=$_SESSION['db'];
$con=mysql_connect($hostname,$username,$password)or die('could not connect');
mysql_select_db($database,$con)or die ('could not database');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $con);	
?>