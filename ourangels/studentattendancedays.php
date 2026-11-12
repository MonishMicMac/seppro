<?php
include("connectsms.php");
///// Academic Year/////
$startingday=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$startingday_res=mysql_fetch_array($startingday);
$sexp=explode("-",$startingday_res['calendar_sdate']);
$eexp=explode("-",$startingday_res['calendar_edate']);
$ay=$sexp[0]."-".$eexp[0];
///// Academic Year/////

///// Counting Days/////
function countDays($year, $month, $ignore) {
    $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date("n", $counter) == $month) {
        if (in_array(date("w", $counter), $ignore) == false) {
            $count++;
        }
        $counter = strtotime("+1 day", $counter);
    }
    return $count;
}
///// Counting Days/////
echo '[';
$str="";
$absentdays=mysql_query("SELECT *,COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['studentid']."' AND academic_year='".$ay."' GROUP BY month")or die(mysql_error());
while($absentdays_res=mysql_fetch_array($absentdays))
	{

	$calcount=mysql_query("SELECT COUNT(cal_id) AS C FROM calendar WHERE holiday_month='".$absentdays_res['month']."' AND (status='2' || status='3')")or die(mysql_error());
	$calcount_res=mysql_fetch_array($calcount);

		$totaldays=countDays(date('Y'), $absentdays_res['month'], array(0, 6))-$calcount_res['C'];
		$percentage=round(($absentdays_res['S']/$totaldays)*100);
		$present=$totaldays-$absentdays_res['S'];
		$str.='{"studentid":"'.$absentdays_res['student_id'].'","absmonthid":"'.$absentdays_res['year']."-".$absentdays_res['month'].'","absmonthname":"'.date("F", mktime(0, 0, 0, $absentdays_res["month"], 10)).'","totaldays":"'.$totaldays.'","absent":"'.$absentdays_res['S'].'","present":"'.$present.'","percentage":"'.$percentage.'"},';
	}
echo substr($str,0,-1)."]";
	mysql_close($con);
?>