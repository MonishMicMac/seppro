<?php

include("connect1.php"); 

// $status=$_REQUEST['status'];
$rep_id=$_REQUEST['rep_id'];
// $date=date('Y-m-d');


// echo "SELECT *,IFNULL((select main_cat from mst_category WHERE mst_category.category_id=Hospitalname.hos_category),'PRIVATE') AS  catname from Hospitalname WHERE rep_id='".$rep_id."'";

	$strSQL="SELECT *,IFNULL((select main_cat from mst_category WHERE mst_category.category_id=Hospitalname.hos_category),'PRIVATE') AS  catname from Hospitalname WHERE rep_id='".$rep_id."'";



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