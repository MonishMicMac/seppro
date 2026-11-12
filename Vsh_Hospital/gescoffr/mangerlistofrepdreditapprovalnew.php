<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];


$strSQL = "SELECT doctors.id,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.prescriber,doctors.patientpervisit,doctors.managerapprovestatus,doctors.managerlat,doctors.managerlong,doctors.dr_latitude,doctors.dr_longitude,doctors.c_date,doctors.c_time,doctors.inrepid,representative.rep_name FROM doctors,representative,assigningreptomanager WHERE  assigningreptomanager.managerid='$pid' AND representative.id=doctors.inrepid AND representative.id=assigningreptomanager.repid ";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	
	echo json_encode($antony);
?>