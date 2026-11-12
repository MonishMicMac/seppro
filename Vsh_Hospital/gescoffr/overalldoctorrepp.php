<?php

include("connect1.php");

$pid=$_REQUEST['pid'];
$date=date('Y-m-d');


$sa =  mysql_query("SELECT Group_concat(`repid`) as rep FROM `managerjoinworkplans` WHERE `date`='$date' and `managerid`=$pid")or die(mysql_error());
$data = mysql_fetch_array($sa);
$r=$data['rep'];

if($r!='')
{




$strSQL = "SELECT id,doctor_name,rep_id,doc_pincode,doctor_addrs,doc_hospital_clinic_name FROM doctors WHERE rep_assign IN ($r)";



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
}
else
{
echo '[]';
}
?>