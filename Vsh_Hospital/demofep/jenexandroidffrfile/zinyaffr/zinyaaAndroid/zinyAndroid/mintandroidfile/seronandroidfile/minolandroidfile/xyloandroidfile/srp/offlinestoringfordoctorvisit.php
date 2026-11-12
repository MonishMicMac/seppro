<?php
include("connect2.php"); 

date_default_timezone_set("Asia/Kolkata");

$wp_date=date('Y-m-d');
$c_time=date("h:i:s A");


$wp_pin_id='0';
$wp_dc='D';
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

$UP="U";
$morningevening='1';
$attendancestatus='1';
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailable=$_REQUEST['drunavailable'];



$proid = explode(",",$wp_dc_id);
$join = explode(",",$jointworkby);
$drun = explode(",",$drunavailable);

$lata= explode(",",$latitude);
$longa = explode(",",$longitude);


for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND drunavailable = '0' AND attendancestatus='1'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$wp_date','$c_time','$morningevening','$attendancestatus','$lata[$i]','$longa[$i]','$wp_date','$c_time','0','$drun[$i]','$join[$i]')")or die(mysql_error());

    mysql_query("DELETE  FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND drunavailable = '0' AND attendancestatus='0'")or die(mysql_error());

     }
}










?>
