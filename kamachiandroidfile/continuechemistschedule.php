<?php


include("connect2.php"); 
$repid=$_REQUEST['repid'];

$date = $_REQUEST['date'];

$dridd = $_REQUEST['dridd'];


$strSQL = mysql_query("SELECT tbl_doctor_chemist.doctor_id,tbl_doctor_chemist.chemist_id,tbl_customer_master.shop_name,tbl_customer_master.customer_address,tbl_customer_master.mobile_no,tbl_customer_master.pincode FROM tbl_doctor_chemist,tbl_customer_master WHERE tbl_doctor_chemist.rep_id='$repid' AND tbl_doctor_chemist.doctor_id='$dridd' AND tbl_customer_master.id=tbl_doctor_chemist.chemist_id AND tbl_customer_master.id NOT IN (SELECT GROUP_CONCAT(`wp_dc_id`) FROM `tbl_work_plan` WHERE `wp_date`='$date' AND `wp_dc`='C' AND `wp_rep_id`='$repid' AND `drunavailable`='0' GROUP BY `wp_dc_id`)")or die(mysql_error());






	$intNumField = mysql_num_fields($strSQL);
	$resultArray = array();
	while($obResult = mysql_fetch_array($strSQL))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($strSQL,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


	?>