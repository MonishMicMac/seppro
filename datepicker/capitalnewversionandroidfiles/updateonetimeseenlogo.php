<?php
include("connect.php"); 

$id=$_REQUEST['id'];



$b = $je->prepare("UPDATE representative SET welcomeclose='0' WHERE id= '$id'")or die(mysql_error());

$b->execute();

?>
