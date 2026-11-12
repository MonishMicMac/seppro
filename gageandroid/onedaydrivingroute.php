<?php

include("../includes/connect_db.php");

$busid=$_REQUEST['busid'];
$date=$_REQUEST['date'];






$sql = mysql_query("SELECT latandlong FROM busdayrecord where time='".$_REQUEST['busid']."' and date='".$_REQUEST['date']."'") or die(mysql_error());
$result = mysql_fetch_array($sql);

$sql1 = mysql_query("SELECT travel_time FROM busdayrecord where time='".$_REQUEST['busid']."' and date='".$_REQUEST['date']."'") or die(mysql_error());
$result1 = mysql_fetch_array($sql1);



$srt=rtrim($result['latandlong'], ":");

$rty=explode(":",$srt);

$rty1=explode(",",$result1['travel_time']);



 
function getaddress($lat,$lng)
{
$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
$json = @file_get_contents($url);
$data=json_decode($json);
$status = $data->status;
if($status=="OK")
return $data->results[0]->formatted_address;
else
return false;
}

echo '[';
for($i=0;$i<count($rty, COUNT_RECURSIVE);$i++)
{


if(count($rty, COUNT_RECURSIVE)-1==$i)
{

$rtyrt=explode(",",$rty[$i]);



$address= getaddress($rtyrt[0],$rtyrt[1]);
if($address)
{
echo '{"Area":'.'"'.$address.'","time":"'.$rty1[$i].'"}';
}
else
{
echo '{"Area":"Not found","time:00:00"}';
}
}
else
{

$rtyrt=explode(",",$rty[$i]);



$address= getaddress($rtyrt[0],$rtyrt[1]);
if($address)
{
echo '{"Area":'.'"'.$address.'","time":"'.$rty1[$i].'"},';
}
else
{

echo '{"Area":"Not found","time:00:00"},';
}
}



}

echo ']';



?>  