<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');


$id=$_REQUEST['id'];
$repid=$_REQUEST['repid'];
$invoiceno=$_REQUEST['invoiceno'];
$complaint=$_REQUEST['complaint'];
$complaindate=$_REQUEST['complaindate'];

//echo "UPDATE doctors SET  complaint='$complaint',complaindate='$c_date',invoiceno='$invoiceno' WHERE  id='$id' and rep_assign='$repid'";exit();

mysql_query("UPDATE doctors SET  complaint='$complaint',complaindate='$complaindate',invoiceno='$invoiceno' WHERE  id='$id' and rep_assign='$repid'");




?>