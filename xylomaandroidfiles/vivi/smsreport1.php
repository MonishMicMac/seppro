<?php

include("connectsms.php");
if($_REQUEST['staffid']!='')
{
$ss = $_REQUEST['ss'];

$staffid = $_REQUEST['staffid'];
$lid = $_REQUEST['lid'];

$ss = str_replace('%20', ' ', $ss);


$jjxx = "SELECT bulksms_id,bulksms_type,msg,bulksms_date,bulksms_time FROM tbl_bulksms_details WHERE section LIKE  '%".$ss."%' AND status='0' AND staffid='$staffid' AND bulksms_id>'$lid' ORDER BY bulksms_id ASC";


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
}
?>