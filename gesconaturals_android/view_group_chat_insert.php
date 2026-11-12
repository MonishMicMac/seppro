<?php

include("connect1.php");

// ee_user_id='".$_REQUEST['user_id']."' AND

$strSQL = "SELECT *,(select rep_name from representative where id=group_chat.gc_user_id) AS rep_name FROM  group_chat WHERE  gc_user_id IN (select gc_user_id from representative where id='".$_REQUEST['refid']."')  ";

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
