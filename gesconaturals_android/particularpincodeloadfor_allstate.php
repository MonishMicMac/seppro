<?php

include("connect1.php"); 

define('WP_MEMORY_LIMIT', '2048M');

/*$rep_id=$_REQUEST['rep_id'];

	$jjreprmgr = mysql_query("SELECT stateid FROM representative WHERE id='$rep_id'")or die(mysql_error());


	$jjreprmgr_res = mysql_fetch_array($jjreprmgr);

	$fgh=$jjreprmgr_res['stateid'];

*/
$fgh=$_REQUEST['state_id'];
$strSQL = "SELECT DISTINCT master_pincode.pin_id,master_pincode.pincode FROM master_pincode WHERE state_id='$fgh'";

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
?>