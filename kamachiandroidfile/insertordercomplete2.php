<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');


$id=$_REQUEST['id'];
$repid=$_REQUEST['repid'];


mysql_query("UPDATE newlead SET  ordercheck='2',cdate='$c_date' WHERE  id='$id' and repid='$repid'");




?>