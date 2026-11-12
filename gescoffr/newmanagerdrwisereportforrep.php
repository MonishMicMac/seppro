<?php

include("connect.php"); 

 $managerid=$_REQUEST['managerid'];
if($managerid=='38'|| $managerid=='39'|| $managerid=='40' || $managerid=='42' || $managerid=='43' || $managerid=='44')
{

$strSQL = "SELECT * FROM representative";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
}



?>