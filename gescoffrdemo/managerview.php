<?php

include("connect.php"); 





 $id=$_REQUEST['id'];

if($id=='1')
{


 $strSQL = "SELECT id,rep_name FROM representative WHERE rep_id!='0'and adminon='1' and id NOT IN ('') ORDER BY rep_name ASC";

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