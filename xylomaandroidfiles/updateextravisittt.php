<?php
include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];
$count=$_REQUEST['count'];



$b = $je->prepare("UPDATE representative SET extravisitallowed='$count' WHERE rep_name= '$rep_id'")or die(mysql_error());

$b->execute();

?>