<?php
	$hostname="localhost";
$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');
	$filename=$_REQUEST['filename'];
	$uploaded_file_value=$_REQUEST['uploaded_file_value'];
	 
	$flag['code']=0;
	 
	if($r=mysql_query("UPDATE adminvoice SET uploaded_file_value= '$uploaded_file_value' WHERE filename='$filename'",$con))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>