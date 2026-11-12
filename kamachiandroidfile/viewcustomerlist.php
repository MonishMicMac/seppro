<?php

include("connect.php"); 



$rep_assign=$_REQUEST['rep_assign'];

$strSQL = $je->prepare("SELECT id,doctor_name,rep_assign FROM doctors WHERE rep_assign='$rep_assign'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>