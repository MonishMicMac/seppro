<?php

include("connect.php"); 





 $id=$_REQUEST['id'];

if($id=='7' || $id=='20'  || $id=='49' || $id=='8' || $id=='42' || $id=='52')
{


 $strSQL = "SELECT id,rep_name FROM representative WHERE rep_id!='0' and id NOT IN (7,20,8,42,26,49) ORDER BY rep_name ASC";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
}

else
{


$strSQL = "SELECT id,rep_name FROM representative WHERE id='$id' ORDER BY rep_name ASC";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);


}









?>