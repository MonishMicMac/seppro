<?php


include("connect1.php");

$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month; 





$erql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($erql);
$reid=$row['rep_id'];




$strSQL = "SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,tbl_customer_master.shop_name,tbl_customer_master.pincode,tbl_customer_master.mobile_no,tbl_customer_master.customer_address,IFNULL((select area_name from pincode_list where pincode=tbl_customer_master.pincode order by id asc limit 1),'No area name') as area_name FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc='C' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.wp_rep_id='$repid'  AND tbl_customer_master.id=tbl_work_plan.wp_dc_id order by tbl_work_plan.wp_date asc";

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