<?php

include("connect.php"); 

$managerid=$_REQUEST['managerid'];

$strSQL = $je->prepare("SELECT id,rep_name FROM representative WHERE representative.id IN (SELECT repid FROM assigningreptomanager WHERE managerid='".$_REQUEST['managerid']."') AND rep_id='0'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>