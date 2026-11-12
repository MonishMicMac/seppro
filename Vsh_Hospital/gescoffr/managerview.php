<?php

include("connect.php"); 

 $id=$_REQUEST['id'];

if($id=='1' || $id=='2')
{


 $strSQL = "SELECT id,rep_state_status AS rep_name FROM representative WHERE rep_id!='0'and adminon='1' and id NOT IN (2)  group by rep_state_status";

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








