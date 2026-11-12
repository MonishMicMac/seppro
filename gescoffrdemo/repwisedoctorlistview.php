<?php

include("connect.php"); 



$rep_id=$_REQUEST['rep_id'];

$strSQL = $je->prepare("SELECT * FROM doctors WHERE rep_id='$rep_id'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>