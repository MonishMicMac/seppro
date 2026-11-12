<?php

include("connect1.php");


$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$sa =  mysql_query("SELECT Group_concat(`repid`) as rep FROM `managerjoinworkplans` WHERE `date`='$date' and `managerid`=$pid")or die(mysql_error());
$data = mysql_fetch_array($sa);
$r=$data['rep'];

if($r!='')
{
$strSQL = "SELECT doctors.id,doctors.doc_hospital_clinic_name,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.doctor_addrs,doctors.doc_specific,doctors.time_specific,representative.rep_name,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors,representative WHERE representative.id=doctors.rep_assign AND doctors.rep_assign IN ($r)";

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