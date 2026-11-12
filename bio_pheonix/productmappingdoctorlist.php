<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$strSQL = "SELECT * FROM doctors WHERE doctors.rep_id='$pid'";
// doctor_name,doc_specilist_id,doc_qualification,doctor_addrs,doc_hospital_clinic_name,doc_areaname
$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();

$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
echo json_encode($antony);
?>