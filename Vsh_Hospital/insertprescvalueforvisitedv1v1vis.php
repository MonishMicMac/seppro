<?php
include("connect23.php");

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];
$pobvalue=$_REQUEST['pobvalue'];
$c_type=$_REQUEST['c_type'];
$individual_joint=$_REQUEST['individual_joint'];
$joint_work_name=$_REQUEST['joint_work_name'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
// $c_time=date("H:i:s");
$c_time=date("h:i:s A");


$jjxx1 = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id'  AND wp_dc_id='$wp_dc_id'
AND wp_date='$c_date' AND indate='$c_date' AND intime !=''  ")or die(mysql_error());

$jjxx_count1 = mysql_num_rows($jjxx1);

if($jjxx_count1 > 0){
    $response = array(
        'status' => 'false',
        'data' => 'Intime already updated!'
        );
  echo json_encode($response);
}else{

mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',pobvalue='$pobvalue',c_type='$c_type',individual_joint=$individual_joint,joint_work_name='$joint_work_name'
 WHERE wp_id='$wp_id'")or die(mysql_error());

$strSQLup1 = mysql_query("SELECT * FROM tbl_work_plan  WHERE wp_id='$wp_id'")or die(mysql_error());
// $num_rows=mysql_num_rows($strSQLup1);

$strSQLup_res1=mysql_fetch_array($strSQLup1);

$rest=$strSQLup_res1['wp_dc_id'];

$strSQLup11 = mysql_query("SELECT * FROM doctors  WHERE id='$rest'")or die(mysql_error());
// $num_rows=mysql_num_rows($strSQLup1);

$strSQLup_res11=mysql_fetch_array($strSQLup11);

// print_r($strSQLup_res11);exit();

if($strSQLup_res11['dr_latitude'] == '' && $strSQLup_res11['dr_longitude'] == '') {

mysql_query("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$rest'")or die(mysql_error());
  
}

}

if($drunavailable == 0){

$strSQLup = mysql_query("SELECT wp_dc_id,c_date,c_time,wp_rep_id FROM tbl_work_plan  WHERE wp_id='$wp_id'")or die(mysql_error());
$strSQLup_res=mysql_fetch_array($strSQLup);

mysql_query("UPDATE v1visitmissed SET attendace='1' WHERE dc_id='".$strSQLup_res['wp_dc_id']."' AND date='".$strSQLup_res['c_date']."' AND time='".$strSQLup_res['c_time']."' AND repid='".$strSQLup_res['wp_rep_id']."'")or die(mysql_error());

}

?>