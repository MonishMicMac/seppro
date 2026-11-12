<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');


if($id=='38'|| $id=='39'|| $id=='40' || $id=='42'|| $id=='43'|| $id=='44')

{

$strSQL = "SELECT * FROM representative WHERE (repid='8' || repid='9' || repid='10' || repid='11') AND leaveapplieddate='$c_date' AND expenses='leave' AND messageviewd='0'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
}


?>