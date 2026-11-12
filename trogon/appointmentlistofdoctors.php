<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$strSQL = "SELECT DISTINCT doctors.id,doctors.doc_pin_id,master_pincode.pincode,doctors.doctor_name FROM doctors,master_pincode WHERE master_pincode.pin_id=doctors.doc_pin_id AND doctors.rep_id='$pid'";

$objQuery = $je->prepare($strSQL);
$objQuery ->execute();
	$joel= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	echo json_encode($joel);
?>