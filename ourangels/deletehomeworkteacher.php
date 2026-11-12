<?php
	include("../includes/connect_db.php");
	 
	$assign_id=$_REQUEST['assign_id'];

    
	 
	$flag['code']=0;
	 
	if($r=mysql_query("DELETE FROM assignment WHERE assign_id= '$assign_id'"))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>