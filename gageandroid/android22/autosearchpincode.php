<?php
	


	
	
	$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');
	$r=mysql_query("select * from master_pincode",$con);

	while($row=mysql_fetch_array($r))
	{
		$cls[]=$row;
	}

	print(json_encode($cls));
	
?>