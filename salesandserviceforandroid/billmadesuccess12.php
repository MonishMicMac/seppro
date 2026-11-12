<?php
include('connect.php');


$billno=$_REQUEST['productid'];
$wpid=$_REQUEST['wpid'];










mysql_query("UPDATE reorting SET productpromoted='$billno' WHERE id='$wpid'")or die(mysql_error());

$reply='success';



echo $reply;


?>