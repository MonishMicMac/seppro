<?php

include("connect2.php"); 



$repid=$_REQUEST['repid'];
$ladate=$_REQUEST['ladate'];




$tw= explode('-',$ladate);
$twmnth=$tw[1];
$twyear=$tw[0];


 $month = $twmnth;
    $year = $twyear; 
    $day_count = cal_days_in_month($type, $month, $year); 
for ($i = 1; $i <= $day_count; $i++) {

        $date = $year.'/'.$month.'/'.$i; 
        $get_name = date('l', strtotime($date)); 
        $day_name = substr($get_name, 0, 3); 

        //if not a weekend add day to array
        if($day_name != 'Sun'){
            $workdays[] = $i;
        }


}

$total = count($workdays);



$localcount = mysql_query("SELECT COUNT(id) AS LO FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='local'")or die(mysql_error());

$localcount_res = mysql_fetch_array($localcount);

$jjlocalcount = $localcount_res['LO'];



$exstationcount =  mysql_query("SELECT COUNT(id) AS EX FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='exstation'")or die(mysql_error());

$exstationcount_res = mysql_fetch_array($exstationcount);

$jjexstationcount = $exstationcount_res['EX'];





$meetingcount =  mysql_query("SELECT COUNT(id) AS MEET FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='meeting'")or die(mysql_error());

$meetingcount_res = mysql_fetch_array($meetingcount);

$jjmeetingcount = $meetingcount_res['MEET'];



$leavecount =  mysql_query("SELECT COUNT(id) AS JJLEAVE FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='leave'")or die(mysql_error());

$leavecount_res = mysql_fetch_array($leavecount);

$jjleavecount = $leavecount_res['JJLEAVE'];


$casualleave = mysql_query("SELECT COUNT(id) AS JJCASUALLEAVE FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='leave' AND reason LIKE'Casual leave:%'")or die(mysql_error());

$casualleave_res = mysql_fetch_array($casualleave);

$jjcasualleavecount = $casualleave_res['JJCASUALLEAVE'];



$sickleave = mysql_query("SELECT COUNT(id) AS JJSICKLEAVE FROM repgivenasleave WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate LIKE '$ladate%' AND expenses='leave' AND reason LIKE'Sick leave:%'")or die(mysql_error());

$sickleave_res = mysql_fetch_array($sickleave);

$jsickleavecount = $sickleave_res['JJSICKLEAVE'];



$saadhaleave = $jjleavecount-($jjcasualleavecount + $jsickleavecount);


echo '[{"expense":"Working days","count":'.'"'.$total.'"},{"expense":"Local","count":'.'"'.$jjlocalcount.'"}'.',{"expense":"Meeting","count":'.'"'."$jjmeetingcount".'"},{"expense":"Exstation","count":"'."$jjexstationcount".'"},{"expense":"Leave","count":"'."$jjleavecount".'"},{"expense":"Casual leave","count":"'."$jjcasualleavecount".'"},{"expense":"Sick leave","count":"'."$jsickleavecount".'"},{"expense":"Normal leave","count":"'."$saadhaleave".'"}]';


?>
