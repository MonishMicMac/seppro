<?php
	include("connect.php"); 

$productid=$_REQUEST['productid'];
$valuee=$_REQUEST['valuee'];





$strSQL = "SELECT * FROM  tbl_product_adde_slide WHERE productid='$productid' AND id>'$valuee' AND type='mp4'";



$objQuery = $je->prepare($strSQL);
$objQuery ->execute();

	
	$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);





?>