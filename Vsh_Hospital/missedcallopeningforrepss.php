<?php
	include("connect.php");

date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$rep_id=$_REQUEST['rep_id'];

$strSQL = "SELECT * FROM  blockingopen WHERE repid='$rep_id' AND cdate='$cdate'";
$objQuery = $je->prepare($strSQL);
$objQuery ->execute();

	$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	// $array=mysql_fetch_array($objQuery);

// print_r($array);exit();
	
	echo json_encode($array);
?>