<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,representative.rep_name,representative.extravisitallowed FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>