<?php

include("connect.php"); 


$dcid=$_REQUEST['dcid'];



$strSQL = "SELECT * FROM tbl_doctor_product_mapping WHERE doctor_id='$dcid'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>