<?php
include('connect.php');

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$userid = $_REQUEST['id'];
$gcmid = $_REQUEST['gcmid'];

$user_otp = rand(1000, 9999);

$dis_entry=mysql_query("UPDATE clinetcreation SET gcm_id='$gcmid' WHERE id = '$userid'")or die(mysql_error());


?>