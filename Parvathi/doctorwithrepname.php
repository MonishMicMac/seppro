<?php
include("connect23.php"); 


$pid=$_REQUEST['pid'];



$strSQL = "SELECT id,doctor_name,doc_pincode,doc_qualification,doc_specilist_id,doctor_addrs,(case when plotid>0 then (select rep_name from representative where id=doctors.plotid) else '' end) as rep_name FROM doctors  WHERE rep_assign='$pid' order by doctor_name ASC";



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