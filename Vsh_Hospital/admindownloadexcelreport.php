<?php
include("connect23.php"); 
$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month; 

$jj =mysql_query("SELECT * FROM representative  WHERE id='$repid'")or die(mysql_error());
$jj_res = mysql_fetch_array($jj);

$rep_id = $jj_res['rep_id'];


if($rep_id == 0)
{

$strSQL = "SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.wp_rep_id='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id";
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


$strSQL = "SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.jointworkby='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id";

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


?>