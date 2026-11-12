<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$chemisid=$_REQUEST['chemisid'];


$strSQL = "SELECT * FROM tbl_customer_master WHERE rep_id='$pid' AND id!='$chemisid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>