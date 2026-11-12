<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$phonenumber=$_REQUEST['phonenumber'];
$email=$_REQUEST['email'];
$status=$_REQUEST['status'];
$studentname=$_REQUEST['studentname'];
$fathername=$_REQUEST['fathername'];
$address=$_REQUEST['address'];


$a=mysql_query("insert into callcheck(phonenumber,email,status,studentname,fathername,address)values('$phonenumber','$email','$status','$studentname','$fathername','$address')")or die(mysql_error());

?>