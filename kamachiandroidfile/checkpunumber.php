<?php

include("connect.php"); 


$pobbillno=$_REQUEST['pobbillno'];




$strSQL = $je->prepare("SELECT * FROM mst_pob WHERE pobbillno='$pobbillno'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>