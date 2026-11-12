<?php
include("connect2.php"); 

$wp_date=$_REQUEST['wp_date'];
$wp_pin_id=$_REQUEST['wp_pin_id'];
$wp_dc=$_REQUEST['wp_dc'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

$UP=$_REQUEST['UP'];
$morningevening=$_REQUEST['morningevening'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s A');

$proid = explode(",",$wp_dc_id);
for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND drunavailable = '0'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening')")or die(mysql_error());
     }
}










?>
