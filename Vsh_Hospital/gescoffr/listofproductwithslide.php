<?php

include("connect.php"); 


$strSQL = "SELECT * FROM product WHERE id='1' || id='2' || id='3' || id='4' || id='5' || id='21' || id='35' || id='36' || id='46' || id='60' || id='63'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>