<?php
include('connectsms.php');
if($_REQUEST['image']!='')
{
	$target_path ="grievance_img/";
	$uploaded_files=$_FILES['image']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'], $target_path .$_FILES['image']['name']);
	$sql="INSERT INTO grievance (grievance_subject,grievance_message,image,student_id,standard_id,section_id,applied_date) VALUES('".$_REQUEST['subject']."','".$_REQUEST['msg']."','$uploaded_files','".$joel['stu_id']."','".$joel['Standard_id']."','".$joel['Section_id']."','".date('Y-m-d H:i:s A')."')";
}
else
{
	$sql="INSERT INTO grievance (grievance_subject,grievance_message,student_id,standard_id,section_id,applied_date) VALUES('".$_REQUEST['subject']."','".$_REQUEST['msg']."','".$joel['stu_id']."','".$joel['Standard_id']."','".$joel['Section_id']."','".date('Y-m-d H:i:s A')."')";
}
mysql_query($sql)or die(mysql_error());
?>