<?php

include("../includes/connect_db.php");

 
$stu_id= $_POST['stu_id'];
$teacherstatus='1';






$flag['code']=0;
	 
if($r=mysql_query("UPDATE student_profile SET teacherstatus='$teacherstatus' WHERE stu_id='$stu_id'",$con))
	{
		$flag['code']=1;
	}
	 
	print(json_encode($flag));
	mysql_close($con);
?>