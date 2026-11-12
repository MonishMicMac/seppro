<?php

include("connect.php"); 

$repid=$_REQUEST['repid'];

$strSQL = $je->prepare("SELECT pin_id,(select pincode from master_pincode where pin_id=rep_area.pin_id) as pincode FROM rep_area WHERE rep_id='$repid' group by pin_id");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>