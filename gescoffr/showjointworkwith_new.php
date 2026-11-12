<?php
include("connect1.php");


$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];
$rep_id=$_REQUEST['rep_id'];




$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.promotion_service,tbl_work_plan.prescriptionvalue,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,tbl_work_plan.drunavailablereason,tbl_work_plan.leaveapprovedbymanager,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.promoted_products FROM tbl_work_plan,doctors WHERE tbl_work_plan.jointworkby='$wp_rep_id' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id'";

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

		if($obResult[11]!=''){
			$prom=explode(',',$obResult[11]); 
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



?>