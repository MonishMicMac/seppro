<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$phone=$_REQUEST['mobileno'];
$val=$_REQUEST['value'];



$pm=explode("^",$phone);


for($i=0;$i<count($pm);$i++)
{



$mobileno=$pm[$i];
$sql = mysql_query("UPDATE leaverequestedforstaff SET sent=$val WHERE id=$mobileno") or die(mysql_error());



}

?>