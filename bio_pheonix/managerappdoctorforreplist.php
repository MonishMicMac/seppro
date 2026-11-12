<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
// $strSQL = "SELECT * FROM doctors,master_pincode WHERE master_pincode.pin_id=doctors.doc_pin_id AND doctors.rep_id='$pid'";

$strSQL = "SELECT * FROM doctors,master_pincode WHERE master_pincode.pin_id=doctors.doc_pin_id";


$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>