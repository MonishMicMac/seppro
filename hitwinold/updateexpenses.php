<?php
include('connect.php');


$id=$_REQUEST['id'];

$fn=$_REQUEST['fn'];
$fa=$_REQUEST['fa'];
$re=$_REQUEST['re'];


mysql_query("UPDATE expenses SET farename='$fn',fareamount='$fa',remarks='$re' WHERE id='$id'")or die(mysql_error());


?>