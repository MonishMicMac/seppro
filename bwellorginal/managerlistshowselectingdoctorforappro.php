<?php

include("connect.php"); 

 $id=$_REQUEST['id'];

$strSQL = "SELECT temp_doctor_store.id,temp_doctor_store.drname,temp_doctor_store.docpincode,temp_doctor_store.hospitalname,temp_doctor_store.repname,temp_doctor_store.specialist,temp_doctor_store.qualification,temp_doctor_store.docaddress FROM temp_doctor_store,representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid AND temp_doctor_store.repid=representative.id";
$objQuery = $je->prepare($strSQL);



	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>