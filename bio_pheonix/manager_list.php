<?php

include("connect.php"); 





 $id=$_REQUEST['id'];

if($id=='7' || $id=='20'  || $id=='49' )
{


 $strSQL = "SELECT id,rep_name FROM representative WHERE rep_id!='0'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
}

else
{


$strSQL = "SELECT id,rep_name FROM representative WHERE id='$id'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);


}









?>