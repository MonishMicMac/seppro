<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT DISTINCT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND (representative.id=assigningreptomanager.repid || representative.id='$id')";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>