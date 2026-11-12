<?php

include("connectsms.php");

// $con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
// mysql_select_db($_REQUEST['db'],$con);
// date_default_timezone_set('Asia/Calcutta');


$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
/*echo "SELECT day,(select sub_name from mst_sub where sub_id=time_table.subject) as subject,hours FROM time_table WHERE section_id='$section_id' AND standard_id='$standard_id'";
*/ $strSQL= "SELECT day,(select sub_name from mst_sub where sub_id=time_table.subject) as subject,hours FROM time_table WHERE section_id='$section_id' AND standard_id='$standard_id'";

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