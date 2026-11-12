<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$strSQL = "SELECT DISTINCT unapproveddoctors.id,unapproveddoctors.doc_pin_id,master_pincode.pincode,unapproveddoctors.doctor_name FROM unapproveddoctors,master_pincode WHERE master_pincode.pin_id=unapproveddoctors.doc_pin_id AND unapproveddoctors.rep_id='$pid'";

$objQuery = $je->prepare($strSQL);
$objQuery ->execute();
	$joel= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	echo json_encode($joel);
?>