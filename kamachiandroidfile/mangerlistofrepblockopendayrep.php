<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT id,rep_name FROM representative WHERE id='$id'";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>