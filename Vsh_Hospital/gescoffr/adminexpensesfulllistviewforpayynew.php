<?php

include("connect1.php");


$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];





$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
 $rep_id = $jj_res['rep_id'];


$strSQL = "SELECT * FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
	if($obResult['productname']!='')
{
		$jj5 = mysql_query("SELECT GROUP_CONCAT(pro_name) AS pro_name1 FROM product WHERE id IN (".$obResult['productname'].") ")or die(mysql_error());
$jj_res5 = mysql_fetch_array($jj5);
$arrCol['promate'] = $jj_res5['pro_name1'];


}
else
{
$arrCol['promate'] = 'not promoted';
}
/*	if($obResult['competitorname']!='')
{
		$jj5 = mysql_query("SELECT GROUP_CONCAT(com_name) AS comepetitor FROM comepetitors WHERE c_id IN (".$obResult['competitorname'].") ")or die(mysql_error());
$jj_res5 = mysql_fetch_array($jj5);
$arrCol['com_name'] = $jj_res5['comepetitor'];


}
else
{
$arrCol['com_name'] = 'not comepetitor';
}
	*/

		for($i=0;$i<$intNumField;$i++)
		{
                
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
                 

		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


?>