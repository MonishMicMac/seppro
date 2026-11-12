<?php
include("../includes/connect_db.php"); 

$busid=$_REQUEST['busid'];
$studentid=$_REQUEST['studentid'];
$studentname=$_REQUEST['studentname'];
$shift=$_REQUEST['shift'];


$proid = explode(",",$studentid);

for($i=0;$i< count($proid);$i++)
{

$a=mysql_query("insert into studentallocatedtobus(busid,studentid,studentname,shift)values('$busid','$proid[$i]','$studentname','$shift')")or die(mysql_error());

}



?>