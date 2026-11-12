<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];



$proid = explode(",",$pid);
for($i=0;$i< count($proid);$i++)
{
$b = $je->prepare("UPDATE tbl_work_plan SET jointworkapproval='1',manager_latitude='".$_REQUEST["latitude"]."',manager_longitude='".$_REQUEST["longitude"]."' WHERE wp_id = '$proid[$i]'")or die(mysql_error());
$b->execute();
}

?>
