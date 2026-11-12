<?php

include("connect1.php");

$pid=$_REQUEST['pid'];







$strSQL = "SELECT *,(select hos_name from Hospitalname WHERE Hospitalname.id=doctors.doc_hospital_clinic_name) AS  hospital_id FROM doctors WHERE rep_assign='$pid'";



$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
			if($obResult['com_name']!='')
		{
		$jj5 = mysql_query("SELECT GROUP_CONCAT(com_name) AS comptor FROM comepetitors WHERE c_id IN (".$obResult['com_name'].") ")or die(mysql_error());
$jj_res5 = mysql_fetch_array($jj5);
$arrCol['compitator'] = $jj_res5['comptor'];
}
else
{
	$arrCol['compitator'] = "No competitor";
}
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>