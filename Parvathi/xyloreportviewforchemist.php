<?php

include("connect.php"); 

 

$doctorid=$_REQUEST['doctorid'];

$strSQL = "SELECT * 
FROM tbl_work_plan
WHERE wp_dc_id=  '$doctorid' AND wp_dc='C' AND drunavailablereason!=''  ORDER BY wp_id DESC LIMIT 15";


$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	echo json_encode($antony);
?>