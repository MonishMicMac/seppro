<?php
	include("../includes/connect_db.php");
	 
	$student_id=$_REQUEST['student_id'];
	


	 
	$flag['code']=0;
	 
	if($r=mysql_query("UPDATE student_profile SET activationcode = ' ' WHERE student_id ='$student_id'",$con))
	{
		$flag['code']=1;
	}
	 
	
?>