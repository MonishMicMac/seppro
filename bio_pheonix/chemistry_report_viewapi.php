<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];

$strSQL = $je->prepare("SELECT * FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc='C' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id GROUP BY tbl_work_plan.wp_id");

$strSQL->execute();

$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>