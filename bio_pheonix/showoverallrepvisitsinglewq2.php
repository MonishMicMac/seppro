<?php

include("connect23.php"); 

$id=$_REQUEST['id'];
$date=$_REQUEST['date'];


$outpu;
$outpu1;





echo '[';



$a = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid ORDER BY rep_name ASC")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{


	$repname=$jj['rep_name'];
	$repidd=$jj['id'];



	$resultss = mysql_query("SELECT wp_id FROM tbl_work_plan WHERE wp_rep_id='$repidd' AND wp_dc='D' AND wp_date='$date' AND attendancestatus='1' AND drunavailable='0'");
	$num_rowss = mysql_num_rows($resultss);

	$resultss1 = mysql_query("SELECT wp_id FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repidd' AND wp_dc='D' AND wp_date='$date' AND unapprovedtbl_work_plan.attendancestatus='1' AND drunavailable='0'");
	$num_rowss1 = mysql_num_rows($resultss1);

	$num_rowss=($num_rowss+$num_rowss1);

	if($num_rowss=='0')
	{
		$num_rowss="0";
	}
	else
	{
		$repname=$repname;
		$num_rowss=$num_rowss;
	}



	$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$repidd' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$date' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";
	$objQuery = mysql_query($strSQL);

	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();

	if(mysql_num_rows($objQuery)>0){
		while($obResult = mysql_fetch_array($objQuery))
		{
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
				if($num_rowss=='0' && mysql_field_name($objQuery,$i)=='drunavailablereason')
				{
					$arrCol[mysql_field_name($objQuery,$i)] = "";
				}
				else
				{
					$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
				}    



			}

			


			$arrCol['repnames'] = $repname." - ".$num_rowss;

			$tbl2qq = mysql_query("SELECT GROUP_CONCAT(repid) AS repid FROM managerjoinworkplans WHERE date='$date' AND managerid='$repidd'")or die(mysql_error());
			$tbl_res2qq = mysql_fetch_array($tbl2qq);


			$tbl2qq1 = mysql_query("SELECT GROUP_CONCAT(rep_name) AS rep_name FROM representative WHERE `id` IN ('".$tbl_res2qq['repid']."')")or die(mysql_error());
			$tbl_res2qq1 = mysql_fetch_array($tbl2qq1);


			$arrCol['jww'] = $tbl_res2qq1['rep_name'];
			array_push($resultArray,$arrCol);
		}
	} else {
		$arrCol1['repnames']=$repname."- 0";
		array_push($resultArray,$arrCol1);
	}










	if(strlen(json_encode($resultArray))==2)
	{
	}
	else
	{


		$result = substr(json_encode($resultArray), 1, -1);

		$outpu1.=$result.',';

	}

	$strSQL1 = "SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.drunavailable,unapprovedtbl_work_plan.drunavailablereason,unapprovedtbl_work_plan.latitude,unapprovedtbl_work_plan.longitude,unapprovedtbl_work_plan.reporteddate,unapprovedtbl_work_plan.reportedtime,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doc_contact_no,unapproveddoctors.doc_specilist_id,unapproveddoctors.doc_qualification,unapproveddoctors.doctor_addrs,unapprovedtbl_work_plan.jointworkby FROM unapprovedtbl_work_plan,unapproveddoctors WHERE unapprovedtbl_work_plan.wp_rep_id='$repidd' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.reporteddate='$date' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapprovedtbl_work_plan.drunavailable='0' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

	$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);

	$resultArray1 = array();
	if(mysql_num_rows($objQuery1)>0){
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			if($num_rowss=='0' && mysql_field_name($objQuery1,$i)=='drunavailablereason')
			{
				$arrCol[mysql_field_name($objQuery1,$i)] = "";
			}
			else
			{
				$arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
			}     

		 //$arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];


		}
		



		$arrCol['repnames'] = $repname." - ".$num_rowss;

		$tbl2qq = mysql_query("SELECT GROUP_CONCAT(repid) AS repid FROM managerjoinworkplans WHERE date='$date' AND managerid='$repidd'")or die(mysql_error());
		$tbl_res2qq = mysql_fetch_array($tbl2qq);


		$tbl2qq1 = mysql_query("SELECT GROUP_CONCAT(rep_name) AS rep_name FROM representative WHERE `id` IN ('".$tbl_res2qq['repid']."')")or die(mysql_error());
		$tbl_res2qq1 = mysql_fetch_array($tbl2qq1);


		$arrCol['jww'] = $tbl_res2qq1['rep_name'];

		array_push($resultArray1,$arrCol);
	}

} else {
		$arrCol1['repnames']=$repname."- 0";
		array_push($resultArray,$arrCol1);
	}
	if(strlen(json_encode($resultArray1))==2)
	{
	}
	else
	{


		$result1 = substr(json_encode($resultArray1), 1, -1);

		$outpu1.=$result1.',';

	}

	
}


if(strlen(json_encode($result))>2)
{

	$outpu = substr($outpu1, 0, -1);
	echo $outpu;
	echo ']';
}


?>