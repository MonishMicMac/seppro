<?php
include('connect.php');


$farename1=$_REQUEST['farename'];
$fareamount1=$_REQUEST['fareamount'];
$expenses2=$_REQUEST['expenses'];


$farename= explode(",",$farename1);
$fareamount= explode(",",$fareamount1);
$expenses1= explode(",",$expenses2);





for($i=0;$i< count($fareamount);$i++)
{

mysql_query("INSERT INTO expenses(repid,farename,fareamount,remarks,reporteddate,reportedtime,claimed,approvedby)VALUES('".$_REQUEST['repid']."','$farename[$i]','$fareamount[$i]','$expenses1[$i]','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','0','0')")or die(mysql_error());
}


?>