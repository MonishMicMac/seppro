<?php
include("include/connect.php");
$command=$_POST['command'];
if($command=='comp_save')
{
$name=$_POST['name'];
$location=$_POST['location'];
$contact1=$_POST['contact1'];
$contact2=$_POST['contact2'];
$random_no=rand(100000,999999);
$c_date=date("d-m-Y");
mysql_query("insert into company(name,location,contact1,contact2,comp_id,c_date)values('$name','$location','$contact1','$contact2','$random_no','$c_date')")or die(mysql_error());
echo "<script type='text/javascript'>alert('Company Details Added Successfully');window.location.href='home.php';</script>";
}
?>