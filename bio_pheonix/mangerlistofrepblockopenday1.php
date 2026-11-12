<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,representative.rep_name,representative.opendrdelte,representative.rep_id,representative.managertourplanopen,representative.deleteopen FROM representative,assigningreptomanager WHERE  representative.id=assigningreptomanager.repid GROUP BY representative.rep_name ORDER BY representative.rep_order asc";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>