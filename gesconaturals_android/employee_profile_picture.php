<?php
include("connect1.php");
$managerid=$_REQUEST['managerid'];
$strSQL = "SELECT id, rep_name, image, mobile FROM representative WHERE id IN (select repid from assigningreptomanager where managerid='$managerid') AND rep_name!='' AND adminstatus!='1'";

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