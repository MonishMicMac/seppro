<?php

include("connect2.php"); 
$reciverid=$_REQUEST['reciverid'];
$msg=$_REQUEST['msg'];

$proid = explode("$",$msg);



for($i=0;$i< count($proid);$i++)
{
$jjsdzz = mysql_query("INSERT INTO chat(meesgae,senderid,receiverid)VALUES('$proid[$i]','$senderid','$reciverid')")or die(mysql_error());
}

echo 'sucess';

?>
