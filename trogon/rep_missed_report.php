<?php
include("connect23.php"); 

 

$repid=$_REQUEST['repid'];
 $current_month=date('Y-m-');


$strSQL = "SELECT * FROM tbl_work_plan WHERE wp_rep_id='$repid' AND `wp_date` LIKE  '%".$current_month."%' AND attendancestatus='0' ";





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