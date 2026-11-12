<?php

 include("connectsms.php");

//$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
//mysql_select_db($_REQUEST['db'],$con);
//date_default_timezone_set('Asia/Calcutta');


/*if($_REQUEST['staffid']!='')
{*/
$ss = $_REQUEST['ss'];

//$staffid = $_REQUEST['staffid'];
$lid = $_REQUEST['lid'];

$ss = str_replace('%20', ' ', $ss);
	$expmonth=explode("-",$_REQUEST['dat']);
	// $date = $expmonth[2];
	// $month = $expmonth[1];
	// $year = $expmonth[0];
	// $bdate=$month."-".$date;
 $jjxx = "SELECT bulksms_id,bulksms_type,msg,bulksms_date,bulksms_time,section FROM tbl_bulksms_details WHERE section LIKE  '%".$ss."%' AND status='1' AND bulksms_date ='".$_REQUEST['dat']."' AND bulksms_id>'$lid' ORDER BY bulksms_id ASC";
//AND staffid='$staffid'  


$objQuery = mysql_query($jjxx);

	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			$arrCol["status"]='0';
		}
		array_push($resultArray,$arrCol);
	}


	

		

/*	$fdate=$_REQUEST['dat']."-01";
	$lastday=date("t", strtotime($fdate));
	for($d=1; $d<=$lastday; $d++)
	{
		$time=mktime(12, 0, 0, $month, $d, $year);    
		if (date('m', $time)==$month) { 
			$date=date('Y-m-d:D', $time);
			$explode=explode(":",$date);
			if($explode[1]=="Sat" || $explode[1]=="Sun")
			{
				$arrCol["holiday_date"]=date('Y-m-d', $time);
				$arrCol["bulksms_date"]=date('Y-m-d', $time);
				$arrCol["reserved_holiday_title"]=date('D', $time);
				$arrCol["status"]='5';
				$arrCol["msg"]='';
				array_push($resultArray,$arrCol);
			}
		}
	}
*/

// Holidays

       /* $calcount=mysql_query("SELECT holiday_date FROM calendar WHERE status='2' AND holiday_month='".explode("-",$_REQUEST['dat'])[1]."' AND holiday_year='".explode("-",$_REQUEST['dat'])[0]."'") or die(mysql_error());
        while($calcount_res=mysql_fetch_array($calcount)) {

				$arrCol["holiday_date"]=$calcount_res["holiday_date"]; 
				$arrCol["bulksms_date"]=$calcount_res["holiday_date"];
				$arrCol["reserved_holiday_title"]=date('D', $calcount_res["holiday_date"]);
				$arrCol["status"]='2';
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
				    new DateTime($rows1["to_date"])
				);
				foreach($period as $date){

					$arrCol["holiday_date"]=$date->format("Y-m-d");
					$arrCol["bulksms_date"]=$date->format("Y-m-d");
					$arrCol["reserved_holiday_title"]=date('D', $date->format("Y-m-d"));
					$arrCol["status"]='3';
					array_push($resultArray,$arrCol);
				}

        }*/
		//$evnt = "SELECT reserved_holiday_title,holiday_date,to_date FROM calendar WHERE holiday_month='".$month."' AND holiday_year='".$year."'";
			/*$objQuery = mysql_query($evnt);
			$obResult = mysql_fetch_array($objQuery)
			$arrCol["reserved_holiday_title"]=$obResult['reserved_holiday_title'];
			$arrCol["holiday_date"]=$obResult['holiday_date'];
			$arrCol["to_date"]=$obResult['to_date'];*/
	/*		$objQuery = mysql_query($evnt);
	$intNumField = mysql_num_fields($objQuery);
	//$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			$arrCol["bulksms_date"]=$obResult['holiday_date'];
			//$arrCol["bulksms_date"]=$obResult['to_date'];
			$arrCol["status"]='5';
		}
		array_push($resultArray,$arrCol);
	}*/
	
	mysql_close($con);
	
	echo json_encode($resultArray);
//}
?>
