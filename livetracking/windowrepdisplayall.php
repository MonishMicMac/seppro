<?php

include("connect.php"); 





$strSQL = $je->prepare("SELECT * FROM representative WHERE rep_lat!='0'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>