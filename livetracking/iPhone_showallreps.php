<?php

include("connect.php"); 




$strSQL = $je->prepare("SELECT * FROM representative");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo '{"title":{"episodes":' .json_encode($array).', "year": 2016} }';	
?>
