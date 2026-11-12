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



    //   $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_rep_id='$wp_rep_id' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND drunavailable = '0'")or die(mysql_error());
    //   $jj_count = mysql_num_rows($jj);
    //  if($jj_count > 0)
    // {


    // }
    // else
    //  {
    
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening')")or die(mysql_error());
     
     
     
     
     
     
     
     $jj = mysql_query("SELECT * FROM visitsplit WHERE repid= '$rep_id' AND v1first LIKE  '%".$datr."%' AND v2first LIKE  '%".$datr."%' AND v1last LIKE  '%".$datr."%' AND v2last LIKE  '%".$datr."%'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0 )
    {
    
    $row=mysql_fetch_array($jj);
    $v1_first=$row['v1first'];
    $v1_last=$row['v1last'];
    $v2_first=$row['v2first'];
    $v2_last=$row['v2last'];
    
    
    
    
    if (($full_date >= $v1_first) && ($full_date <= $v1_last)) 
    {


mysql_query("DELETE from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$proid[$i]' and date(wp_date) between '$tomorrow' and '$v1_last' and attendancestatus='0' and drunavailable='0'");
     }
elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) 
     {
     
     

mysql_query("DELETE from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$proid[$i]' and date(wp_date) between '$tomorrow' and '$v2_last' and attendancestatus='0' and drunavailable='0'");

    }
 


 
  
   // }
   
   
     }
     }
    
     
     
     
    




?>