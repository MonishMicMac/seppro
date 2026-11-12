<?php
include("connect23.php"); 

$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$repid=$_REQUEST['repid'];
$wpdate=$year."-".$month."-";
$count=0;

$daysmit=0;





$start_date = "01-".$month."-".$year;
$start_time = strtotime($start_date);

$end_time = strtotime("+1 month", $start_time);

for($i=$start_time; $i<$end_time; $i+=86400)
{
   $list[] = date('Y-m-d', $i);

	$chk=mysql_query("SELECT COUNT(id) AS CNT FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate='".date('Y-m-d', $i)."'")or die(mysql_error());
	$chk_res=mysql_fetch_array($chk);

$tempDate = date('Y-m-d', $i);

if(date('l', strtotime( $tempDate))=='Sunday')
{
}
else
{
$daysmit++;
}

if($chk_res['CNT']=='1')
{

$count++;

}
	

}



if($daysmit==$count)
{
 $dayscnt='1';
}
else
{
 $dayscnt='0';
}




$doccnt=mysql_query("SELECT COUNT(id) AS DCNT FROM doctors WHERE rep_id='$repid'")or die(mysql_error());
$doccnt_res=mysql_fetch_array($doccnt);
$doccnt=$doccnt_res['DCNT']*2; 


$tblworkcnt=mysql_query("SELECT COUNT(wp_id) AS WPCNT FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_dc='D' AND wp_date LIKE '$wpdate%'")or die(mysql_error());
$tblworkcnt_res=mysql_fetch_array($tblworkcnt);


if($doccnt==$tblworkcnt_res['WPCNT'])
{$status='1';}
else{$status='0';}

echo '[{"days":"'.$dayscnt.'","doctor":"'.$status.'"}]';

?>