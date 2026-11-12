<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$noofdays=$_REQUEST['noofdays'];
$dateofleave=$_REQUEST['dateofleave'];
	$sent=$_REQUEST['sent'];
	 
	$flag['code']=0;
	 
	if($r=mysql_query("UPDATE leaverequestedforstaff SET sent= '$sent' WHERE noofdays='$noofdays' AND dateofleave='$dateofleave'",$con))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);

?>