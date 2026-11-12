<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];




$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,distributor.dis_abb,distributor.reg_addr,distributor.corp_pin,distributor.dis_name,distributor.cp_name FROM tbl_work_plan,distributor WHERE tbl_work_plan.wp_dc='S' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND distributor.id=tbl_work_plan.wp_dc_id");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>