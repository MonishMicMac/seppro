<?php
include('connect.php');
if($_REQUEST['cmd']=='PEN'){$strSQL = "SELECT  * FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0'";}
if($_REQUEST['cmd']=='COM'){$strSQL = "SELECT  * FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1'";}
if($_REQUEST['cmd']=='EXP'){$strSQL = "SELECT  * FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<='".date('Y-m-d')."'";}

$lcount=mysql_query("SELECT COUNT(ts_id) AS L FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND priority='Low'")or die(mysql_error());
$lcount_res=mysql_fetch_array($lcount);
$lc=$lcount_res['L'];

$mcount=mysql_query("SELECT COUNT(ts_id) AS M FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND priority='Medium'")or die(mysql_error());
$mcount_res=mysql_fetch_array($mcount);
$mc=$mcount_res['M'];

$hcount=mysql_query("SELECT COUNT(ts_id) AS H FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND priority='High'")or die(mysql_error());
$hcount_res=mysql_fetch_array($hcount);
$hc=$hcount_res['H'];

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
                $arrCol['Low'] = $lc;
		$arrCol['Medium'] = $mc;
                $arrCol['High'] = $hc;
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


//$strSQL = "SELECT ts_id,taskname,taskdate,priority,definition,taskowner,tracker AS TRID,rep_name AS TNAME FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND mst_task_scheduling.tracker=representative.id";}

?>