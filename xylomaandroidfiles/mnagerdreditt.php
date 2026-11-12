<?php

include("connect.php"); 



$drid=$_REQUEST['drid'];

$strSQL = $je->prepare("SELECT * FROM doctors WHERE id='$drid'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>