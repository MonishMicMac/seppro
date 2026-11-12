<?php

include("../includes/connect_db.php");

$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$staff_id=$_REQUEST['staff_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$a=mysql_query("select * from assignment where standard_id='$standard_id' and section_id='$section_id' and staff_id='$staff_id' and assignment_date like '%$month%' and assignment_date like '%$year%'");
echo "{";
while($row_ass=mysql_fetch_array($a))
{
$date=$row_ass['assignment_date'];
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
		