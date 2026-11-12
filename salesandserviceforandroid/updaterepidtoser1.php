<?php
include('connect.php');


$date=$_REQUEST['date'];
$wpid=$_REQUEST['wpid'];
$repid=$_REQUEST['repid'];







$proid = explode(",",$wpid);

for($i=0;$i< count($proid);$i++)
{


mysql_query("UPDATE enquiry SET repid='$repid',date='$date' WHERE id='$proid[$i]'")or die(mysql_error());

$reply='success';
}



echo $reply;


?>