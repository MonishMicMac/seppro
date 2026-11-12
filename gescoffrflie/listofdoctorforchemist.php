<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$id=$_REQUEST['id'];
$wp_id=$_REQUEST['wp_id'];

$strSQL = "SELECT tbl_doctor_chemist.chemist_id,doctors.id,doctors.doctor_name FROM tbl_doctor_chemist,doctors WHERE tbl_doctor_chemist.chemist_id='$id' AND tbl_doctor_chemist.doctor_id=doctors.id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>