<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');



$strSQL = "SELECT count(doctors.doc_status),doctors.rep_id,doctors.doc_status,representative.rep_name FROM doctors,representative WHERE doctors.doc_status='1' AND doctors.rep_id=representative.id GROUP BY doctors.rep_id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($antony);
?>