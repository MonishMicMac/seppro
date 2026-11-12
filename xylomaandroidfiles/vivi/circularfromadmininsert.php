<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$response = array();

    $staffid=$_POST['staffid'];
    $staffname=$_POST['staffname'];
    $message=$_POST['message'];
    $date=$_POST['date'];
    $time=$_POST['time'];

    $result = mysql_query("INSERT INTO circularmessagefromadmin(staffid,staffname,message,date,time) VALUES('$staffid','$staffname','$message','$date','$time')");   

    if($result>0){
           $response["success"] = 1;
         }   
     else{
           $response["success"] = 0;
         }
     // echoing JSON response
     echo json_encode($response);













?>