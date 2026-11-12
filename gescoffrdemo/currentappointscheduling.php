<?php
include("connect1.php");


$wp_date=$_REQUEST['wp_date'];
$wp_pin_id=$_REQUEST['wp_pin_id'];
$wp_dc=$_REQUEST['wp_dc'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];
$purpose=$_REQUEST['purpose'];

$UP=$_REQUEST['UP'];
$morningevening=$_REQUEST['morningevening'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s');

$proid = explode(",",$wp_dc_id);
$proid1 = explode(",",$purpose);

   $rep_id=$wp_rep_id;




for($i=0;$i< count($proid);$i++)
{

     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,purposeofvisit)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening','$proid1[$i]')")or die(mysql_error());
 		
   
}
     
  




?>