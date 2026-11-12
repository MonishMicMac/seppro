<?php

include("connect23.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year.'-'.$month;
$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];


$strSQL = mysql_query("SELECT IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,favourite,doc_contact_no,dr_latitude,dr_longitude,visitcardclinicphoto,dob,anniversary,doctor_name,doc_specilist_id,(SELECT concat((case when group_concat(latitude)!='' then group_concat(latitude) else '0' end),' - ',(case when group_concat(longitude)!='' then group_concat(longitude) else '0' end)) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and wp_rep_id='$repid' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as lat_lon,doc_qualification,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and wp_rep_id='$repid' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as days FROM doctors WHERE rep_id='$repid'")or die(mysql_error());



$intNumField = mysql_num_fields($strSQL);
	$resultArray = array();
	while($obResult = mysql_fetch_array($strSQL))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($strSQL,$i)] = $obResult[$i];
		}
		$lat_long=explode(' - ',$arrCol['lat_lon']);
		
		$arrCol['lat']=$lat_long[0];
		$arrCol['lon']=$lat_long[1];
		unset($arrCol['lat_lon']);
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>