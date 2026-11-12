<?php 
include("../includes/connect_db.php");

date_default_timezone_set("Asia/Kolkata");
 
    $cdate = date('Y-m-d');
    $ctime = date('h:i A');
    
mysql_query("INSERT INTO tbl_demo(title,description,latitude,longtude,cdate,ctime,status)VALUES('".$_REQUEST['title']."','".$_REQUEST['description']."','".$_REQUEST['latitude']."','".$_REQUEST['longtude']."','$cdate','$ctime','1')")or die(mysql_error());
?>