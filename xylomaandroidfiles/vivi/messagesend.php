<?php

include("../includes/connect_db.php");





$student_id=$_REQUEST['student_id'];
$mobileno=$_REQUEST['mobileno'];
$name="Activation Code:";
$description=mysql_real_escape_string($_REQUEST['description']);
$activationstatus='1';



mysql_query("UPDATE student_profile set activationcode='$description',activationstatus='$activationstatus' WHERE student_id='$student_id'");


	



$com_mobile=urlencode($mobileno);


$message2="".$name."%0A";
$message3=$description;

$com_message=$message2.$message3;


$message=urlencode($com_message);
$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=".$com_mobile."&sender=KALIGI&message=".$com_message);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);






?>