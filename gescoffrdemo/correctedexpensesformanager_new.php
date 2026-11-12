<?php
include("connect1.php");

$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];

$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
$rep_id = $jj_res['rep_id'];

if($rep_id == 0)
{

$strSQL = "SELECT * FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id";
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
		$group_and_product='';

		if($obResult[36]!=''){
			$prom=explode(',',$obResult[36]); 
			foreach ($prom as $prom_pro) {
				$pro=explode('/', $prom_pro);
				$sql=mysql_query("SELECT group_name,(select pro_name from product where id=product_grouping.slv_product) as product FROM product_grouping WHERE group_name='$pro[0]' AND slv_product='$pro[1]'");
				$row=mysql_fetch_array($sql);
				$group_and_product.=$row['group_name']."-".rtrim($row['product']).',';
			}
		}
		$arrCol['group_and_product'] = rtrim($group_and_product,',');
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
}
else
{
$strSQL = "SELECT * FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id";
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
		$group_and_product='';

		if($obResult[36]!=''){
			$prom=explode(',',$obResult[36]); 
			foreach ($prom as $prom_pro) {
				$pro=explode('/', $prom_pro);
				$sql=mysql_query("SELECT group_name,(select pro_name from product where id=product_grouping.slv_product) as product FROM product_grouping WHERE group_name='$pro[0]' AND slv_product='$pro[1]'");
				$row=mysql_fetch_array($sql);
				$group_and_product.=$row['group_name']."-".rtrim($row['product']).',';
			}
		}
		$arrCol['group_and_product'] = rtrim($group_and_product,',');
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
}


?>