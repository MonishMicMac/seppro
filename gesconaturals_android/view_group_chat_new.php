<?php

include("connect1.php");

// ee_user_id='".$_REQUEST['user_id']."' AND

$sql5 = mysql_query("SELECT phoneid,id,rep_id FROM representative where id='".$_REQUEST['rep_id']."' ");
$row5=mysql_fetch_array($sql5);


if($row5['rep_id']!='0')
{
	$sql55 = mysql_query("SELECT CONCAT(GROUP_CONCAT(DISTINCT repid),',',".$_REQUEST['rep_id'].") AS repid FROM assigningreptomanager WHERE managerid='".$_REQUEST['rep_id']."'");
}
else
{
	$sql55 = mysql_query("SELECT CONCAT(GROUP_CONCAT(DISTINCT managerid),',',".$_REQUEST['rep_id'].") AS repid FROM assigningreptomanager WHERE repid='".$_REQUEST['rep_id']."'");
}
$row55=mysql_fetch_array($sql55);
$strSQL ="SELECT *,(SELECT rep_name FROM representative where id=group_chat.gc_user_id) AS repname FROM group_chat WHERE gc_user_id IN (".$row55['repid'].")";


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
