<?php
include("connect1.php");

$date = $_REQUEST['date'];

$strSQL = "SELECT rep_name,id FROM representative where id NOT  IN (SELECT GROUP_CONCAT(DISTINCT  wp_rep_id) as rep_id FROM `tbl_work_plan` WHERE wp_date='".$date."' AND attendancestatus=1 AND reportedtime BETWEEN '00:00:00' AND '12:00:00' ) AND adminon='0'";

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