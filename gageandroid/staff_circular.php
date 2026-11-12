<?php
include("connectsms.php");
if($_REQUEST['GAGE']=='cirview')
{
	if($_REQUEST['mode']=='ALL')
	{
		$cirview="SELECT * FROM staff_circular ORDER BY cir_id DESC";
	}
	if($_REQUEST['mode']=='SPEC')
	{
		$cirview="SELECT * FROM `staff_circular` WHERE concat(',',`circular_staff_ids`) LIKE '%,".$_REQUEST['sid'].",%'ORDER BY cir_id DESC";
	}
	
	$objQuery = mysql_query($cirview);
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