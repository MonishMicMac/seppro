<?php
include("connect23.php"); 
$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];
$start_date=date("Y-m",strtotime($_REQUEST["reporteddate"]))."-01";

$sql1=mysql_query("SELECT reportedtime FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1' ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s %p') ASC LIMIT 1");
$result1=mysql_fetch_array($sql1);

$sql2=mysql_query("SELECT reportedtime FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1' ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s %p') DESC LIMIT 1");
$result2=mysql_fetch_array($sql2);

$start_time=$result1['reportedtime'];
$end_time=$result2['reportedtime'];

$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
$rep_id = $jj_res['rep_id'];


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
		$arrCol["reportedtime"] = $time_in_24_hour_format;
		
		$strSQL1 = "SELECT IFNULL((select rep_name from representative WHERE id IN (tbl_work_plan.jointworkby)),'INDU') AS repname,count(wp_id) AS id,GROUP_CONCAT(wp_dc_id) AS doc,min(reportedtime) AS lastvisit,max(reportedtime) AS fivisit,GROUP_CONCAT(tbl_work_plan.jointworkby) AS jointbynew,IFNULL((select COUNT(*) from tbl_work_plan WHERE mtp='1' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate'  AND drunavailable='0' AND attendancestatus='1' GROUP BY wp_rep_id),'0') AS swp,IFNULL((select COUNT(*) from tbl_work_plan WHERE mtp='1' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1'  AND drunavailable='0' GROUP BY wp_rep_id),'0') AS swp_cov FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

		$objQuery1 = mysql_query($strSQL1);
		$obResult1 = mysql_fetch_array($objQuery1);
		// echo "SELECT count(wp_dc_id) AS undoc FROM unapprovedtbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND reporteddate='$reporteddate' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";
		$strSQL5 = "SELECT count(wp_dc_id) AS undoc FROM unapprovedtbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='$reporteddate' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_rep_id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

		// IFNULL((SELECT COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1' AND wp_date='".$reporteddate."' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING D=1 ORDER BY wp_date DESC),'0') AS metonce,IFNULL((SELECT COUNT(wp_dc_id) AS D1 FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND wp_date='".$reporteddate."' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING D1>1 ORDER BY wp_date DESC),'0') AS mettwice

		$objQuery5 = mysql_query($strSQL5);
		$obResult5 = mysql_fetch_array($objQuery5);
		$SQL1new=mysql_query("SELECT COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1' AND wp_date='".$_REQUEST["reporteddate"]."' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING D=1 ORDER BY wp_date DESC");
		$SQL1new_rows=mysql_num_rows($SQL1new);
			$SQL1new5=mysql_query("SELECT COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE  wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1' AND wp_date='".$_REQUEST["reporteddate"]."' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING D>1 ORDER BY wp_date DESC");
		$SQL1new_rows5=mysql_num_rows($SQL1new5);

		$SQL1=mysql_query("SELECT count(*) AS phone from doctors WHERE id IN (".$obResult1['doc'].") AND doc_contact_no!='' ");
		$num_rows1=mysql_fetch_array($SQL1);
		$SQL2=mysql_query("SELECT count(*) AS img from doctors WHERE id IN (".$obResult1['doc'].") AND visitcardclinicphoto=''");
		$num_rows2=mysql_fetch_array($SQL2);
		$SQL2new=mysql_query("SELECT count(*) AS fav from doctors WHERE id IN (".$obResult1['doc'].") AND favourite='1'");
		$num_rows2new=mysql_fetch_array($SQL2new);
	// 	$SQL3=mysql_query("SELECT (case  when id='0' then 'INDU' else rep_name end) as rep_name FROM representative WHERE id IN (".$obResult1['jointbynew'].")");
	// $num_rows3=mysql_num_rows($SQL3);
	// echo $num_rows3['img'];

		$arrCol["jwe"] = $obResult1['repname'];
		$arrCol["doccount"] = $obResult1['id'];
		$arrCol["approved"] = $obResult1['id'];
		$arrCol["favour"] = $num_rows2new['fav'];
		$arrCol["fisrt"] = $obResult1['fivisit'];
		$arrCol["last"] = $obResult1['lastvisit'];
		$arrCol["swpcount"] = $obResult1['swp'];
		$arrCol["swpcoverage"] = $obResult1['swp_cov'];
		$arrCol["swpaverage"] = ($obResult1['swp_cov']/$arrCol["doccount"])*100;
		$arrCol["metonce"] = $SQL1new_rows;
		$arrCol["mettwice"] = $SQL1new_rows5;
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
		$arrCol["start_time"] =date("H:i:s", strtotime($start_time)) ;
		$arrCol["end_time"] =date("H:i:s", strtotime($end_time)) ;

	}
	array_push($resultArray,$arrCol);
}


mysql_close($con);

echo json_encode($resultArray);




?>