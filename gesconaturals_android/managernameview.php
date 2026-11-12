<?php

include("connect.php"); 





 $id=$_REQUEST['id'];

if($id=='143' || $id=='47'  || $id=='46' || $id=='29'|| $id=='30')
{


 $strSQL = "SELECT id,rep_name FROM representative WHERE rep_id!='0' and id NOT IN (143,47,46,29,30) ORDER BY rep_name DESC";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
}
elseif($id=='209')
{
$strSQL = "SELECT id,rep_name FROM representative WHERE rep_id!='0' and id  IN (15,156,163,164,173) ORDER BY rep_name DESC";

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