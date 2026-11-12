<?php
include("../includes/connect_db.php");
$stdid = $_REQUEST['stdid'];
$secid = $_REQUEST['secid'];
$mobile = $_REQUEST['mobile'];
//$fmobile = $_REQUEST['fathiermobile'];
//$mmobile = $_REQUEST['mothermobile'];
$studid = $_REQUEST['studid'];


$bhavuji = mysql_query("SELECT * FROM student_profile WHERE  student_id='$studid' ")or die(mysql_error());

$count = mysql_num_rows($bhavuji);
if($count > 0)
{
$jjanto_res = mysql_fetch_array($bhavuji);



   $student_id=$jjanto_res['student_id'];

   $Standard_id=$jjanto_res['Standard_id'];

   $Section_id=$jjanto_res['Section_id'];

   $Phone_no=$jjanto_res['Phone_no'];

if($studid == $student_id)
{
   $stuid = "1";
}
else  
{
$stuid = "0";
}


if($stdid == $Standard_id)
{
   $std= "1";
}
else
{
$std= "0";
}

if($secid == $Section_id)
{
   $sec= "1";
}
else
{
$sec= "0";
}

if($mobile == $Phone_no)
{
   $mobi= "1";
}
else
{
$mobi= "0";
}

echo '[{"studid":'.$stuid.',"std":'.$std.',"sec":'.$sec.',"mobi":'.$mobi.'}]';
}
else
{
echo '[{"studid":'."0".',"std":'."0".',"sec":'."0".',"mobi":'."0".'}]';
}


?>