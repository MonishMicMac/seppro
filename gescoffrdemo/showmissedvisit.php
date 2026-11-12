<?php
include("connect1.php");

$wp_rep_id=$_REQUEST['rep_id'];

$full_date=date("Y-m-d",strtotime($_REQUEST['date']));

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date=date("Y-m",strtotime($full_date));
$i=1;
$j=1;
while($i<=30){

$day=date("l",strtotime($date.'-'.$i));

if($j<=12 && $day!='Sunday'){

$auto_date=date("Y-m-d",strtotime($date.'-'.$i));
$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {
$v1_date=$auto_date;
$j++;
}
}


$i++;
}


$i1=date('d', strtotime($v1_date.' +1 day'));
$j1=1;
while($i1<=30){

$day1=date("l",strtotime($date.'-'.$i1));

if($j1<=12 && $day1!='Sunday'){

$auto_date1=date("Y-m-d",strtotime($date.'-'.$i1));
$jj1 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj1) == 0) {
$v2_date=$auto_date1;
$j1++;
}
}


$i1++;
}




$v1_first=date('Y-m', strtotime($full_date)).'-01';
$v1_last=$v1_date;

$v2_first=date('Y-m-d', strtotime($v1_last.' +1 day'));
$v2_last=date('Y-m', strtotime($full_date)).'-'.'26';




if (($full_date > $v1_first) && ($full_date < $v1_last)) {
    
$strSQL = "SELECT * FROM doctors WHERE rep_assign='$wp_rep_id' and id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$wp_rep_id' and wp_dc='D' and date(wp_date) between '$v1_first' and '$full_date' and attendancestatus='1' and drunavailable='0')";
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
	
	mysql_close($con);
	
	echo json_encode($resultArray);
    
} elseif (($full_date > $v2_first) && ($full_date < $v2_last)) {
    
$strSQL = "SELECT * FROM doctors WHERE rep_assign='$wp_rep_id' and id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$wp_rep_id' and wp_dc='D' and date(wp_date) between '$v2_first' and '$full_date' and attendancestatus='1' and drunavailable='0')";
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
	
	mysql_close($con);
	
	echo json_encode($resultArray);
    
} elseif(date("d",strtotime($full_date)) >= 26 && date("d",strtotime($full_date)) <= $no_of_days){

$cur_date=date("Y-m");

$strSQL = "SELECT * FROM doctors WHERE rep_assign='$wp_rep_id' and id in (select wp_dc_id from tbl_work_plan where wp_rep_id='$wp_rep_id' and wp_dc='D' and DATE_FORMAT(wp_date,'%Y-%m')='$cur_date' and wp_date!=curdate() and attendancestatus='0' and drunavailable='0') group by id";
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
	
	mysql_close($con);
	
	echo json_encode($resultArray);

} else {
    echo '[]';
}

?>