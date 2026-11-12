<?php
include("connect.php"); 

$productid=$_REQUEST['productid'];
$typeofcall=$_REQUEST['typeofcall'];
$comment=$_REQUEST['comment'];
$worktype=$_REQUEST['worktype'];


$repid=$_REQUEST['repid'];
$doctorid=$_REQUEST['doctorid'];
$wpid=$_REQUEST['wpid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$proid = explode(",",$productid);
for($i=0;$i< count($proid);$i++)
{

$a=$je->prepare("insert into reportnowforrep(productid,typeofcall,comment,worktype,repid,doctorid,wpid,date,time)values('$proid[$i]','$typeofcall','$comment','$worktype','$repid','$doctorid','$wpid','$c_date','$c_time')")or die(mysql_error());
$a->execute();

}





$b=$je->prepare("UPDATE tbl_work_plan SET reportstatus=1 WHERE wp_id='$wpid'")or die(mysql_error());
$b->execute();

?>
