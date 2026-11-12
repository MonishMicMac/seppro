<?php

include("../includes/connect_db.php");

$student_id=$_REQUEST['student_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$a=mysql_query("select * from  student_attendance where student_id='$student_id' and month='$month' and year='$year'");
$count=mysql_num_rows($a);

                                   


while($row_a=mysql_fetch_array($a)) {
$mor=$row_a['morning'];	
$aft=$row_a['afternoon'];

$day=$row_a['day'];

if($mor==="A" || $aft==="A" || $mor==="A" || $aft==="A")
{

$arr[]=$day;
}

}
$count=count($arr);
echo "{";
for($i=0;$i<=$count-2;$i++)
{
echo $arr[$i].",";
}
echo $arr[$count-1];
echo ",0}";

?>						   
		