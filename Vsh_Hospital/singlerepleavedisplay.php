<?php
	




include("connect.php"); 
$rep_id=$_REQUEST['rep_id'];
$strSQL = $je->prepare("SELECT * FROM repgivenasleave WHERE repid='$rep_id' AND expenses='leave'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>