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
$b = $je->prepare("UPDATE tbl_work_plan SET managerstatus='1',managerdate='$c_date',managertime='$c_time',feedback='$feedback',managerlat='$managerlat',managerlong='$managerlong',leaveapprovedbymanager='1' WHERE wp_id = '$proid[$i]'")or die(mysql_error());
$b->execute();
}

?>
