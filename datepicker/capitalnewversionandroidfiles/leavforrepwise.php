<?php

include("connect.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year."-".$month."-";
$repid=$_REQUEST['repid'];


$strSQL = "SELECT wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$_REQUEST['repid']."' AND attendancestatus='1' AND wp_date LIKE '$date%' GROUP BY wp_date";



$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);
?>