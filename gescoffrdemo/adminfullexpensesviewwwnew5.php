<?php

include("connect.php"); 

 $id=$_REQUEST['id'];

$strSQL = "SELECT representative.id,representative.rep_name,IFNULL((SELECT messageviewd FROM repgivenasleave WHERE repid=representative.id AND messageviewd='1'),'0') as status
 FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = $je->prepare($strSQL);

	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($antony);



?>