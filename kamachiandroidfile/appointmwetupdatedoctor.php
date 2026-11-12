<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



function getaddress($latitude,$longitude)
{
$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false';
$json = @file_get_contents($url);
$data=json_decode($json);
$status = $data->status;
if($status=="OK")
return $data->results[0]->formatted_address;
else
return false;
}

$address= getaddress($latitude,$longitude);
if($address)
{

$strSQL=$je->prepare("UPDATE tbl_work_plan SET attendancestatus=1 ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time' WHERE wp_id='$wp_id'")or die(mysql_error());
$strSQL->execute();

}
else
{

$strSQL1=$je->prepare("UPDATE tbl_work_plan SET attendancestatus=1 ,latitude='$latitude' ,longitude='$longitude' ,areaname='Not found' ,reporteddate='$c_date' ,reportedtime='$c_time' WHERE wp_id='$wp_id'")or die(mysql_error());
$strSQL1->execute();
}











?>