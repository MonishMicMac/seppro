<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,representative.rep_name,representative.opendrdelte,representative.rep_id,representative.managertourplanopen,representative.deleteopen FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid ORDER BY representative.rep_name asc";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>