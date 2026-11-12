<?php
include("connect1.php");


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


   $rep_id=$wp_rep_id;
     
$full_date=date("Y-m-d",strtotime($wp_date));

$tomorrow = date('Y-m-d',strtotime($full_date . "+1 days"));
$previousday= date('Y-m-d',strtotime($full_date . "-1 days"));

$dt = explode("-",$full_date);
 
$datr=$dt[0]."-".$dt[1]."-";




for($i=0;$i< count($proid);$i++)
{



   $jjxx = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date='$wp_date' AND wp_dc_id='$proid[$i]' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
    
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening')")or die(mysql_error());
     
     
     
     }
     
     
     
   
   
   
     
     }
    
     
     
     
    




?>