<?php

include("connect.php"); 


$chid=$_REQUEST['chid'];

$strSQL = "SELECT * FROM tbl_doctor_chemist,doctors,master_pincode WHERE tbl_doctor_chemist.chemist_id='$chid' AND master_pincode.pin_id=doctors.doc_pin_id AND doctors.id=tbl_doctor_chemist.doctor_id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>