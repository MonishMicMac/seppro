<?php
include("connect2.php"); 


$productid=$_REQUEST['productid'];
$typeofcall=$_REQUEST['typeofcall'];
$comment=$_REQUEST['comment'];
$drfeedback=$_REQUEST['drfeedback'];
$worktype=$_REQUEST['worktype'];


$repid=$_REQUEST['repid'];
$doctorid=$_REQUEST['doctorid'];
$wpid=$_REQUEST['wpid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");

if($productid == "" || $productid == " " )
{
   $pandiyan = mysql_query("SELECT * FROM reportnowforrep WHERE productid = '6' AND repid = '$repid' AND doctorid = '$doctorid' AND date = '$c_date'")or die(mysql_error());
   $pandiyan_count = mysql_num_rows($pandiyan);
   if($pandiyan_count > 0)
   {

   }
   else
   {
     mysql_query("insert into    reportnowforrep(productid,typeofcall,comment,drfeedback,worktype,repid,doctorid,wpid,date,time)values('6','$typeofcall','$comment','$drfeedback','$worktype','$repid','$doctorid','$wpid','$c_date','$c_time')")or die(mysql_error());

//$a=$je->prepare("insert into reportnowforrep(productid,typeofcall,comment,drfeedback,worktype,repid,doctorid,wpid,date,time)values('6','$typeofcall','$comment','$drfeedback','$worktype','$repid','$doctorid','$wpid','$c_date','$c_time')")or die(mysql_error());
//$a->execute();
  }
}
else
{
$proid = explode(",",$productid);

}

for($i=0;$i< count($proid);$i++)
{

$antony= mysql_query("SELECT * FROM reportnowforrep WHERE productid = '$proid[$i]' AND repid = '$repid' AND doctorid = '$doctorid' AND date = '$c_date'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

   }
   else
   {
    //$a=$je->prepare("insert into reportnowforrep(productid,typeofcall,comment,drfeedback,worktype,repid,doctorid,wpid,date,time)values('$proid[$i]','$typeofcall','$comment','$drfeedback','$worktype','$repid','$doctorid','$wpid','$c_date','$c_time')")or die(mysql_error());
//$a->execute();
mysql_query("insert into reportnowforrep(productid,typeofcall,comment,drfeedback,worktype,repid,doctorid,wpid,date,time)values('$proid[$i]','$typeofcall','$comment','$drfeedback','$worktype','$repid','$doctorid','$wpid','$c_date','$c_time')")or die(mysql_error());
  }

}



mysql_query("UPDATE tbl_work_plan SET reportstatus=1 WHERE wp_id='$wpid'")or die(mysql_error());


/*$strSQL1 = $je->prepare("UPDATE tbl_work_plan SET reportstatus=1 WHERE wp_id='$wpid'")or die(mysql_error());
$strSQL1->execute();*/

?>
