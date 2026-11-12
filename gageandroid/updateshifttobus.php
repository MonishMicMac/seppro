<?php

include("../includes/connect_db.php");

 
$bus_ime_no= $_POST['bus_ime_no'];
$shift=$_POST['shift'];
$pd=$_POST['pd'];






$flag['code']=0;
	 
	if($r=mysql_query("UPDATE bus_record SET shift='$shift',pd='$pd' WHERE bus_ime_no='$bus_ime_no'",$con))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>