<?php

include("connect.php"); 


$senderid=$_REQUEST['senderid'];
$reciverid=$_REQUEST['receiverid'];
$issue_id=$_REQUEST['issueid'];


$strSQL = $je->prepare("SELECT * FROM chat WHERE  (senderid='$senderid' && receiverid='$reciverid' && issueid ='$issue_id') || (senderid='$reciverid' && receiverid='$senderid' && issueid ='$issue_id') ORDER BY id asc" );
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>