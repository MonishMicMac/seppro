<?php

include("connect1.php");


// $wp_date=$_REQUEST['wp_date'];
// $wp_pin_id=$_REQUEST['wp_pin_id'];
// $wp_dc=$_REQUEST['wp_dc'];
// $wp_dc_id=$_REQUEST['wp_dc_id'];
$rep_id=$_REQUEST['wp_rep_id'];
$beatid=$_REQUEST['beatid'];
// 
// $UP=$_REQUEST['UP'];
// $morningevening=$_REQUEST['morningevening'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$wpdate=date('Y-m-d',strtotime($_REQUEST['datee']));

$c_time=date('h:i:s A');

// $proid = explode(",",$wp_dc_id);

// echo "SELECT * FROM  doctors WHERE doc_pincode IN (SELECT GROUP_CONCAT(DISTINCT pincode) AS pincode FROM Beatwiserep WHERE repid='$rep_id' AND beadid='$beatid') ";

// echo "SELECT GROUP_CONCAT(DISTINCT pincode) AS pincode FROM Beatwiserep WHERE repid IN (".$rep_id.") AND beadid IN (".$beatid.")";
$sql5=mysql_query("SELECT GROUP_CONCAT(DISTINCT pincode) AS pincode FROM Beatwiserep WHERE repid IN (".$rep_id.") AND beadid IN (".$beatid.")");
$row5=mysql_fetch_array($sql5);
// echo "SELECT * FROM  doctors WHERE doc_pincode IN (".$row5['pincode'].") GROUP BY id ASC ";
// exit();
$sql=mysql_query("SELECT * FROM  doctors WHERE doc_pincode IN (".$row5['pincode'].") AND rep_id IN (".$rep_id.") GROUP BY id ASC ");
while($row=mysql_fetch_array($sql)){
//echo "SELECT * FROM tbl_work_plan WHERE wp_date = '$c_date' AND wp_rep_id='$rep_id' AND wp_dc = 'D' AND wp_dc_id = '".$row['id']."' AND drunavailable = '0'";

	$jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wpdate' AND wp_rep_id='$rep_id' AND wp_dc = 'D' AND wp_dc_id = '".$row['id']."' AND drunavailable = '0'")or die(mysql_error());
	$jj_count = mysql_num_rows($jj);
	if($jj_count > 0)
	{



	}
	else
	{
		mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,beat_status,wp_pin_code)VALUES('$wpdate','0','D','".$row['id']."','".$row['rep_id']."','P','$c_date','$c_time','1','".$row['doc_pincode']."')")or die(mysql_error());
	}
}










?>
