<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');
$c_time=date('h:i:s A');

$clientid=$_REQUEST['clientid'];
$repid=$_REQUEST['repid'];
$latitude_in=$_REQUEST['latitude_in'];
$feedback=$_REQUEST['feedback'];
$intime=$_REQUEST['intime'];	
$longitude_in=$_REQUEST['longitude_in'];
$outfeedback=$_REQUEST['outfeedback'];
$outtime=$_REQUEST['outtime'];
$latitude_out=$_REQUEST['latitude_out'];
$longitude_out=$_REQUEST['longitude_out'];


function get_time_difference($time1, $time2) {
	$date1=date('Y-m-d')." ".$time1;
	$date2=date('Y-m-d')." ".$time2;
	$dater=date('Y-m-d')." 00:00:00";
    $time1 = strtotime($date1);
    $time2 = strtotime($date2);
    
    if ($time2 < $time1) {
        $time2 += 86400;
    }
    
    return date("H:i:s", strtotime($dater) + ($time2 - $time1));
}

$timediff=get_time_difference($intime, $outtime); // 12:15:29//

mysql_query("update sampletimeinandout set outfeedback='$outfeedback',latitude_out='$latitude_out',longitude_out='$longitude_out',feedback='$feedback',longitude_in='$longitude_in',latitude_in='$latitude_in',intimestatus='1',intime='$intime',outtimestatus='1',outtime='$outtime',attenstatus='1' ,c_date='$c_date',timediff='$timediff' where clientid='$clientid' and repid='$repid' and scheduledate='$c_date' ");

mysql_query("UPDATE doctors SET intimestatus='1',outtimestatus='1' WHERE id='$clientid'");
	
?>