<?php

include("connect.php"); 


$id=$_REQUEST['id'];




$strSQL = "SELECT tbl_customer_master.owner_name,tbl_customer_master.shop_name,tbl_customer_master.mobile_no,tbl_customer_master.customer_address,doctors.dr_latitude,doctors.dr_longitude FROM tbl_customer_master,doctors WHERE tbl_customer_master.id='$id' AND doctors.id=tbl_customer_master.doctor_id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	echo json_encode($antony);
?>