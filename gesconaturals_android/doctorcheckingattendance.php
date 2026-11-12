<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$repid=$_REQUEST['repid'];
$doctorid=$_REQUEST['doctorid'];
$date=$_REQUEST['date'];

$strSQL = "SELECT * FROM reportforattendance WHERE doctorid='$doctorid' AND repid='$repid' AND date='$date'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>