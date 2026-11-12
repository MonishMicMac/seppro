<?php
include("../includes/connect_db.php"); 

$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$meeting_date=$_REQUEST['meeting_date'];
$meeting_time=$_REQUEST['meeting_time'];
$meeting_type=$_REQUEST['meeting_type'];
$meeting_desc=$_REQUEST['meeting_desc'];
$meeting_duration=$_REQUEST['meeting_duration'];

$status='0';





$a=mysql_query("insert into management_add_meeting(standard_id,section_id,meeting_date,meeting_time,meeting_type,meeting_desc,meeting_duration,status)values('$standard_id','$section_id','$meeting_date','$meeting_time','$meeting_type','$meeting_desc','$meeting_duration','$status')")or die(mysql_error());

?>