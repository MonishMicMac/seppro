<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$phone=$_REQUEST['mobileno'];

$name=$_REQUEST['name'];

$pm=explode("^",$phone);
$name1=explode("^",$name);

for($i=0;$i<count($pm);$i++)
{



$mobileno=$pm[$i];
$name="Hi ".$name1[$i].":";
$description="Many more happy returns of the day by KRM School.";


$com_mobile=urlencode($mobileno);


$message2="".$name."%0A";

$com_message=$message2.$description;


$message=urlencode($com_message);
$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=".$com_mobile."&sender=KALIGI&message=".$com_message);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);






}








?>