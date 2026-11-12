<?php
include("../includes/connect_db.php"); 

$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$assignment_date=$_REQUEST['assignment_date'];
$subject=$_REQUEST['subject'];
$description=$_REQUEST['description'];
$deadline_date=$_REQUEST['deadline_date'];
$status=$_REQUEST['status'];
$pageno=$_REQUEST['pageno'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$a=mysql_query("insert into assignment(staff_id,standard_id,section_id,assignment_date,subject,description,deadline_date,status,pageno,month,year)values('$staff_id','$standard_id','$section_id','$assignment_date','$subject','$description','$deadline_date','$status','$pageno','$month','$year')")or die(mysql_error());

?>