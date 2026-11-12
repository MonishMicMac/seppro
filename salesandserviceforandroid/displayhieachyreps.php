<?php

include("connect2.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
		echo '{"title":{"calendar":'.json_encode($antony).', "year": 2016} }';




?>