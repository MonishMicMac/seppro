<?php

include("connect1.php");


$wp_rep_id=$_REQUEST['wp_rep_id'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_date=$_REQUEST['wp_date'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");




$proid = explode(",",$wp_dc_id);
for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM  tbl_work_plan WHERE wp_rep_id = '$wp_rep_id' AND wp_dc_id = '$proid[$i]' and wp_date = '$wp_date' ")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO tbl_work_plan(wp_rep_id,wp_dc_id,attendancestatus,wp_date,c_date,c_time,wp_dc)VALUES('$wp_rep_id','$proid[$i]','0','$wp_date','$c_date','$c_time','D')")or die(mysql_error());
     }
}










?>
