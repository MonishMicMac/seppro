<?php

include("connect1.php"); 

// $hos_id=$_REQUEST['hos_id'];
// $rep_id=$_REQUEST['rep_id'];
// $date=date('Y-m-d');


// echo "SELECT * from doctors WHERE rep_id='".$rep_id."' AND doc_hospital_clinic_name='".$hos_id."' ";

	$strSQL="SELECT * from purpose_of_visit WHERE status='1' ";



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