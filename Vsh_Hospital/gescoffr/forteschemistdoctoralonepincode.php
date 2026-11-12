<?php

include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];


$strSQL = "SELECT * FROM doctors WHERE doc_pin_id in (SELECT pin_id FROM rep_area WHERE rep_id='$rep_id' group by pin_id)";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>