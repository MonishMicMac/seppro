<?php

include("connect.php"); 




$repid=$_REQUEST['repid'];

$strSQL = "SELECT * FROM reorting WHERE pickups LIKE '%1%' AND repid='$repid'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>