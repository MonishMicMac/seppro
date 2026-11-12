<?php
include("connect.php"); 

$repid=$_REQUEST['repid'];



$b = $je->prepare("UPDATE representative SET managertourplanopen='1' WHERE id= '$repid'")or die(mysql_error());

$b->execute();

?>