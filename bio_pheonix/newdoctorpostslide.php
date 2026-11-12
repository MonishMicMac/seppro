<?php

include("connect.php"); 

$doctor_id=$_REQUEST['doctor_id'];

$strSQL = "SELECT tbl_product_adde_slide.imagevideoname,tbl_product_adde_slide.productid,tbl_doctor_product_mapping.slidepostion  FROM tbl_doctor_product_mapping,tbl_product_adde_slide WHERE tbl_doctor_product_mapping.doctor_id='$doctor_id' AND tbl_product_adde_slide.productid=tbl_doctor_product_mapping.product_id GROUP BY tbl_product_adde_slide.imagevideoname ORDER BY tbl_doctor_product_mapping.slidepostion ASC";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>