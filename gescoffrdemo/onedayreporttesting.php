<?php

include("connect.php"); 

$busid=$_REQUEST['busid'];
$date=$_REQUEST['date'];




$strSQL= "SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST['busid']."' and date='".$_REQUEST['date']."'";
//$result = mysql_fetch_array($strSQL);


$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$result= $objQuery ->fetchAll(PDO::FETCH_ASSOC);


$srt=rtrim($result['latandlong'], ":");
$srt1=rtrim($result['travel_time'], ":");

$rty=explode(":",$srt);
$rty1=explode(",",$srt1);

 

echo "[";
for($i=0;$i<count($rty, COUNT_RECURSIVE);$i++)
{

if(count($rty, COUNT_RECURSIVE)-1==$i)
{

echo '{"name":'.'"'.$rty[$i].'"'.',"time":'.'"'.$rty1[$i].'"}';
}
else
{

echo '{"name":'.'"'.$rty[$i].'"'.',"time":'.'"'.$rty1[$i].'"},';
}

}

echo "]";



?>  