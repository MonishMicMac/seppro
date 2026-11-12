<?php
include("connectsms.php");
///// Academic Year/////

function getWorkingDays($startDate, $endDate)
{
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {
      //  echo "startdate is in the future! <br />";

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


$yearMonth = $_REQUEST["month"];

$startingday=mysql_query("SELECT * FROM master_calendar WHERE '".$yearMonth."' BETWEEN DATE_FORMAT(calendar_sdate, '%Y-%m') AND DATE_FORMAT(calendar_edate, '%Y-%m') ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());

$startingday_res=mysql_fetch_array($startingday);
$sexp=explode("-",$startingday_res['calendar_sdate']);
$eexp=explode("-",$startingday_res['calendar_edate']);
$ay=$sexp[0]."-".$eexp[0];

// $ay = 2017-2018




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

$absentdays=mysql_query("SELECT *,COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['studentid']."' AND academic_year='".$ay."' AND month='".explode("-",$yearMonth)[1]."'")or die(mysql_error());
while($absentdays_res=mysql_fetch_array($absentdays))
	{
// echo $absentdays_res['month']."--".date('m')."<br>";
	if(explode("-",$yearMonth)[1]==date('m') && explode("-",$yearMonth)[0]==date('Y'))
	{ //echo "cur";
        /////// MONTH
        $sdate=date('Y-m')."-01";
        $beginday = date($sdate);
        $lastday  = date("Y-m-d");
        $nr_work_days = getWorkingDays($beginday, $lastday);


        $calcount=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_date BETWEEN '$sdate' AND '".date('Y-m-d')."' AND DAYNAME(holiday_date)!='Saturday' AND DAYNAME(holiday_date)!='Sunday'")or die(mysql_error());
        $calcount_res=mysql_num_rows($calcount);

        $holidays_to_check=array();
        while($rows098=mysql_fetch_array($calcount)) {
            $holidays_to_check[] = $rows098["holiday_date"];
        }

        $bulk_leave = 0;

        $leave_to_add = 0;

        $calcount1=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND '".$yearMonth."' BETWEEN DATE_FORMAT(holiday_date, '%Y-%m') AND DATE_FORMAT(to_date, '%Y-%m')")or die(mysql_error());

        while($rows1=mysql_fetch_array($calcount1)) {
            if(strtotime($rows1["from_date"]) < strtotime($sdate)) { 
                $rows1["from_date"]=$sdate;  
            }

            if(strtotime($rows1["to_date"]) > strtotime(date("Y-m-d"))) { 
                $rows1["to_date"]=date("Y-m-d"); 
            }

            foreach ( $holidays_to_check as $key => $value ) :
                if(strtotime($value)>=strtotime($rows1["from_date"]) && strtotime($value)<=strtotime($rows1["to_date"]))
                    $leave_to_add++;
            endforeach;

            $bulk_leave += getWorkingDays($rows1["from_date"], $rows1["to_date"]);
        }

        if(!@($calcount_res)) {
            $calcount_res = 0;
        }
        // echo $nr_work_days;
        $totaldays=$nr_work_days-$calcount_res-$bulk_leave+$leave_to_add;
        $present=$totaldays-$absentdays_res['S'];
        $percentage=round(($present/$totaldays)*100);


        /////// YEAR
		$sdate3=$startingday_res['calendar_sdate'];
		$beginday3 = date($sdate3);
		$lastday3  = date("Y-m-d");
		$nr_work_days3 = getWorkingDays($beginday3, $lastday3);

        $calcount3=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_date BETWEEN '$sdate3' AND '".date('Y-m-d')."' AND DAYNAME(holiday_date)!='Saturday' AND DAYNAME(holiday_date)!='Sunday'")or die(mysql_error());
        $calcount_res3=mysql_num_rows($calcount3);

        $holidays_to_check3=array();
        while($rows098=mysql_fetch_array($calcount3)) {
            $holidays_to_check3[] = $rows098["holiday_date"];
        }

        $bulk_leave3 = 0;

        $leave_to_add = 0;

		$calcount13=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND (holiday_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".date('Y-m-d')."', '%Y') OR to_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".date('Y-m-d')."', '%Y'))") or die(mysql_error());
		while($rows13=mysql_fetch_array($calcount13)) {
            if(strtotime($rows13["from_date"])<strtotime($sdate3)) $rows13["from_date"]=$sdate3;
                if(strtotime($rows13["to_date"])>strtotime(date("Y-m-d"))) $rows13["to_date"]=date("Y-m-d");

            foreach ( $holidays_to_check3 as $key => $value ) :
                if(strtotime($value)>=strtotime($rows13["from_date"]) && strtotime($value)<=strtotime($rows13["to_date"]))
                    $leave_to_add++;
            endforeach;

            $bulk_leave3 += getWorkingDays($rows13["from_date"], $rows13["to_date"]);
        }

        $absentdays3=mysql_query("SELECT COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['studentid']."' AND academic_year='".$ay."'")or die(mysql_error());

        while($absentdays_res3=mysql_fetch_array($absentdays3))
        {
            $year_abs = $absentdays_res3['S'];
        }

        if(!@($calcount_res3)) {
            $calcount_res3 = 0;
        }

		$totaldays3=$nr_work_days3-$calcount_res3-$bulk_leave3+$leave_to_add;
		$overall_present=$totaldays3-$year_abs;
		$overall_percentage=round(($overall_present/$totaldays3)*100);

		$str.='{"studentid":"'.$_REQUEST['studentid'].'","absmonthid":"'.$yearMonth.'","absmonthname":"'.date("F", mktime(0, 0, 0, explode("-",$yearMonth)[1], 10)).'","totaldays":"'.$totaldays.'","absent":"'.$absentdays_res['S'].'","present":"'.$present.'","percentage":"'.$percentage.'","overall_present":"'.$overall_present.'/'.$totaldays3.'","overall_percentage":"'.$overall_percentage.'"}';
	}
	else
	{







        $sdate=$yearMonth."-01";
        $beginday = date($sdate);
        $lastday  = $yearMonth."-31";

        $calcount=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_month='".explode("-",$yearMonth)[1]."' AND holiday_year='".explode("-",$yearMonth)[0]."' AND DAYNAME(holiday_date)!='Saturday' AND DAYNAME(holiday_date)!='Sunday'") or die(mysql_error());
        $calcount_res=mysql_num_rows($calcount);

        $holidays_to_check=array();
        while($rows098=mysql_fetch_array($calcount)) {
            $holidays_to_check[] = $rows098["holiday_date"];
        }

        $bulk_leave = 0;

        $leave_to_add = 0;
        $calcount1=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND '".$yearMonth."' BETWEEN DATE_FORMAT(holiday_date, '%Y-%m') AND DATE_FORMAT(to_date, '%Y-%m')")or die(mysql_error());
        while($rows1=mysql_fetch_array($calcount1)) {
            if(strtotime($rows1["from_date"])<strtotime($sdate)) $rows1["from_date"]=$sdate;
                if(strtotime($rows1["to_date"])>strtotime($lastday)) $rows1["to_date"]=$lastday;

            foreach ( $holidays_to_check as $key => $value ) :
                if(strtotime($value)>=strtotime($rows1["from_date"]) && strtotime($value)<=strtotime($rows1["to_date"]))
                    $leave_to_add++;
            endforeach;

            $bulk_leave += getWorkingDays($rows1["from_date"], $rows1["to_date"]);
        }

        if(!@($calcount_res)) {
            $calcount_res = 0;
        }

        $totaldays=countDays(date('Y'), explode("-",$yearMonth)[1], array(0, 6))-$calcount_res-$bulk_leave+$leave_to_add;
		$present=$totaldays-$absentdays_res['S'];
		$percentage=round(($present/$totaldays)*100);





    if(explode("-",$yearMonth)[0]>=date('Y') && strtotime($startingday_res['calendar_edate'])>strtotime(date('Y-m-d'))) {

        $sdate3=$startingday_res['calendar_sdate'];
        $beginday3 = date($sdate3);
        $lastday3  = date("Y-m-d");
        
        $nr_work_days3 = getWorkingDays($beginday3, $lastday3);

        $calcount3=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_date BETWEEN '$sdate3' AND '".$lastday3."' AND DAYNAME(holiday_date)!='Saturday' AND DAYNAME(holiday_date)!='Sunday'") or die(mysql_error());
        $calcount_res3=mysql_num_rows($calcount3);

        $holidays_to_check3=array();
        while($rows098=mysql_fetch_array($calcount3)) {
            $holidays_to_check3[] = $rows098["holiday_date"];
        }

        $bulk_leave3 = 0;

        $leave_to_add = 0;
        $calcount13=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND (holiday_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".$lastday3."', '%Y') OR to_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".$lastday3."', '%Y'))") or die(mysql_error());
        while($rows13=mysql_fetch_array($calcount13)) {
            if(strtotime($rows13["from_date"])<strtotime($sdate3)) $rows13["from_date"]=$sdate3;
                if(strtotime($rows13["to_date"])>strtotime($lastday3)) $rows13["to_date"]=$lastday3;

            foreach ( $holidays_to_check3 as $key => $value ) :
                if(strtotime($value)>=strtotime($rows13["from_date"]) && strtotime($value)<=strtotime($rows13["to_date"]))
                    $leave_to_add++;
            endforeach;

            $bulk_leave3 += getWorkingDays($rows13["from_date"], $rows13["to_date"]);
        }

        $absentdays3=mysql_query("SELECT COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['studentid']."' AND academic_year='".$ay."'")or die(mysql_error());
        while($absentdays_res3=mysql_fetch_array($absentdays3))
        {
            $year_abs = $absentdays_res3['S'];
        }

        $totaldays3=$nr_work_days3-$calcount_res3-$bulk_leave3+$leave_to_add;
        $overall_present=$totaldays3-$year_abs;
        $overall_percentage=round(($overall_present/$totaldays3)*100);

    } else {

        /////// YEAR
        $sdate3=$startingday_res['calendar_sdate'];
        $beginday3 = date($sdate3);
        $lastday3  = $startingday_res['calendar_edate'];
        
        $nr_work_days3 = getWorkingDays($beginday3, $lastday3);

        $calcount3=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_date BETWEEN '$sdate3' AND '".$lastday3."' AND DAYNAME(holiday_date)!='Saturday' AND DAYNAME(holiday_date)!='Sunday'") or die(mysql_error());

        $calcount_res3=mysql_num_rows($calcount3);

        $holidays_to_check3=array();
        while($rows098=mysql_fetch_array($calcount3)) {
            $holidays_to_check3[] = $rows098["holiday_date"];
        }

        $bulk_leave3 = 0;

        $leave_to_add = 0;

        $calcount13=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND (holiday_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".$lastday3."', '%Y') OR to_date BETWEEN DATE_FORMAT('".$sdate3."', '%Y') AND DATE_FORMAT('".$lastday3."', '%Y'))") or die(mysql_error());
        while($rows13=mysql_fetch_array($calcount13)) {
            if(strtotime($rows13["from_date"])<strtotime($sdate3)) $rows13["from_date"]=$sdate3;
                if(strtotime($rows13["to_date"])>strtotime($lastday3)) $rows13["to_date"]=$lastday3;

            foreach ( $holidays_to_check3 as $key => $value ) :
                if(strtotime($value)>=strtotime($rows13["from_date"]) && strtotime($value)<=strtotime($rows13["to_date"]))
                    $leave_to_add++;
            endforeach;

            $bulk_leave3 += getWorkingDays($rows13["from_date"], $rows13["to_date"]);
        }

        $absentdays3=mysql_query("SELECT COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['studentid']."' AND academic_year='".$ay."'")or die(mysql_error());
        while($absentdays_res3=mysql_fetch_array($absentdays3))
        {
            $year_abs = $absentdays_res3['S'];
        }

        $totaldays3=$nr_work_days3-$calcount_res3-$bulk_leave3+$leave_to_add;
        $overall_present=$totaldays3-$year_abs;
        $overall_percentage=round(($overall_present/$totaldays3)*100);
    }



		$str.='{"studentid":"'.$_REQUEST['studentid'].'","absmonthid":"'.$yearMonth.'","absmonthname":"'.date("F", mktime(0, 0, 0, explode("-",$yearMonth)[1], 10)).'","totaldays":"'.$totaldays.'","absent":"'.$absentdays_res['S'].'","present":"'.$present.'","percentage":"'.$percentage.'","overall_present":"'.$overall_present.'/'.$totaldays3.'","overall_percentage":"'.$overall_percentage.'"}';
	}

	}
echo $str."]";
	mysql_close($con);
?>