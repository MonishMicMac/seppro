<?php

include("connect.php"); 

$db=$_REQUEST['db'];
$login=$_REQUEST['login'];
$password=$_REQUEST['password'];

$strSQL = $je->prepare("SELECT * FROM representative WHERE rep_imeino='$rep_id'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>