<?php
include("connectsms.php"); 

$section=$_REQUEST['section'];
$msg=$_REQUEST['msg'];
$staffid=$_REQUEST['staffid'];


$lid = $_REQUEST['lid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=$_REQUEST['cdate'];
$c_time=date("h:i:s A");

$section = str_replace('%20', ' ', $section);


$a=mysql_query("insert into tbl_bulksms_details(staff_name,bulksms_type,section,msg,bulksms_date,bulksms_time,staffid,status)values
('Sree Narayana Mission Senior Secondary School','HW','$section','$msg','$c_date','$c_time','$staffid','1')")or die(mysql_error());















$jjxx = "SELECT bulksms_id FROM tbl_bulksms_details WHERE section LIKE  '%".$ss."%' AND status='1' ANd section='$section' AND staffid='$staffid' AND bulksms_id>'$lid' ORDER BY bulksms_id ASC";


$objQuery = mysql_query($jjxx);
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









?>