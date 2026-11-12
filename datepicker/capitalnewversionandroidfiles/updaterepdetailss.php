<?php
include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];
$name=$_REQUEST['name'];
$mobile=$_REQUEST['mobile'];
$email=$_REQUEST['email'];
$address=$_REQUEST['address'];
$doj=$_REQUEST['doj'];



$b = $je->prepare("UPDATE representative SET rep_name='$name',mobile='$mobile',email='$email',address='$address',doj='$doj' WHERE id= '$rep_id'")or die(mysql_error());

$b->execute();

?>