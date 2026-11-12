<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
 $date=$_REQUEST['date'];










 




  $strSQL = "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";




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