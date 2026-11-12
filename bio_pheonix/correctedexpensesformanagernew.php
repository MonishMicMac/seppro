<?php
include("connect23.php"); 

$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];

echo '[';


$strSQL = "SELECT * FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";
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
	
	
	
	if(strlen(json_encode($resultArray))<='2')
{
}
else
{
 

echo $rest = substr(json_encode($resultArray), 1, -1);
}



$strSQL1 = "SELECT * FROM unapprovedtbl_work_plan,unapproveddoctors WHERE unapprovedtbl_work_plan.wp_rep_id='$wp_rep_id' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.wp_date='$reporteddate' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id ORDER BY STR_TO_DATE(unapprovedtbl_work_plan.reportedtime,'%h:%i:%s  %p')";
$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
                 

		array_push($resultArray1,$arrCol);
	}

	
		
	

if(strlen(json_encode($resultArray1))<='2')
{
echo ']';
}
else
{
 if(strlen(json_encode($resultArray))<='2')
{
}
else
{
echo ',';
}

echo $rest = substr(json_encode($resultArray1), 1, -1).']';
}


?>