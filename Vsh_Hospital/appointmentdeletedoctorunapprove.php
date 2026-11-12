<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];





$strSQL=$je->prepare("DELETE  FROM unapprovedtbl_work_plan WHERE wp_id='$wp_id'")or die(mysql_error());



$strSQL->execute();




?>
