<?php
include("connect.php"); 

$rep_name=$_REQUEST['rep_name'];
$father_name=$_REQUEST['father_name'];
$id_proof_num=$_REQUEST['id_proof_num'];
$address=$_REQUEST['address'];
$doj=$_REQUEST['doj'];
$dob=$_REQUEST['dob'];
$mobile=$_REQUEST['mobile'];
$rep_imeino=$_REQUEST['rep_imeino'];

$districtid=$_REQUEST['districtid'];
$pid=$_REQUEST['pid'];







$a=$je->prepare("insert into representative(rep_name,father_name,id_proof_num,address,doj,dob,mobile,rep_imeino)values('$rep_name','$father_name','$id_proof_num','$address','$doj','$dob','$mobile','$rep_imeino')")or die(mysql_error());

$a->execute();

$last_id=$je->lastInsertId();

$proid = explode(",",$pid);
for($i=0;$i< count($proid);$i++)
{

$b = $je->prepare("INSERT INTO rep_area(district_id,pin_id,rep_id)VALUES('$districtid','$proid[$i]','$last_id')")or die(mysql_error());
$b->execute();
}

?>
