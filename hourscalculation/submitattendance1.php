<?php
include('connect.php');



$repid=$_REQUEST['repid'];
$lattt=$_REQUEST['lattt'];
$longgg=$_REQUEST['longgg'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$expenses=$_REQUEST['expenses'];





mysql_query("UPDATE attendancetable SET expenses='$expenses' WHERE date='$date' AND repid='$repid'")or die(mysql_error());




?>