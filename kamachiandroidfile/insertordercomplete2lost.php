<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');


$id=$_REQUEST['id'];
$repid=$_REQUEST['repid'];
$lostreason=$_REQUEST['lostreason'];


mysql_query("UPDATE newlead SET  ordercheck='2',lostdealw='1',lostreason='$lostreason',cdate='$c_date' WHERE  id='$id' and repid='$repid'");




?>