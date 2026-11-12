<?php

include("connectsms.php");




$student_id=$_REQUEST['student_id'];

$startingday=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$startingday_res=mysql_fetch_array($startingday);
$sexp=explode("-",$startingday_res['calendar_sdate']);
$eexp=explode("-",$startingday_res['calendar_edate']);
$ay=$sexp[0]."-".$eexp[0];
///// Academic Year/////



$strSQL= "SELECT * FROM student_attendance WHERE student_id='$student_id' AND academic_year='".$ay."'";

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
//echo countDays(2013, 1, array(0, 6));
///// Counting Days/////

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];


			$absentdays=mysql_query("SELECT *,COUNT(*) AS S FROM student_attendance WHERE student_id='".$_REQUEST['student_id']."' AND academic_year='".$ay."' GROUP BY month")or die(mysql_error());
			$absentdays_res=mysql_fetch_array($absentdays);
				

	$calcount=mysql_query("SELECT COUNT(cal_id) AS C FROM calendar WHERE holiday_month='".$absentdays_res['month']."' AND (status='2' || status='3')")or die(mysql_error());
	$calcount_res=mysql_fetch_array($calcount);

		$totaldays=countDays(date('Y'), $absentdays_res['month'], array(0, 6))-$calcount_res['C'];
		$percentage=round(($absentdays_res['S']/$totaldays)*100);
		$present=$totaldays-$absentdays_res['S'];
		$arrCol['absmonthid'] = $absentdays_res['year']."-".$absentdays_res['month'];
		$arrCol['absmonthname'] = date("F", mktime(0, 0, 0, $absentdays_res["month"], 10));
		$arrCol['totaldays'] = $totaldays;
		$arrCol['absent'] = $absentdays_res['S'];
		$arrCol['present'] = $present;
		$arrCol['percentage'] = $percentage;
	
		}
		array_push($resultArray,$arrCol);
	}
	
	
	echo json_encode($resultArray);

?>