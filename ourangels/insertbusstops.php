<?php
include("../includes/connect_db.php"); 

$busno=$_REQUEST['busno'];
$shift=$_REQUEST['shift'];
$lat=$_REQUEST['lat'];
$lon=$_REQUEST['lon'];
$pd=$_REQUEST['pd'];

$address= getaddress($lat,$lon);

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



$a=mysql_query("insert into stopofbus(busno,shift,lat,lon,pd,areaname)values('$busno','$shift','$lat','$lon','$pd','$address')")or die(mysql_error());

?>