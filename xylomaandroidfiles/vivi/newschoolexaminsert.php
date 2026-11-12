<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$Standard_id=$_REQUEST['Standard_id'];
$Section_id=$_REQUEST['Section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$staff_id=$_REQUEST['staff_id'];
$Exam_date=$_REQUEST['Exam_date'];
$Examtype=$_REQUEST['Examtype'];
$Portion=$_REQUEST['Portion'];
$Subject_id=$_REQUEST['Subject_id'];
$Time=$_REQUEST['Time'];
$Total_marks=$_REQUEST['Total_marks'];
$Duration=$_REQUEST['Duration'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$cdate=date('Y-m-d');




$a=mysql_query("insert into exam_schedule(Standard_id,Section_id,standard_name,section_name,staff_id,Exam_date,Examtype,Portion,subjectname,Time,Total_marks,Duration,month,year,givendate)values('$Standard_id','$Section_id','$standard_name','$section_name','$staff_id','$Exam_date','$Examtype','$Portion','$Subject_id','$Time','$Total_marks','$Duration','$month','$year','$cdate')")or die(mysql_error());

?>