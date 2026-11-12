<?php

include("connect2.php"); 

$doctorid=$_REQUEST['doctorid'];
$date=$_REQUEST['date'];

$add_date ="-".$date."-";



$strSQL = "SELECT * 
FROM tbl_work_plan
WHERE wp_rep_id=  '$doctorid' AND drunavailablereason!='' AND reporteddate LIKE '%$add_date%'  ORDER BY wp_id DESC LIMIT 45";





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