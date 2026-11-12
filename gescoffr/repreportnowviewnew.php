<?php
include("connect1.php");

$doctorid=$_REQUEST['doctorid'];


$strSQL = "SELECT wp_id,wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time,attendancestatus,UP,reportstatus,latitude,longitude,areaname,reporteddate,reportedtime,leaveapprovedbymanager,morningevening,drunavailable,drunavailablereason,feedback,managerlat,managerlong,managerdate,managertime,managerstatus,manageridifavailable,visitedidfrommanager,jointworkby,jointworkapproval,managerattendanceid,multiplemanagerjointwork,multiplemanagerjointworkapproval,autodate,prescriptionvalue,promotion_service,promoted_products,productname FROM tbl_work_plan WHERE wp_dc_id='$doctorid' AND wp_dc='D' AND drunavailablereason!=''  ORDER BY wp_id DESC LIMIT 15";

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

$sql5=mysql_query("select GROUP_CONCAT(pro_name) AS pro_name5 from product where id IN (".$obResult['productname'].")");
			$row5=mysql_fetch_array($sql5);
$arrCol['promat_product'] = $row5['pro_name5'];

	$arrCol['group_and_product'] = rtrim($group_and_product,',');
	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);

?>