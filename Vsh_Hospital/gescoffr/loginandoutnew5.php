<?php

include("connect1.php");

$pid=$_REQUEST['pid'];


$date = $_REQUEST['date'];



/*$sqls=mysql_query("SELECT GROUP_CONCAT(DISTINCT  wp_rep_id) as pids FROM tbl_work_plan where wp_date='$date' ")or die(mysql_error());
$a=mysql_fetch_array($sqls);
$drcaall=$a['pids'];*/



$sqls1=mysql_query("SELECT GROUP_CONCAT(DISTINCT  repid) as pids FROM repgivenasleave where leaveapplieddate='$date' ")or die(mysql_error());
$a1=mysql_fetch_array($sqls1);
$drcaall1=$a1['pids'];

$strSQL = "SELECT rep_name,id FROM representative where id  IN ($drcaall1)";

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
// echo "SELECT TIME_FORMAT(repgivenasleave.login,'%h:%i:%s') AS login FROM repgivenasleave where  repid ='".$obResult['id']."' AND leaveapplieddate='$date' ";

			$inout=mysql_query("SELECT TIME_FORMAT(repgivenasleave.login,'%h:%i:%s') AS login FROM repgivenasleave where  repid ='".$obResult['id']."' AND leaveapplieddate='$date' AND login!='' ")or die(mysql_error());

if(mysql_num_rows($inout)>0)
{
	// echo "1";
	$inout_row=mysql_fetch_array($inout);	
	$login_time=$inout_row['login'];
//echo "SELECT MAX(reportedtime) AS logout,wp_rep_id FROM tbl_work_plan where wp_date=CURDATE() AND `reportedtime` != '00:00:00' AND wp_rep_id ='".$obResult['id']."'";
if($obResult['id']=='45' || $obResult['id']=='46' || $obResult['id']=='47' || $obResult['id']=='48' || $obResult['id']=='49' || $obResult['id']=='50' || $obResult['id']=='51' || $obResult['id']=='52' || $obResult['id']=='53' || $obResult['id']=='54' || $obResult['id']=='55' || $obResult['id']=='57' || $obResult['id']=='58')
{
	// echo '2';
$inout5=mysql_query("SELECT TIME_FORMAT(repgivenasleave.logoutbri,'%h:%i:%s') AS logout FROM repgivenasleave where  repid ='".$obResult['id']."' AND leaveapplieddate='$date' ")or die(mysql_error());
$inout_row5=mysql_fetch_array($inout5);	
$logout_time=$inout_row5['logout'];
}
else
{
	// echo '3';
	$inout5=mysql_query("SELECT TIME_FORMAT(MAX(reportedtime), '%r') AS logout,wp_rep_id FROM tbl_work_plan where wp_date='$date' AND `reportedtime` != '00:00:00' AND wp_rep_id NOT IN (45,46,47,48,49,50,51,52,53,54,55,57,58) AND wp_rep_id='".$obResult['id']."' ")or die(mysql_error());
$inout_row5=mysql_fetch_array($inout5);
$logout_time=$inout_row5['logout'];

}

}
else
{
	// echo "4";
		 $inout_tbl=mysql_query("SELECT MIN(reportedtime) AS minid , MAX(reportedtime) AS maxid,wp_rep_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($date))."' AND  `reportedtime` !=  '00:00:00' AND wp_rep_id ='".$obResult['id']."' ")or die(mysql_error());
            $inout_tbl_row=mysql_fetch_array($inout_tbl); 

            $login_time=$inout_tbl_row['minid'];	
$logout_time=$inout_tbl_row['maxid'];
}

$arrCol['login']=$login_time;	
$arrCol['logout']=$logout_time;
	
	
		array_push($resultArray,$arrCol);
	}


	mysql_close($con);
	
	echo json_encode($resultArray);
?>