<?php

include("connect.php"); 




$repid=$_REQUEST['repid'];

$strSQL = "SELECT * FROM blockingopen WHERE repid='$repid'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>