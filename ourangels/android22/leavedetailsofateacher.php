<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$staffid=$_REQUEST['staffid'];







$result = mysql_query("select count(*) from leaverequestedforstaff where staffid='$staffid'");

$result1 = mysql_query("select count(*) from leaverequestedforstaff where staffid='$staffid' AND sent='1'");

$result2 = mysql_query("select count(*) from leaverequestedforstaff where staffid='$staffid' AND sent=' '");

$result3 = mysql_query("select count(*) from leaverequestedforstaff where staffid='$staffid' AND sent='2'");

// Verify it worked
if (!$result) echo mysql_error();

$row = mysql_fetch_row($result);


if (!$result1) echo mysql_error();

$row1 = mysql_fetch_row($result1);

if (!$result2) echo mysql_error();

$row2 = mysql_fetch_row($result2);

if (!$result3) echo mysql_error();

$row3 = mysql_fetch_row($result3);


// Should show you an integer result.



echo '[{"leavereq":'.$row[0].',"leaveapp":'.$row1[0].',"leavepen":'.$row2[0].',"leavecan":'.$row3[0].'}]';



?>