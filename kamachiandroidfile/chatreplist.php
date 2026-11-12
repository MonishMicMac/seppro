<?php

include("connect.php"); 




$strSQL = $je->prepare("SELECT id,rep_name FROM representative");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>