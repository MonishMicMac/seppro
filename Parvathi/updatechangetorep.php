<?php
include("connect.php"); 

$id=$_REQUEST['id'];
$repid=$_REQUEST['repid'];



$b = $je->prepare("UPDATE representative SET rep_id='$repid' WHERE id= '$id'")or die(mysql_error());

$b->execute();

?>
