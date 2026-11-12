<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$sql = mysql_query("SELECT status FROM student_attendance where day='$day' AND month='$month' AND year='$year'")or die(mysql_error());

$fr=mysql_fetch_array($sql);




$student_id=$fr['status'];

$ry=substr($student_id,1,-1);

$pm=explode(",",$ry);

for($i=0;$i<count($pm);$i++)
{

$sql = mysql_query("SELECT * FROM student_profile where stu_id='$pm[$i]'")or die(mysql_error());
while($par=mysql_fetch_array($sql))
{

$dff4='{"name":"'.$par['Name'].'","phone":"'.$par['Phone_no'].'","standard":"'.$par['standard_name'].'","section":"'.$par['section_name'].'"},';
$items[] = $dff4;
}


}



echo '[';
if(count($items)==0)
{
echo ']';
}

for($i=0;$i<count($items);$i++)
{

if($i==count($items)-1)
{
$ry=substr($items[$i],0,-1);
echo $ry.']';
}
else
{
echo $items[$i];
}

}






?>