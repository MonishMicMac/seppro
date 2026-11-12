<?php
include("connect23.php"); 
$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];

$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
$rep_id = $jj_res['rep_id'];

$from=date('Y-m').'-01';
$to=date('Y-m-d');



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.visitcardclinicphoto,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

$objQuery = mysql_query($strSQL);
$intNumField = mysql_num_fields($objQuery);

$resultArray = array();
while($obResult = mysql_fetch_array($objQuery))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{

		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		$time_in_24_hour_format  = date("H:i:s", strtotime($obResult['reportedtime']));
		$arrCol["reportedtime24"] = $time_in_24_hour_format;
	
		$strSQL1 = "SELECT IFNULL((select rep_name from representative WHERE id IN (tbl_work_plan.jointworkby)),'INDU') AS repname,count(wp_id) AS id,GROUP_CONCAT(wp_dc_id) AS doc,min(reportedtime) AS fivisit,max(reportedtime) AS lastvisit,GROUP_CONCAT(tbl_work_plan.jointworkby) AS jointbynew,IFNULL((select COUNT(*) from tbl_work_plan WHERE mtp='1' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate'  AND drunavailable='0' AND attendancestatus='1'  GROUP BY wp_rep_id),'0') AS swp,IFNULL((select COUNT(*) from tbl_work_plan WHERE mtp='1' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1'  AND drunavailable='0' GROUP BY wp_rep_id),'0') AS swp_cov,IFNULL((SELECT COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1' AND (wp_date between '$from' and '$to') AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id HAVING D=1 ORDER BY wp_date DESC),'0') AS metonce,IFNULL((SELECT COUNT(wp_dc_id) AS D1 FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND (wp_date between '$from' and '$to') AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id HAVING D1>1 ORDER BY wp_date DESC),'0') AS mettwice FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

		$objQuery1 = mysql_query($strSQL1);
		$obResult1 = mysql_fetch_array($objQuery1);
		// echo "SELECT count(wp_dc_id) AS undoc FROM unapprovedtbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND reporteddate='$reporteddate' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";
				$strSQL5 = "SELECT count(wp_dc_id) AS undoc FROM unapprovedtbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

		$objQuery5 = mysql_query($strSQL5);
		$obResult5 = mysql_fetch_array($objQuery5);

		$SQL1=mysql_query("SELECT count(*) AS phone from doctors WHERE id IN (".$obResult1['doc'].") AND doc_contact_no!='' ");
		$num_rows1=mysql_fetch_array($SQL1);
		$SQL2=mysql_query("SELECT count(*) AS img from doctors WHERE id IN (".$obResult1['doc'].") AND visitcardclinicphoto=''");
		$num_rows2=mysql_fetch_array($SQL2);
	// 	$SQL3=mysql_query("SELECT (case  when id='0' then 'INDU' else rep_name end) as rep_name FROM representative WHERE id IN (".$obResult1['jointbynew'].")");
	// $num_rows3=mysql_num_rows($SQL3);
	// echo $num_rows3['img'];

		$arrCol["jwe"] = $obResult1['repname'];
		$arrCol["doccount"] = $obResult1['id'];
		$arrCol["fisrt"] = $obResult1['fivisit'];
		$arrCol["last"] = $obResult1['lastvisit'];
		$arrCol["swpcount"] = $obResult1['swp'];
		$arrCol["swpcoverage"] = $obResult1['swp_cov'];
		$arrCol["swpaverage"] = ($obResult1['swp_cov']/$arrCol["doccount"])*100;
		$arrCol["metonce"] = $obResult1['metonce'];
		$arrCol["mettwice"] = $obResult1['mettwice'];
		if($obResult5['undoc']=='null' || $obResult5['undoc']=='')
		{
			$arrCol["undrcount"]='0';
		}
		else
		{
		$arrCol["undrcount"] = $obResult5['undoc'];
	}
		$arrCol["phonecount"] = $num_rows1['phone'];
		$arrCol["imgcount"] = $num_rows2['img'];

	}
	array_push($resultArray,$arrCol);
}


mysql_close($con);

echo json_encode($resultArray);




?>