<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$feedback=$_REQUEST['feedback'];

$managerlat=$_REQUEST['managerlat'];

$managerlong=$_REQUEST['managerlong'];




date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$proid = explode(",",$pid);
for($i=0;$i< count($proid);$i++)
{
$b = $je->prepare("UPDATE tbl_work_plan SET jointworkapproval='1',feedback='$feedback',managerlat='$managerlat',managerlong='$managerlong',managerdate='$c_date' WHERE wp_id = '$proid[$i]'")or die(mysql_error());
$b->execute();
}

?>
