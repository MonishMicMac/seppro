<?php
include("../includes/connect_db.php"); 

$busimeino=$_REQUEST['busimeino'];
$stu_id=$_REQUEST['stu_id'];
$latitudeforbus=$_REQUEST['latitudeforbus'];
$longitutdeforbus=$_REQUEST['longitutdeforbus'];
$shift=$_REQUEST['shift'];
$pd=$_REQUEST['pd'];


$proid = explode(",",$stu_id);

for($i=0;$i< count($proid);$i++)
{

$a = mysql_query("UPDATE student_profile SET busimeino='$busimeino',latitudeforbus='$latitudeforbus',longitutdeforbus='$longitutdeforbus',shift='$shift',pd='$pd' WHERE stu_id='$proid[$i]' ")or die(mysql_error());


}



?>