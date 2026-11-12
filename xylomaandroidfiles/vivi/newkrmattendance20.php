<?php
session_start();
// echo $_SESSION['host'];
include("connect.php"); 




$student_id=$_REQUEST['student_id'];

$year=$_REQUEST['dat'];
		/*$expmonth=explode("-",$_REQUEST['dat']);
	$month = $expmonth[1];
	$year = $expmonth[0];*/
$pervdate = date("Y");
 $curdate = date("Y-m-01", strtotime("-3 months"));

$strSQL= "SELECT * FROM student_attendance WHERE student_id='$student_id'  AND year='".$year."'";






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

        $calcount=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_month='".explode("-",$_REQUEST['dat'])[1]."' AND holiday_year='".explode("-",$_REQUEST['dat'])[0]."'") or die(mysql_error());
        while($calcount_res=mysql_fetch_array($calcount)) {

				$arrCol["date"]=$calcount_res["holiday_date"]; 
				$arrCol["reserved_holiday_title"]=date('D', $calcount_res["holiday_date"]);
				$arrCol["status"]='2';
				$arrCol["status1"]='R';
				array_push($resultArray,$arrCol);
        }

        $bulk_leave = 0;
        $calcount1=mysql_query("SELECT holiday_date as from_date, to_date FROM calendar WHERE status='3' AND '".$_REQUEST['dat']."' BETWEEN DATE_FORMAT(holiday_date, '%Y-%m') AND DATE_FORMAT(to_date, '%Y-%m')")or die(mysql_error());
        while($rows1=mysql_fetch_array($calcount1)) {
            if(explode("-",$rows1["from_date"])[0]."-".explode("-",$rows1["from_date"])[1] != $_REQUEST['dat']) {
                $rows1["from_date"]=$fdate;
            }

            if(explode("-",$rows1["to_date"])[0]."-".explode("-",$rows1["to_date"])[1] != $_REQUEST['dat']) { 
                $rows1["to_date"]=$_REQUEST['dat']."-31"; 
            }
            	$period = new DatePeriod(
				    new DateTime($rows1["from_date"]),
				    new DateInterval('P1D'),
				    new DateTime($rows1["to_date"])+0
				);
				foreach($period as $date){

					$arrCol["date"]=$date->format("Y-m-d");
					$arrCol["reserved_holiday_title"]=date('D', $date->format("Y-m-d"));
					$arrCol["status"]='3';
					$arrCol["status1"]='R';
					array_push($resultArray,$arrCol);
				}

        }



	echo json_encode($resultArray);

?>