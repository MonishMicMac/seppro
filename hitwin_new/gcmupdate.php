<?php
include("connect2.php"); 

$id=$_REQUEST['repid'];
$gcmid=$_REQUEST['gcmid'];


$b = $je->prepare("UPDATE representative SET gcm_repid='$gcmid' WHERE id='$id'")or die(mysql_error());

$b->execute();

?>
