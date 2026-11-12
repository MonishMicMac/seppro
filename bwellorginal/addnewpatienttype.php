<?php
include("connect.php"); 


$patient_type_name=$_REQUEST['patient_type_name'];










$a=$je->prepare("insert into mst_patient_type(patient_type_name)values('$patient_type_name')")or die(mysql_error());
$a->execute();



?>
