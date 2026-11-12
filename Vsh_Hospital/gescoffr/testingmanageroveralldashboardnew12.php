<?php
include("connect1.php");


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
$promotion_service=$_REQUEST['promotion_service'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];



$proid = explode(",",$wp_dc_id);
$join = explode(",",$jointworkby);
$drun = explode(",",$drunavailable);

$lata= explode(",",$latitude);
$longa = explode(",",$longitude);
$calser = explode(",",$promotion_service);
$calstage = explode(",",$prescriptionvalue);


for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' and wp_rep_id='$wp_rep_id' AND wp_dc_id = '$proid[$i]'  AND attendancestatus='1'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {
       

    }
    else
     {


     	$jj1 = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' and wp_rep_id='$wp_rep_id' AND wp_dc_id = '$proid[$i]'  AND attendancestatus='0'")or die(mysql_error());
      $jj_count1 = mysql_num_rows($jj1);

 if($jj_count1 > 0)
    {
    	
       
       mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$lata[$i]' ,longitude='$longa[$i]' ,reporteddate='$wp_date' ,reportedtime='$c_time',drunavailablereason='$drun[$i]',jointworkby='$join[$i]',prescriptionvalue='$calstage[$i]',promotion_service='$calser[$i]' WHERE wp_dc_id='$proid[$i]' AND wp_rep_id='$wp_rep_id' and wp_date='$wp_date'")or die(mysql_error());
    }
    else
     {

     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$wp_date','$c_time','$morningevening','$attendancestatus','$lata[$i]','$longa[$i]','$wp_date','$c_time','0','$drun[$i]','$join[$i]','$calser[$i]','$calstage[$i]')")or die(mysql_error());

   }

     }
}


$jjs = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND  wp_rep_id = '$wp_rep_id' AND attendancestatus='1'")or die(mysql_error());

$doc = array();
while ($sal_row=mysql_fetch_array($jjs))
{

$doc[] = $sal_row['wp_dc_id'];

} 

echo implode(",", $doc);




?>
