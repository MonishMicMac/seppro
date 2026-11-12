<?php

include("connect.php"); 



$strSQL = $je->prepare("SELECT * FROM specialitygroup");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>