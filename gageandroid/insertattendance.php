<?php
include("../includes/connect_db.php"); 

$student_id=$_REQUEST['student_id'];
$standardid=$_REQUEST['standardid'];
$sectionid=$_REQUEST['sectionid'];

$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$morning=$_REQUEST['morning'];
$afternoon=$_REQUEST['afternoon'];
$status=$_REQUEST['status'];




$id=(explode(",",$student_id));
$count=count($id)-1;
if($count == 0)
{
$a=mysql_query("insert into student_attendance(student_id,standardid,sectionid,stuname,day,month,year,morning,afternoon,status)values('$student_id','$standardid','$sectionid','$student_id','$day','$month','$year','$morning','$afternoon','$status')")or die(mysql_error());
}
else
{
for($i=0;$i<=$count;$i++)
{
$ids=$id[$i];
     mysql_query("insert into student_attendance(student_id,standardid,sectionid,stuname,day,month,year,morning,afternoon,status)values('$ids','$standardid','$sectionid','$ids','$day','$month','$year','$morning','$afternoon','$status') ")or die(mysql_error());
}
}



?>