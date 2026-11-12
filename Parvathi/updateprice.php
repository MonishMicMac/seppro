<?php
include("connect.php"); 

$repid=$_REQUEST['repid'];



$b = $je->prepare("UPDATE representative SET pricelistchanged='0' WHERE id= '$repid'")or die(mysql_error());

$b->execute();

?>
