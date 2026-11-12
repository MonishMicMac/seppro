<?php
include("connect.php"); 

$id=$_REQUEST['id'];
$dr_latitude=$_REQUEST['dr_latitude'];
$dr_longitude=$_REQUEST['dr_longitude'];




$b = $je->prepare("UPDATE doctors SET dr_latitude='$dr_latitude',dr_longitude='$dr_longitude',onetimeallowforrep='1' WHERE id = '$id'")or die(mysql_error());

$b->execute();

?>
