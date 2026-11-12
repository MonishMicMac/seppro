<?php

include("connect.php"); 


$senderid=$_REQUEST['senderid'];
$reciverid=$_REQUEST['reciverid'];
$lastid=$_REQUEST['lastid'];


$strSQL = $je->prepare("SELECT * FROM chat WHERE id>$lastid AND (senderid='$reciverid' AND receiverid='$senderid') ORDER BY id asc" );
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>