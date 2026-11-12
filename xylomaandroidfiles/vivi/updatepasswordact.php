<?php
	include("../includes/connect_db.php");
	 
	$student_id=$_REQUEST['student_id'];
	$Password=$_REQUEST['Password'];


	 
	$flag['code']=0;
	 
	if($r=mysql_query("UPDATE student_profile SET Password = '$Password' WHERE student_id ='$student_id'",$con))
	{
		$flag['code']=1;
	}
	 
	
?>