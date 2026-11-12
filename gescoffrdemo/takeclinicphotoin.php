<?php
include("connect1.php");
$id=$_REQUEST['id'];
$filename=$_REQUEST['filename'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


mysql_query("UPDATE doctors SET visitcardclinicphoto='$filename' WHERE id = '$id'")or die(mysql_error());







?>