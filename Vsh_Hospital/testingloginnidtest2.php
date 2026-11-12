<?php
$user="root";
$pass="$3pp60@2016";
$database="zinnia";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

$imeino=$_REQUEST['rep_imeino'];

if($imeino !=''){
$sql = mysql_query("SELECT id FROM representative where rep_imeino='$imeino'");
$row=mysql_fetch_array($sql);
$rep_id=$row['id'];

date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d');


$full_date=date("Y-m-d",strtotime($date));

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date=date("Y-m",strtotime($full_date));

$i=1;
$j=0;
while($i<=31){

$day=date("l",strtotime($date.'-'.$i));

if($j<=$no_of_days && $day!='Sunday'){

 $auto_date=date("Y-m-d",strtotime($date.'-'.$i));
$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {

$month1=date("m",strtotime($date.'-'.$i));
$month2=date("m",strtotime($full_date));
if($month1==$month2){
$j++;
}

}
}
$i++;
}

 $j;
if ($j % 2 == 0) {
  $total=$j;
} else {
  $total=$j-1;
}

 $tot1=$total/2;

$i1=1;
$j1=1;
while($i1<=31){

$day1=date("l",strtotime($date.'-'.$i1));

if($j1<=$tot1 && $day1!='Sunday'){

$auto_date1=date("Y-m-d",strtotime($date.'-'.$i1));
$jj1 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj1) == 0) {
$v1_date=$auto_date1;
//echo $v1_date.'<br>';
$j1++;
}
}
$i1++;
}


$i2=date('d', strtotime($v1_date.' +1 day'));
$j2=1;
while($i2<=31){

$day2=date("l",strtotime($date.'-'.$i2));

if($j2<=$tot1+1 && $day2!='Sunday'){

$auto_date2=date("Y-m-d",strtotime($date.'-'.$i2));
$jj2 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date2' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj2) == 0) {
$v2_date=$auto_date2;
//echo $v2_date.'<br>';
$j2++;
}
}
$i2++;
}




$v1_first=date('Y-m', strtotime($full_date)).'-01';
$v1_last=$v1_date;

$v2_first=date('Y-m-d', strtotime($v1_last.' +1 day'));
$v2_last=$v2_date;




$cnt=mysql_query("select * from doctors where rep_assign='$rep_id'");
$total_cnt= mysql_num_rows($cnt);


if (($full_date >= $v1_first) && ($full_date <= $v1_last)) {

$v1=mysql_query("select * from doctors where id in (select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$full_date' and attendancestatus='1' and drunavailable='0')");
$v1_dr_list= mysql_num_rows($v1);

$dr_full_cnt=$total_cnt-$v1_dr_list;

} elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) {

$v2=mysql_query("select * from doctors where rep_assign='$rep_id' AND id in (select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$full_date' and attendancestatus='1' and drunavailable='0')");
$v2_dr_list= mysql_num_rows($v2);

$dr_full_cnt=$total_cnt-$v2_dr_list;
}


$strSQL = "SELECT id,rep_name,smsreportingnumber,welcomewishes,welcomeurl,welcomeclose,dateoftourplan,supportnumber,version,blockopeningmonth,playurl,(select count(*) from representative where rep_id>0) as count FROM representative where rep_imeino='$imeino'";

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
		$arrCol['v1'] = $v1_first;
		$arrCol['v2'] = $v2_first;
		$arrCol['dr_full_cnt'] = $dr_full_cnt;
		array_push($resultArray,$arrCol);
	}
	mysql_close($con);
	
	echo json_encode($resultArray);


} else {
echo '[]';
}



?>