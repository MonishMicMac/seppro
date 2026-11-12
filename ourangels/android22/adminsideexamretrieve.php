<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$sec_standard_id=$_REQUEST['sec_standard_id'];
$date=$_REQUEST['date'];






$sql = mysql_query("SELECT section,sectionname FROM section where sec_standard_id='$sec_standard_id'")or die(mysql_error());

$items = array();

while($pm=mysql_fetch_array($sql))
{

$df=$pm['section'];

$df1we=$pm['sectionname'];


$asd = mysql_query("SELECT Exam_date,Examtype,subjectname FROM exam_schedule where Standard_id='$sec_standard_id' AND Section_id=$df AND givendate='$date'")or die(mysql_error());


while($pm1=mysql_fetch_array($asd))
{

$dff=$pm1['Exam_date'];
$dff1=$pm1['Examtype'];
$dff2=$pm1['subjectname'];

$dff4='{"examdate":"'.$dff.'","examtype":"'.$dff1.'","sectname":"'.$df1we.'","sectid":"'.$df.'","subjectname":"'.$dff2.'"},';
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