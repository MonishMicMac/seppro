<?php
include("connect.php");
session_start();
error_reporting(0);
$update= mysql_query("update live_users set session_time='".date('H:i:s')."',session_status='1' where session_id='".$_REQUEST['session_timing']."'");
  if($update)
  {
  echo "timing_start";
 }
 ?>