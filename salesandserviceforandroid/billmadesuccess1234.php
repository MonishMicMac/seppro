<?php
include('connect.php');


$billno=$_REQUEST['productid'];
$wpid=$_REQUEST['wpid'];
$billno1=$_REQUEST['productqty'];










mysql_query("UPDATE reorting SET productpromoted='$billno',productpromotedqty='$billno1' WHERE id='$wpid'")or die(mysql_error());

$reply='success';



echo $reply;


?>