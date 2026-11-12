<?php
include("connect1.php");
$senderid=$_REQUEST['senderid'];
$reciverid=$_REQUEST['reciverid'];
$issueid=$_REQUEST[issueid];
$msg=$_REQUEST['msg'];

$proid = explode("$",$msg);

date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');


$time = date('H:i');




for($i=0;$i< count($proid);$i++)
{
$jjsdzz = mysql_query("INSERT INTO chat(meesgae,senderid,receiverid,issueid,cdate,ctime)VALUES('$proid[$i]','$senderid','$reciverid','$issueid','$date','$time')")or die(mysql_error());
}

echo 'sucess';

?>
