<?php
include("connect.php"); 

$id=$_REQUEST['id'];



$b = $je->prepare("UPDATE representative SET status='1' WHERE id = '$id'")or die(mysql_error());
$b ->execute();
?>
