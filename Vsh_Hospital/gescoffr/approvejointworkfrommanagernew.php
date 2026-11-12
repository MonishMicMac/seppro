<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$feedbackk=$_REQUEST['feedbackk'];



$proid = explode(",",$pid);
for($i=0;$i< count($proid);$i++)
{
$b = $je->prepare("UPDATE tbl_work_plan SET managerfeedback='$feedbackk' WHERE wp_id = '$proid[$i]'")or die(mysql_error());
$b->execute();
}

?>
