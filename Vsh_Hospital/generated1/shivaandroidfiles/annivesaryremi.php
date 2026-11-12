<?php
include("connect23.php"); 


$id=$_REQUEST['id'];
$bd=$_REQUEST['bd'];





$jjxx = mysql_query("UPDATE doctors SET anniversary='$bd' WHERE id = '$id'")or die(mysql_error());




?>