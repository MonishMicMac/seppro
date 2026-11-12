<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$id=$_REQUEST['id'];
	 
	$flag['code']=0;
	 
	if($r=mysql_query("DELETE FROM leaverequestedforstaff WHERE id= '$id'",$con))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);

?>