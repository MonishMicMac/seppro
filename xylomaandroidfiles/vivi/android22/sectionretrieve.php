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


$asd = mysql_query("SELECT subject,description,pageno FROM assignment where standard_id='$sec_standard_id' AND section_id=$df AND assignment_date='$date'")or die(mysql_error());


while($pm1=mysql_fetch_array($asd))
{

$dff=$pm1['subject'];
$dff1=$pm1['description'];
$dff2=$pm1['pageno'];

$dff4='{"subject":"'.$dff.'","desc":"'.$dff1.'","sectname":"'.$df1we.'","sectid":"'.$df.'","pageno":"'.$dff2.'"},';
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