<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];

$strSQL = "SELECT tbl_doctor_chemist.doctor_id,tbl_doctor_chemist.chemist_id,doctors.doctor_name,doctors.doc_pincode,tbl_customer_master.shop_name,tbl_customer_master.customer_address FROM tbl_doctor_chemist,doctors,tbl_customer_master WHERE tbl_doctor_chemist.rep_id='$pid' AND doctors.id=tbl_doctor_chemist.doctor_id AND tbl_customer_master.id=tbl_doctor_chemist.chemist_id";

$objQuery = $je->prepare($strSQL);
$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
// print_r($array);exit();
	
echo json_encode($array);
?>