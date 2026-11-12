<?php

include("connect.php"); 

$doctor_id=$_REQUEST['doctor_id'];

$strSQL = "SELECT tbl_doctor_product_mapping.product_id,product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE tbl_doctor_product_mapping.doctor_id='$doctor_id' AND product.id=tbl_doctor_product_mapping.product_id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>