<?php
include("../includes/connect_db.php"); 



$Exam_date=$_REQUEST['Exam_date'];
$Exam_type=$_REQUEST['Exam_type'];
$Portion=$_REQUEST['Portion'];
$subjectname=$_REQUEST['subjectname'];
$Standard_id=$_REQUEST['Standard_id'];
$Section_id=$_REQUEST['Section_id'];
$Time=$_REQUEST['Time'];
$Total_marks=$_REQUEST['Total_marks'];
$Duration=$_REQUEST['Duration'];
$status=$_REQUEST['status'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$a=mysql_query("insert into exam_schedule(Exam_date,Examtype,Portion,subjectname,Standard_id,Section_id,Time,Total_marks,Duration,status,month,year)values('$Exam_date','$Exam_type','$Portion','$subjectname','$Standard_id','$Section_id','$Time','$Total_marks','$Duration','$status','$month','$year')")or die(mysql_error());

?>