<?php

include("connect.php"); 

 $id=$_REQUEST['id'];

if($id=='32' || $id=='43' || $id=='1'|| $id=='42'|| $id=='41'|| $id=='39'|| $id=='56' || $id=='33' || $id=='62' || $id=='63'|| $id=='78'|| $id=='80'|| $id=='83'|| $id=='72')
{


 $strSQL = "SELECT id,rep_state_status AS rep_name FROM representative WHERE rep_id!='0'and adminon='1' and id NOT IN (43,41,32,1,39,42,56,33,62,63,78,80,83,72)  group by rep_state_status";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
}

else
{


$strSQL = "SELECT id,rep_state_status AS rep_name FROM representative WHERE id='$id'  group by rep_state_status";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);


}



?>