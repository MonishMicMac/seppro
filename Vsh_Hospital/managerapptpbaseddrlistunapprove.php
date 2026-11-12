<?php

include("connect23.php"); 


$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$sa =  mysql_query("SELECT Group_concat(`repid`) as rep FROM `managerjoinworkplans` WHERE `date`='$date' and `managerid`=$pid")or die(mysql_error());
$data = mysql_fetch_array($sa);
$r=$data['rep'];

if($r!='')
{
$strSQL = "SELECT unapproveddoctors.id,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_qualification,unapproveddoctors.doc_specilist_id,unapproveddoctors.doctor_addrs,unapproveddoctors.doc_specific,unapproveddoctors.time_specific,representative.rep_name FROM unapproveddoctors,representative WHERE representative.id=unapproveddoctors.rep_assign AND unapproveddoctors.rep_assign IN ($r)";

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