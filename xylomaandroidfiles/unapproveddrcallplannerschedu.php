<?php
	include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];




$strSQL = "SELECT `wp_date` AS WP_DATE,`wp_dc` AS DC,count(*) AS CNT FROM `unapprovedtbl_work_plan` WHERE wp_rep_id='$rep_id' AND wp_dc='D' AND wp_date>='".date('Y-m-').'01'."' group by `wp_date`,`wp_dc`";


$objQuery = $je->prepare($strSQL);
$objQuery ->execute();

	
	$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);





?>