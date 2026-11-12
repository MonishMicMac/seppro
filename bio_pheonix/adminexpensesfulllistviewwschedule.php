<?php

include("connect23.php");


$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];





$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
$rep_id = $jj_res['rep_id'];


$strSQL = "SELECT * FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate'  AND tbl_work_plan.wp_dc_id=doctors.id";
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