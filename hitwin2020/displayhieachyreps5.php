<?php

include("connect2.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,CONCAT(representative.rep_name,' - (',(SELECT count(*) FROM `attendancetable` WHERE time > '09:30' AND attendancetable.repid=representative.id AND date LIKE '%".date('Y-m')."%') ,')') AS rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>