<?php
include("connect.php");
session_start();
error_reporting(0);

 $find=mysql_query("select * from live_users where session_id='".$_REQUEST['session_id_find']."'");
  $fetch_row=mysql_fetch_array($find);
  
  if($fetch_row['session_status']=="1")
  {	
     $savedtime = strtotime($fetch_row['session_time']);
     $currenttime = strtotime(date('H:i:s'));
     $differenceinseconds = $currenttime-$savedtime;
     echo $finalsecondsleft= 60-$differenceinseconds;
  //echo "sucess";
  }
  else
  {
  	echo "failure";
  }
?>