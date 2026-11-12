<?php
	include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];


$year = date('Y');


$strSQL = "SELECT TRIM(TRAILING '\r' FROM expenses) AS expenses,leaveapplieddate,reason,filename FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'";


$objQuery = $je->prepare($strSQL);
$objQuery ->execute();

	
	$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);





?>