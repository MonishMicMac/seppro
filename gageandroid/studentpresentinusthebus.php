<?php

include("../includes/connect_db.php");



$bus_id=$_REQUEST['bus_id'];


$strSQL = "SELECT * FROM  student_profile WHERE bus_id = ".$_REQUEST['bus_id']." and stu_id NOT IN (SELECT stu_id FROM  tbl_transport_history WHERE stu_pd_datetime = '".date("Y-m-d")."')";

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