<?php

include("connect.php"); 

$state_id=$_REQUEST['state_id'];
$repid=$_REQUEST['repid'];

$strSQL = $je->prepare("SELECT pin_id,pincode FROM master_pincode WHERE state_id='".$_REQUEST['state_id']."' and pin_id NOT IN (SELECT tertiary_pin FROM tbl_tertiary WHERE tertiary_id IN (SELECT tertiary_id FROM mst_tertiary WHERE teritary_rep_id='$repid'))");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>