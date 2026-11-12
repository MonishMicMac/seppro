<?php
include("connectsms.php");
///// Academic Year/////



function getWorkingDays($startDate, $endDate)
{
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {
        echo "startdate is in the future! <br />";

        return 0;
    } else {
        $no_days  = 0;
        $weekends = 0;
        while ($begin <= $end) {
            $no_days++; // no of days in the given interval
            $what_day = date("N", $begin);
            if ($what_day > 5) { // 6 and 7 are weekend days
                $weekends++;
            };
            $begin += 86400; // +1 day
        };
        $working_days = $no_days - $weekends;

        return $working_days;
    }
}
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
//echo $absentdays_res['month']."--".date('m')."<br>";
	if($absentdays_res['month']==date('m'))
	{

		$sdate=date("Y")."-".date('m')."-01";
		$beginday = date($sdate);
		$lastday  = date("Y-m-d");
		$nr_work_days = getWorkingDays($beginday, $lastday);

		$calcount=mysql_query("SELECT COUNT(cal_id) AS C FROM calendar WHERE holiday_month='".$absentdays_res['month']."' AND (status='2' || status='3') AND holiday_date BETWEEN '$sdate' AND '".date('Y-m-d')."'")or die(mysql_error());
		$calcount_res=mysql_fetch_array($calcount);

		$totaldays=$nr_work_days-$calcount_res['C'];
		$present=$totaldays-$absentdays_res['S'];
		$percentage=round(($present/$totaldays)*100);

		$str.='{"studentid":"'.$absentdays_res['student_id'].'","absmonthid":"'.$absentdays_res['year']."-".$absentdays_res['month'].'","absmonthname":"'.date("F", mktime(0, 0, 0, $absentdays_res["month"], 10)).'","totaldays":"'.$totaldays.'","absent":"'.$absentdays_res['S'].'","present":"'.$present.'","percentage":"'.$percentage.'"},';
	}
	else
	{
		$calcount=mysql_query("SELECT COUNT(cal_id) AS C FROM calendar WHERE holiday_month='".$absentdays_res['month']."' AND (status='2' || status='3')")or die(mysql_error());
		$calcount_res=mysql_fetch_array($calcount);
		$totaldays=countDays(date('Y'), $absentdays_res['month'], array(0, 6))-$calcount_res['C'];
		$present=$totaldays-$absentdays_res['S'];
		$percentage=round(($present/$totaldays)*100);
		$str.='{"studentid":"'.$absentdays_res['student_id'].'","absmonthid":"'.$absentdays_res['year']."-".$absentdays_res['month'].'","absmonthname":"'.date("F", mktime(0, 0, 0, $absentdays_res["month"], 10)).'","totaldays":"'.$totaldays.'","absent":"'.$absentdays_res['S'].'","present":"'.$present.'","percentage":"'.$percentage.'"},';
	}

	}
echo substr($str,0,-1)."]";
	mysql_close($con);
?>