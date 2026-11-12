<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


if($id=='38'|| $id=='39'|| $id=='40' || $id=='42'|| $id=='43'|| $id=='44')
{

$strSQL = "SELECT * FROM representative";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
}


?>