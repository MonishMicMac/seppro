<?php
include('connect.php');


$clientid=$_REQUEST['clientid'];

$typeofcall=$_REQUEST['typeofcall'];

$complaints=$_REQUEST['complaints'];

$amount=$_REQUEST['amount'];

$comingdate=$_REQUEST['comingdate'];

$comingtime=$_REQUEST['comingtime'];




$servicetype=$_REQUEST['servicetype'];

$productrequested=$_REQUEST['productrequested'];


$proid = explode(",",$clientid);

for($i=0;$i< count($proid);$i++)
{




$chkall=mysql_query("SELECT * FROM reorting WHERE tdate='".$_REQUEST['tdate']."' AND clientid='$proid[$i]' AND attendance='0' AND servicetype='$servicetype' AND productrequested='$productrequested' AND repid='".$_REQUEST['repid']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{

	/*echo "INSERT INTO reorting(tdate,clientid,scheduleddate,scheduledtime,repid,typeofcall,servicetype,productrequested,complaints,amount,comingdate,comingtime)VALUES('".$_REQUEST['tdate']."','$proid[$i]','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','".$_REQUEST['repid']."','$typeofcall','$servicetype','$productrequested','$complaints','$amount','$comingdate','$comingtime')";exit();
*/
	
mysql_query("INSERT INTO reorting(tdate,clientid,scheduleddate,scheduledtime,repid,typeofcall,servicetype,productrequested,complaints,amount,comingdate,comingtime)VALUES('".$_REQUEST['tdate']."','$proid[$i]','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','".$_REQUEST['repid']."','$typeofcall','$servicetype','$productrequested','$complaints','$amount','$comingdate','$comingtime')")or die(mysql_error());
}


}

mysql_query("UPDATE representative SET schedule_status='0' WHERE id='".$_REQUEST['repid']."'")or die(mysql_error());



?>