<?php
	include("../includes/connect_db.php");
	 
	$id=$_REQUEST['id'];

    
	 
	$flag['code']=0;
	 
	if($r=mysql_query("DELETE FROM leaverequest WHERE id= '$id'"))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>