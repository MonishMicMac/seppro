<?php
include("connect.php"); 

$billno=$_REQUEST['billno'];



$b = $je->prepare("UPDATE mst_pob SET pobstatus='1' WHERE pobbillno= '$billno'")or die(mysql_error());

$b->execute();

?>
