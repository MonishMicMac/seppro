<?php
include("connect1.php");

date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$drid=$_REQUEST['drid'];
$repid=$_REQUEST['repid'];
$managerid=$_REQUEST['managerid'];



$exp = explode(',',$drid);

$count = count($exp);

for($i=0;$i<$count;$i++)
{

$jj = mysql_query("SELECT * FROM dropenforschedule WHERE drid= '$exp[$i]' AND managerid= '$managerid' AND repid= '$repid' AND dateopen= '$cdate'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


   }
   else
   {
mysql_query("insert into dropenforschedule(drid,repid,managerid,dateopen,cdate)values('$exp[$i]','$repid','$managerid','$cdate','$cdate')")or die(mysql_error());


}




}











?>