<?php
	include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];
$up=$_REQUEST['up'];

$strSQL = "SELECT `wp_date` AS WP_DATE,`wp_dc` AS DC,count(*) AS CNT FROM `tbl_work_plan` WHERE wp_rep_id='$rep_id' AND UP='$up' AND wp_date>='".date("Y/m/d")."' group by `wp_date`,`wp_dc`";


$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);





?>