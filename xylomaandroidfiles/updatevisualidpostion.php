<?php
include("connect.php"); 

$pro_id=$_REQUEST['pro_id'];
$repid=$_REQUEST['repid'];
$doctor_id=$_REQUEST['doctor_id'];
$postion=$_REQUEST['postion'];





$c=$je->prepare("UPDATE tbl_doctor_product_mapping SET slidepostion='$postion' WHERE doctor_id = '$doctor_id' && product_id='$pro_id' &&  rep_id='$repid'")or die(mysql_error());




$c->execute();



?>