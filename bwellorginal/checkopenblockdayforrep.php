<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$blockopendate=$_REQUEST['blockopendate'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$antony= mysql_query("SELECT * FROM blockingopen WHERE repid= '$repid' AND blockopendate= '$blockopendate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {


   }
   else
   {
mysql_query("insert into blockingopen(repid,blockopendate,cdate,ctime)values('$repid','$blockopendate','$c_date','$c_time')")or die(mysql_error());

}







?>