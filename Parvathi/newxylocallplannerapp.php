<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];

$redate=$_REQUEST['redate'];
$wpdrid=$_REQUEST['wpdrid'];
$repid=$_REQUEST['repid'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



$strSQL = $je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby' WHERE wp_id='$wp_id'")or die(mysql_error());

$strSQL->execute();

$strSQL1 = $je->prepare("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());

$strSQL1->execute();


if($drunavailable == 0){
$strSQL2 = $je->prepare("UPDATE dropenforschedule SET status='1' WHERE drid='$dr_id'")or die(mysql_error());
$strSQL2->execute();
}


if($redate=='0')
{

}
else
{



      $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$redate' AND wp_rep_id='$repid' AND wp_dc = 'D' AND wp_dc_id = '$wpdrid' AND drunavailable = '0'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
    
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$redate','0','D','$wpdrid','$repid','P','$c_date','$c_time','1')")or die(mysql_error());
     
     
     }

}


?>