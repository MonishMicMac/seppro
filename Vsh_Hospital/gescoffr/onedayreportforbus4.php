<?php
include("connect1.php");




$busid=$_REQUEST['busid'];
$date=$_REQUEST['date'];






$sql = mysql_query("SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST['busid']."' and date='".$_REQUEST['date']."'") or die(mysql_error());
$result = mysql_fetch_array($sql);


$srt=rtrim($result['latandlong'], ":");
$srt1=rtrim($result['travel_time'], ":");

$rty=explode(":",$srt);
$rty1=explode(",",$srt1);




$values='';
for($i=0;$i<count($rty, COUNT_RECURSIVE);$i++)
{
	if($i==0){
		$values.='{"name":'.'"'.$rty[$i].'"'.',"time":'.'"'.$rty1[$i].'"},';
		$first_time= date("H:i", strtotime('+30 minutes', strtotime($rty1[$i])));
	}

	 echo $rty[$i]." // ".$first_time.' <= '.$rty1[$i].'<br>';

	if($first_time<=$rty1[$i] || $first_time<=$rty1[$i]){
		$first_time=date("H:i", strtotime('+30 minutes', strtotime($rty1[$i])));
		$values.='{"name":'.'"'.$rty[$i].'"'.',"time":'.'"'.$first_time.'"},';
	}

}

// echo "[".rtrim($values,",")."]";



?>  