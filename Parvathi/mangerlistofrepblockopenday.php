<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
// AND representative.rep_order!='0' ORDER BY representative.rep_order ASC

$strSQL = "SELECT representative.id,representative.rep_name,representative.rep_order FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid  ";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>