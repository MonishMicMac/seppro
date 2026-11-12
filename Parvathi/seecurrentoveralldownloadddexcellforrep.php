<?php

include("connect1.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year.'-'.$month;
$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];


$strSQL = "SELECT favourite,doc_pin_id,doc_contact_no,doctor_addrs,doc_specilist_id,drorchemist,doc_qualification,doc_pincode,doctor_name,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as days FROM doctors WHERE rep_id='$repid'  ";





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

                $sql=mysql_query("SELECT GROUP_CONCAT(area_name) as area_name FROM pincode_list where pin_id=".$arrCol['doc_pin_id']."");
		
$row=mysql_fetch_array($sql);
		$arrCol['area_name']=$row['area_name'];


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>