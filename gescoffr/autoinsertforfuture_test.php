<?php

include("connect1.php");


$wp_date=$_REQUEST['wp_date'];



$add_date = strtotime(date("Y-m-d"));

$date=date("Y-m",strtotime("+1 month", $add_date));

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($date)),date("Y",strtotime($date)));

$wp_pin_id=$_REQUEST['wp_pin_id'];
$wp_dc=$_REQUEST['wp_dc'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

$UP=$_REQUEST['UP'];
$morningevening=$_REQUEST['morningevening'];


date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s');






if(date('d')>=27 && date('d')<=31 ){

	$proid = explode(",",$wp_dc_id);
	for($i=0;$i< count($proid);$i++)
	{
	$jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND wp_rep_id='$wp_rep_id' AND drunavailable = '0'")or die(mysql_error());
	$jj_count = mysql_num_rows($jj);
	if($jj_count == 0) {    
	mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date', '$c_time','$morningevening')")or die(mysql_error());
	}
	}


$added_date = date('Y-m-d', strtotime($wp_date.' +14 day'));

if(date('m', strtotime($added_date)) == date('m', strtotime($wp_date))){

$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$added_date' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {

	for($i=0;$i< count($proid);$i++)
	{
	$jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$added_date' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND wp_rep_id='$wp_rep_id' AND drunavailable = '0'")or die(mysql_error());
	$jj_count = mysql_num_rows($jj);
	if($jj_count == 0) {   
	
$sql=mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$wp_date' AND repid= '$wp_rep_id' AND expenses not in ('others','leave')")or die(mysql_error());
	$row=mysql_fetch_array($sql);
	if(mysql_num_rows($sql) > 0){
		$reason=$row['reason'];
		$expenses=$row['expenses'];
		
		$sql1=mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$added_date' AND repid= '$wp_rep_id'") or die(mysql_error());
		$row1=mysql_fetch_array($sql1);
		if(mysql_num_rows($sql1)==0){
		mysql_query("insert into repgivenasleave(repid,leaveapplieddate,date,time,reason,expenses) values('$wp_rep_id','$added_date','$c_date','$c_time','$reason','$expenses')");
		}
		
	}
	 
	mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$added_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date', '$c_time','$morningevening')")or die(mysql_error());
	}
	}

} else {
$added_date7 = date('Y-m-d', strtotime($added_date.' +7 day'));
if(date('m', strtotime($added_date7)) == date('m', strtotime($wp_date))){

	for($i=0;$i< count($proid);$i++)
	{
	$jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$added_date7' AND wp_dc = 'D' AND wp_dc_id = '$proid[$i]' AND wp_rep_id='$wp_rep_id' AND drunavailable = '0'")or die(mysql_error());
	$jj_count = mysql_num_rows($jj);
	if($jj_count == 0) {   
	
$sql=mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$wp_date' AND repid= '$wp_rep_id' AND expenses not in ('others','leave')")or die(mysql_error());
	$row=mysql_fetch_array($sql);
	if(mysql_num_rows($sql) > 0){
		$reason=$row['reason'];
		$expenses=$row['expenses'];
		
		$sql1=mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$added_date7' AND repid= '$wp_rep_id'") or die(mysql_error());
		$row1=mysql_fetch_array($sql1);
		if(mysql_num_rows($sql1)==0){
		mysql_query("insert into repgivenasleave(repid,leaveapplieddate,date,time,reason,expenses) values('$wp_rep_id','$added_date7','$c_date','$c_time','$reason','$expenses')");
		}
		
	}
	
	 
	mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$added_date7','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date', '$c_time','$morningevening')")or die(mysql_error());
	}
	}

}

}

} else {

}

}






?>