<?php

include("connect1.php");

$id=$_REQUEST['id'];
$email=$_REQUEST['email'];





$jjxx = mysql_query("UPDATE doctors SET email='$email' WHERE id = '$id'")or die(mysql_error());




?>