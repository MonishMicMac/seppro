<?php
include("connect1.php");

date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');


$repid=$_REQUEST['repid'];
$managerid=$_REQUEST['managerid'];
$date=$_REQUEST['date'];


$exp = explode(',',$repid);

$count = count($exp);

for($i=0;$i<$count;$i++)
{

$jj = mysql_query("SELECT * FROM managerjoinworkplans WHERE repid= '$exp[$i]' AND managerid= '$managerid' AND date= '$date'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


   }
   else
   {
mysql_query("insert into managerjoinworkplans(repid,managerid,date,cdate)values('$exp[$i]','$managerid','$date','$cdate')")or die(mysql_error());


}




}











?>