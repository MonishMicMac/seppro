<?php
include("connectsms.php");

$id=$_REQUEST['userid'];
$gcm_android=$_REQUEST['gcm_android'];

// $sql=mysql_query("SELECT gcm_android FROM mst_users WHERE id='$id'");
// $row=mysql_fetch_array($sql);

if($gcm_android!=''){

	$sql=mysql_query("SELECT gcmid FROM student_profile WHERE stu_id='$id'");
	$row=mysql_fetch_array($sql);
	if($row!=$gcm_android)
	{	
		mysql_query("UPDATE student_profile SET gcmid='$gcm_android' WHERE stu_id='$id'");

		echo json_encode('Success');
	}
	else
	{
		echo json_encode('Success');
	}
} else {
	echo json_encode('Failed');
}
?>