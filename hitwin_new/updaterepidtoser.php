<?php
include('connect.php');


$date=$_REQUEST['date'];
$wpid=$_REQUEST['wpid'];
$repid=$_REQUEST['repid'];







$proid = explode(",",$wpid);

for($i=0;$i< count($proid);$i++)
{

//echo "UPDATE reorting SET repid='$repid',tdate='$date' WHERE id='$proid[$i]'";exit();

mysql_query("UPDATE reorting SET repid='$repid',tdate='$date' WHERE id='$proid[$i]'")or die(mysql_error());

$reply='success';
}



echo $reply;


?>