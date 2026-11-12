<?php
include("connectsms.php");

$std=$_REQUEST['g_std'];
$sec=$_REQUEST['g_sec'];
$staffid=$_REQUEST['g_staffid'];
$heading=$_REQUEST['g_heading'];

  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    $file_name = $_FILES['myFile']['name'];
    $file_size = $_FILES['myFile']['size'];
    $file_type = $_FILES['myFile']['type'];
    $temp_name = $_FILES['myFile']['tmp_name'];
        
    $location = "../../gallery/videos/";
      
    move_uploaded_file($temp_name, $location.$file_name);
    echo "Video uploaded successfully".$file_name;
$ac=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$ac_res=mysql_fetch_array($ac);
$say=explode("-",$ac_res['calendar_sdate']);$eay=explode("-",$ac_res['calendar_edate']);
$ayc=$say[0]."-".$eay[0];
    mysql_query("insert into gallery (g_galname,g_std,g_sec,g_staffid,g_heading,g_type,g_academic_year) values ('".$file_name."','$std','$sec',$staffid,'$heading','1','$ayc')");  
  }
  else
  {
    echo "Error";
  }

?>