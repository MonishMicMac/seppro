<?php
include("connect.php");

$busid=$_REQUEST['busid'];
$date=$_REQUEST['date'];



$anto = "SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST['busid']."' and date='".$_REQUEST['date']."'";


$result = mysql_query($anto);

$count = mysql_num_rows($result);



$result_array = array();
$result_array1 = array();

$concstri;

$i=0;
$j=0;

while($row = mysql_fetch_array($result))
{
    $result_array[] = $row['travel_time'];
     $result_array1[] = $row['latandlong'];
      print_r($result_array);
 

$i++;
$j++;
}
$gt='0';
$Fromtime;
for($i=0;$i<$j;$i++)

{

if($i<$j-1)
{


$Fromtime=substr($result_array[$gt],11,-3);
$time2 = substr($result_array[$i+1],11,-3);
$time1 = $Fromtime;



list($hours, $minutes) = explode(':', $time1);
$startTimestamp = mktime($hours, $minutes);

list($hours, $minutes) = explode(':', $time2);
$endTimestamp = mktime($hours, $minutes);

$seconds = $endTimestamp - $startTimestamp;
$minutes = ($seconds / 60) % 60;
$hours = floor($seconds / (60 * 60));
if($minutes>='15')
{
$gt=$i;
//echo "From time:".$Fromtime."<br/>";
//echo "To time:".substr($result_array[$i+1],11,-3)."<br/>";
//echo "<b>$minutes</b> Minutes"."<br/>";
$latitude=$result_array1[$gt];
//echo $latitude."<br/>";
//echo $longitude."<br/>";
$df='{"lat":"'.$latitude.'",'.'"long":"'.$longitude.'"'.',"time":"'.substr($result_array[$i+1],11,-3).'"},';
$concstri=$concstri.$df;
}



}



}
	echo $concstri;
	echo '['.substr($concstri,0,-1).']';
	mysql_close($con);
	

	
 
 	
?>