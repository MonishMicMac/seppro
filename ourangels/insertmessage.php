<?php
include("../includes/connect_db.php"); 

$teacherid=$_REQUEST['teacherid'];
$teachername=$_REQUEST['teachername'];
$parentid=$_REQUEST['parentid'];
$parentname=$_REQUEST['parentname'];
$teacherurl=$_REQUEST['teacherurl'];
$parenturl=$_REQUEST['parenturl'];
$message=$_REQUEST['message'];
$status=$_REQUEST['status'];
$sentid=$_REQUEST['sentid'];
$dt = new DateTime("Asia/Kolkata");
$c_date=$dt->format('Y-m-d');
$c_time=$dt->format('H:i:s');


if($sentid=='TA')
{
$Parentstatus='0';
$Teacherstatus='1';
}
else
{
$Parentstatus='1';
$Teacherstatus='0';
}

$mess=explode("@#$",$message);
$count_mess=count($mess)-1;
for($i=0;$i<=$count_mess;$i++)
{
  $r_mess=$mess[$i];
  $a=mysql_query("insert into teachersparentchat(teacherid,teachername,parentid,parentname,teacherurl,parenturl,message,status,sentid,date,time,Parentstatus,Teacherstatus)values('$teacherid','$teachername','$parentid','$parentname','$teacherurl','$parenturl','$r_mess','$status','$sentid','$c_date','$c_time','$Parentstatus','$Teacherstatus')")or die(mysql_error()); 
}


?>