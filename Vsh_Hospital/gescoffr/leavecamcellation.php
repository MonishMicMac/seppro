<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];
$leavee=$_REQUEST['leavee'];



$strSQL=$je->prepare("DELETE  FROM repgivenasleave WHERE id='$wp_id'")or die(mysql_error());

$strSQL->execute();




?>
