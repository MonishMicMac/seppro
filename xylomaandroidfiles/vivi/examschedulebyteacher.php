<?php

include("../includes/connect_db.php");

$Standard_id=$_REQUEST['Standard_id'];
$Section_id=$_REQUEST['Section_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];



$a=mysql_query("select * from exam_schedule where Standard_id='$Standard_id' and Section_id='$Section_id' and Exam_date like '%$month%' and Exam_date like '%$year%'");
echo "{";
while($row_ass=mysql_fetch_array($a))
{
$date=$row_ass['Exam_date'];
$a_date=substr($date,8,2);
if(substr($a_date,0,1) == 0)
{
  echo substr($a_date,1,2).",";
}
else
{
echo $a_date,",";
} 
}
echo "0}";

?>						   
		