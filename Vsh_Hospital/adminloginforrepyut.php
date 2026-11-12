<?php

include("connect.php"); 



$rep_id=$_REQUEST['rep_id'];

$strSQL = $je->prepare("SELECT * FROM representative WHERE rep_imeino='$rep_id'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>