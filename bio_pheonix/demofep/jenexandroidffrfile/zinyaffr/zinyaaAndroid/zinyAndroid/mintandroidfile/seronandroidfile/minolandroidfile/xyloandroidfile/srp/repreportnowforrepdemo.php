<?php

include("connect.php"); 

 

$doctorid=$_REQUEST['doctorid'];

$strSQL = "SELECT * 
FROM reportnowforrep,product
WHERE reportnowforrep.doctorid =  '$doctorid' AND reportnowforrep.productid=product.id group by reportnowforrep.date,reportnowforrep.productid ORDER BY reportnowforrep.id DESC LIMIT 15";


$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	echo json_encode($antony);
?>