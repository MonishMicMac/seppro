<?php
include("connect.php");
session_start();
error_reporting(0);
$del= mysql_query("delete from live_users where session_id='".$_REQUEST['session_id']."'");
  if($del)
  {
  echo "del_sucess";
 }
 ?>