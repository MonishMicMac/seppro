<?php

include("connect1.php");


$id=$_REQUEST['id'];
$bd=$_REQUEST['bd'];





$jjxx = mysql_query("UPDATE doctors SET email='$bd' WHERE id = '$id'")or die(mysql_error());




?>