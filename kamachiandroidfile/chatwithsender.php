<?php

include("connect.php"); 


$senderid=$_REQUEST['senderid'];
$reciverid=$_REQUEST['receiverid'];

$strSQL = $je->prepare("SELECT * FROM chat WHERE (senderid='$senderid' && receiverid='$reciverid') || (senderid='$reciverid' && receiverid='$senderid') ORDER BY id asc" );
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>