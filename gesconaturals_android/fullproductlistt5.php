<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$id=$_REQUEST['id'];

$strSQL = "SELECT id,UPPER(pro_name) as pro_name,pts,ptr,pro_mrp,dummyid FROM product where state_id='16'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>