<?php

include("connect23.php"); 

$date=$_REQUEST['date'];




$strSQL = "SELECT id,corp_addr,corp_pin,alternate_no1,dis_name,IFNULL((select wp_date from tbl_work_plan where wp_date='$date' AND wp_dc='S' AND wp_dc_id=distributor.id ),'0') as wp_date FROM distributor";

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