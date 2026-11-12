<?php

include("connect.php"); 

$rep_assign=$_REQUEST['rep_assign'];


$strSQL = "SELECT * from unapproveddoctors where rep_assign='$rep_assign' ORDER BY doctor_name ASC";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	
	echo json_encode($antony);
?>