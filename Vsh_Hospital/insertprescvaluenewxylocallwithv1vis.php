<?php
include("connect23.php"); 

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
// $prescriptionvalue=$_REQUEST['prescriptionvalue'];
// $no_if_op_perday=$_REQUEST['no_if_op_perday'];
$no_of_referrals_per_month=$_REQUEST['no_of_referrals_per_month'];
$vs_share=$_REQUEST['vs_share'];
$no_of_hospital_current_ref=$_REQUEST['no_of_hospital_current_ref'];
$rate=$_REQUEST['rate'];
$senior_vis_req=$_REQUEST['senior_vis_req'];
$visit_date=$_REQUEST['visit_date'];
$no_of_op=$_REQUEST['no_of_op'];
// $rm_remarks=$_REQUEST['rm_remarks'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$jjxx1 = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id'  AND wp_dc_id='$wp_dc_id'
AND wp_date='$c_date' AND indate='$c_date' AND intime !=''  ")or die(mysql_error());
// print_r()
$jjxx_count1 = mysql_num_rows($jjxx1);

if($jjxx_count1 > 0){
    $response = array(
        'status' => 'false',
        'data' => 'Intime already updated!'
        );
  echo json_encode($response);
}else{

mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',no_of_referrals_per_month='$no_of_referrals_per_month',vs_share='$vs_share',no_of_hospital_current_ref='$no_of_hospital_current_ref',no_if_op_perday='$no_of_op',rate='$rate',senior_vis_req='$senior_vis_req',visit_date='$visit_date' WHERE wp_id='$wp_id'")or die(mysql_error());

mysql_query("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());

}

if($drunavailable == 0){

$strSQLup = mysql_query("SELECT wp_dc_id,c_date,c_time,wp_rep_id FROM tbl_work_plan  WHERE wp_id='$wp_id'")or die(mysql_error());
$strSQLup_res=mysql_fetch_array($strSQLup);

mysql_query("UPDATE v1visitmissed SET attendace='1' WHERE dc_id='".$strSQLup_res['wp_dc_id']."' AND date='".$strSQLup_res['c_date']."' AND time='".$strSQLup_res['c_time']."' AND repid='".$strSQLup_res['wp_rep_id']."'")or die(mysql_error());

}
?>