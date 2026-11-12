<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];

$output;


$sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='$rep_id'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);
 $wages=$aqq['rep_hq_wages'];



$splidate=explode("-",$date);

$day;





$number = cal_days_in_month(CAL_GREGORIAN, $splidate[1], $splidate[0]); // 31

for($yu=1;$yu<=$number;$yu++)
{

if($yu<=9)
{

$day=$date.'0'.$yu;

}
else

{

$day=$date.$yu;

}




$timestamp = strtotime($day);

$day1 = date('D', $timestamp);

if($day1 == "Sun")
{
$output.= '{"value":"'.$day.'*'.$day1.'*0'.'"},';

}
else 
{

$sqls=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) as pids,GROUP_CONCAT(latitude) as latitude,GROUP_CONCAT(longitude) as longitude FROM tbl_work_plan where wp_date='$day' AND attendancestatus='1' AND wp_rep_id='$rep_id' AND latitude!='0' AND longitude!='0' AND latitude!='0.0' AND longitude!='0.0'")or die(mysql_error());
$a=mysql_fetch_array($sqls);
$drcaall=$a['pids'];

if($drcaall=='')
{
$output.= '{"value":"'.$day.'*no visit'.'*0'.'"},';

}
else
{


$sqlsq=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) as pinid FROM doctors where id IN($drcaall)")or die(mysql_error());
$aq=mysql_fetch_array($sqlsq);
$drcaallq=$aq['pinid'];


$sqlsqs=mysql_query("SELECT GROUP_CONCAT(area_name) as areaname FROM pincode_list where pin_id IN($drcaallq)")or die(mysql_error());
$aqs=mysql_fetch_array($sqlsqs);
$drcaallqs=$aqs['areaname'];
$drcaallqww=$a['latitude'];
$drlong=$a['longitude'];

$output.= '{"value":"'.$day.'*'.$drcaallqs.'*'.$drcaallqww.'*'.$drlong.'*'.$wages.'"},';



}
}




}



$rest = substr($output, 0, -1); 	
	
echo '['.$rest.']';	
	
	
	
	
	
	
?>