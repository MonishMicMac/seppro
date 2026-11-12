<?php
include("../includes/connect_db.php"); 

$busid=$_REQUEST['busid'];
$studentid=$_REQUEST['studentid'];
$shift=$_REQUEST['shift'];


$proid = explode(",",$studentid);

for($i=0;$i< count($proid);$i++)
{

mysql_query("DELETE FROM studentallocatedtobus WHERE busid='$busid' AND shift='$shift' AND studentid='$proid[$i]'")or die(mysql_error());

mysql_query("UPDATE student_profile SET busimeino='0',latitudeforbus='0',longitutdeforbus='0',shift='0',pd='0' WHERE stu_id='$proid[$i]'")or die(mysql_error());



}



?>