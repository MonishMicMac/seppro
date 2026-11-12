<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT representative.rep_name,doctors.id,doctors.rep_id,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification FROM doctors,representative WHERE doctors.doc_status='1' AND doctors.rep_id=representative.id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>