<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];








$proid = explode(",",$pid);

for($i=0;$i< count($proid);$i++)
{
$b = $je->prepare("UPDATE repgivenasleave SET messageviewd='1' WHERE id = '$proid[$i]'")or die(mysql_error());
$b->execute();
}

?>
