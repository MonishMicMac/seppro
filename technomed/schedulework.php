<?php
include('connect.php');


$clientid=$_REQUEST['clientid'];

$proid = explode(",",$clientid);

for($i=0;$i< count($proid);$i++)
{




$chkall=mysql_query("SELECT * FROM reorting WHERE tdate='".$_REQUEST['tdate']."' AND clientid='$proid[$i]' AND attendance='0' AND repid='".$_REQUEST['repid']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{
mysql_query("INSERT INTO reorting(tdate,clientid,scheduleddate,scheduledtime,repid)VALUES('".$_REQUEST['tdate']."','$proid[$i]','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','".$_REQUEST['repid']."')")or die(mysql_error());
}


}



?>