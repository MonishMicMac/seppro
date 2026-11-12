<?php
	include("../includes/connect_db.php");
	 
	$exam_id=$_REQUEST['exam_id'];

    
	 
	$flag['code']=0;
	 
	if($r=mysql_query("DELETE FROM exam_schedule WHERE exam_id= '$exam_id'"))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>