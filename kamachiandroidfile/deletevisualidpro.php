<?php
include("connect.php"); 

$pro_id=$_REQUEST['pro_id'];
$repid=$_REQUEST['repid'];
$doctor_id=$_REQUEST['doctor_id'];







$c=$je->prepare("DELETE FROM tbl_doctor_product_mapping WHERE doctor_id = '$doctor_id' && product_id='$pro_id' && rep_id='$repid'")or die(mysql_error());

$c->execute();



?>
