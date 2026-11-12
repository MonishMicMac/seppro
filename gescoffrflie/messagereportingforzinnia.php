<?php
include("connect1.php");

$mobileno=$_REQUEST['mobileno'];
$message=$_REQUEST['message'];


$sql=mysql_query("SELECT id FROM representative WHERE mobile='$mobileno'");
$row=mysql_fetch_array($sql);
$rep_id=$row['id'];

if($rep_id != ''){
$explode=explode('$',$message);

$doc_id=$explode[0];
$feed_back=$explode[1];
$jointwork_by=$explode[2];
$latitude=$explode[3];
$longtitude=$explode[4];



date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date('h:i:s A');

$wp_dc_id=$doc_id;
$wp_rep_id=$rep_id;


  $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$c_date' AND wp_dc = 'D' AND wp_dc_id = '$wp_dc_id' AND drunavailable = '0'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,reportstatus,latitude,longitude,reporteddate,reportedtime,drunavailablereason,jointworkby)VALUES('$c_date','0','D','$wp_dc_id','$wp_rep_id','U','$c_date','$c_time','1','1','0','$latitude','$longtitude','$c_date','$c_time','$feed_back','$jointwork_by')")or die(mysql_error());
     }


}








?>
