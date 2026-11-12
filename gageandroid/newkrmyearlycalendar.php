<?php
// include("connectsms.php");

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');

$strSQL= "SELECT holiday_date,to_date,reserved_holiday_title,status FROM calendar WHERE holiday_date LIKE '%".$_REQUEST['dat']."%' ORDER BY holiday_date";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	$expmonth=explode("-",$_REQUEST['dat']);
	$month = $expmonth[1];
	$year = $expmonth[0];
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
				$arrCol["holiday_date"]=date('Y-m-d', $time);
				$arrCol["reserved_holiday_title"]=date('D', $time);
				$arrCol["status"]='5';
				array_push($resultArray,$arrCol);
			}
		}
	}	
	echo json_encode($resultArray);
?>