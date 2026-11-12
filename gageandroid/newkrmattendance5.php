<?php
// session_start();
// echo $_SESSION['host'];
// include("connect.php"); 

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');




$student_id=$_REQUEST['student_id'];
$year=$_REQUEST['dat'];

$startingday=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$startingday_res=mysql_fetch_array($startingday);
$sexp=explode("-",$startingday_res['calendar_sdate']);
$eexp=explode("-",$startingday_res['calendar_edate']);
$ay=$sexp[0]."-".$eexp[0];	
	// 	$expmonth=explode("-",$_REQUEST['dat']);
	// $month = $expmonth[1];
	// $year = $expmonth[0];

// echo "SELECT * FROM student_attendance WHERE student_id='$student_id'  AND year='".$year."'";

$strSQL= "SELECT * FROM student_attendance WHERE student_id='$student_id'   AND academic_year='".$ay."' ";






$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			$arrCol["status1"]='0';
		}
		array_push($resultArray,$arrCol);
	}
	

	$fdate=$_REQUEST['dat']."-01";
	$lastday=date("t", strtotime($fdate));
	for($d=1; $d<=$lastday; $d++)
	{
		$time=mktime(12, 0, 0, $month, $d, $year);    
		if (date('m', $time)==$month) { 
			$date=date('Y-m-d:D', $time);
			$explode=explode(":",$date);
			if($explode[1]=="Sat" || $explode[1]=="Sun")
			{
				$arrCol["day"]=date('d', $time);
				$arrCol["date"]=date('Y-m-d', $time);
				$arrCol["reserved_holiday_title"]=date('D', $time);
				$arrCol["status"]='5';
				$arrCol["status1"]='R';
				array_push($resultArray,$arrCol);
			}
		}
	}



// Holidays

// echo "SELECT holiday_date FROM calendar WHERE status='2'  AND holiday_year LIKE '%".$year."%'";
        $calcount=mysql_query("SELECT holiday_date FROM calendar WHERE status='2'  AND holiday_year IN (".$sexp[0].",".$eexp[0].") ") or die(mysql_error());
        while($calcount_res=mysql_fetch_array($calcount)) {
        		$arrCol["day"]=date('d', strtotime($calcount_res["holiday_date"]));
				$arrCol["date"]=$calcount_res["holiday_date"]; 
				$arrCol["reserved_holiday_title"]=date('D', strtotime($calcount_res["holiday_date"]));
				$arrCol["status"]='2';
				$arrCol["status1"]='R';
				array_push($resultArray,$arrCol);
        }

        $bulk_leave = 0;
        $calcount1=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND holiday_year IN (".$sexp[0].",".$eexp[0].")  ")or die(mysql_error());
        while($rows1=mysql_fetch_array($calcount1)) {
            // if(explode("-",$rows1["from_date"])[0]."-".explode("-",$rows1["from_date"])[1] != $_REQUEST['dat']) {
            //     $rows1["from_date"]=$fdate;
            // }

            // if(explode("-",$rows1["to_date"])[0]."-".explode("-",$rows1["to_date"])[1] != $_REQUEST['dat']) { 
            //     $rows1["to_date"]=$_REQUEST['dat']."-31"; 
            // }
            	$period = new DatePeriod(
				    new DateTime($rows1["from_date"]),
				    new DateInterval('P1D'),
				    new DateTime($rows1["to_date"])+0
				);
				foreach($period as $date){
					// $arrCol["day"]=date('d', $date);
					$arrCol["date"]=$date->format("Y-m-d");
					$arrCol["reserved_holiday_title"]=date('D', $date->format("Y-m-d"));
					$arrCol["status"]='3';
					$arrCol["status1"]='R';
					array_push($resultArray,$arrCol);
				}

        }



	echo json_encode($resultArray);

?>