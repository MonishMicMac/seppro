<?php

include("connect1.php");

$pid=$_REQUEST['pid'];


$date = $_REQUEST['date'];

$sqls5=mysql_query("SELECT GROUP_CONCAT(repid) as mpids FROM assigningreptomanager where managerid='$pid' ")or die(mysql_error());
$a5=mysql_fetch_array($sqls5);
$drcaall5=$a5['mpids'];
$sqls=mysql_query("SELECT GROUP_CONCAT(DISTINCT  wp_rep_id) as pids FROM tbl_work_plan where wp_date='$date' AND wp_rep_id IN ($drcaall5) ")or die(mysql_error());
$a=mysql_fetch_array($sqls);
$drcaall=$a['pids'];


$strSQL = "SELECT rep_name,id FROM representative where id  IN ($drcaall)";

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

			$inout=mysql_query("SELECT MIN(repgivenasleave.time) AS login FROM repgivenasleave where  repid ='".$obResult['id']."' ")or die(mysql_error());
$inout_row=mysql_fetch_array($inout);	
//echo "SELECT MAX(reportedtime) AS logout,wp_rep_id FROM tbl_work_plan where wp_date=CURDATE() AND `reportedtime` != '00:00:00' AND wp_rep_id ='".$obResult['id']."'";
$inout5=mysql_query("SELECT TIME_FORMAT(MAX(reportedtime), '%r') AS logout,wp_rep_id FROM tbl_work_plan where wp_date=CURDATE() AND `reportedtime` != '00:00:00' AND wp_rep_id='".$obResult['id']."' ")or die(mysql_error());
$inout_row5=mysql_fetch_array($inout5);

$arrCol['login']=$inout_row['login'];	
$arrCol['logout']=$inout_row5['logout'];
	
		array_push($resultArray,$arrCol);
	}


	mysql_close($con);
	
	echo json_encode($resultArray);
?>