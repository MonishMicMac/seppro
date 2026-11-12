<?php

include("connect.php"); 


$dcid=$_REQUEST['dcid'];



$strSQL = "SELECT * FROM tbl_product_adde_slide";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>