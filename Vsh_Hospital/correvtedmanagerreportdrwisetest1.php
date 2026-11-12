<?php

include("connect23.php"); 

$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];

$att=$_REQUEST['att'];

$appte=$_REQUEST['appte'];

if($appte=='0')
{

echo '[';

$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.visitcardclinicphoto,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby,tbl_work_plan.mtp FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='$att' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

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
                $arrCol['count'] = "0";
		array_push($resultArray,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray))<='2')
{
}
else
{
 

echo $rest = substr(json_encode($resultArray), 1, -1);
}







$strSQL1 = "SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.drunavailable,unapprovedtbl_work_plan.drunavailablereason,unapprovedtbl_work_plan.latitude,unapprovedtbl_work_plan.longitude,unapprovedtbl_work_plan.reporteddate,unapprovedtbl_work_plan.reportedtime,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doc_contact_no,unapproveddoctors.doc_specilist_id,unapproveddoctors.visitcardclinicphoto,unapproveddoctors.doc_qualification,unapproveddoctors.doctor_addrs,unapprovedtbl_work_plan.jointworkby,unapprovedtbl_work_plan.mtp FROM unapprovedtbl_work_plan,unapproveddoctors  WHERE unapprovedtbl_work_plan.wp_rep_id='$wp_rep_id' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.reporteddate='$reporteddate' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapprovedtbl_work_plan.drunavailable='$att' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
                 $arrCol['count'] = "1";

		array_push($resultArray1,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray1))<='2')
{
echo ']';
}
else
{
 if(strlen(json_encode($resultArray))<='2')
{
}
else
{
echo ',';
}

echo $rest = substr(json_encode($resultArray1), 1, -1).']';
}
}











else if($appte=='1')
{

echo '[';

$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.visitcardclinicphoto,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby,tbl_work_plan.mtp FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.jointworkby='0' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

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
                $arrCol['count'] = "0";
		array_push($resultArray,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray))<='2')
{
}
else
{
 

echo $rest = substr(json_encode($resultArray), 1, -1);
}







$strSQL1 = "SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.drunavailable,unapprovedtbl_work_plan.drunavailablereason,unapprovedtbl_work_plan.latitude,unapprovedtbl_work_plan.longitude,unapprovedtbl_work_plan.reporteddate,unapprovedtbl_work_plan.reportedtime,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doc_contact_no,unapproveddoctors.doc_specilist_id,unapproveddoctors.visitcardclinicphoto,unapproveddoctors.doc_qualification,unapproveddoctors.doctor_addrs,unapprovedtbl_work_plan.jointworkby,unapprovedtbl_work_plan.mtp FROM unapprovedtbl_work_plan,unapproveddoctors  WHERE unapprovedtbl_work_plan.wp_rep_id='$wp_rep_id' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.jointworkby='0' AND unapprovedtbl_work_plan.reporteddate='$reporteddate' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapprovedtbl_work_plan.drunavailable='0' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
                 $arrCol['count'] = "1";

		array_push($resultArray1,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray1))<='2')
{
echo ']';
}
else
{
 if(strlen(json_encode($resultArray))<='2')
{
}
else
{
echo ',';
}

echo $rest = substr(json_encode($resultArray1), 1, -1).']';
}
}


















else if($appte=='2')
{

echo '[';

$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.visitcardclinicphoto,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby,tbl_work_plan.mtp FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.jointworkby!='0' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

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
                $arrCol['count'] = "0";
		array_push($resultArray,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray))<='2')
{
}
else
{
 

echo $rest = substr(json_encode($resultArray), 1, -1);
}







$strSQL1 = "SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.drunavailable,unapprovedtbl_work_plan.drunavailablereason,unapprovedtbl_work_plan.latitude,unapprovedtbl_work_plan.longitude,unapprovedtbl_work_plan.reporteddate,unapprovedtbl_work_plan.reportedtime,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doc_contact_no,unapproveddoctors.doc_specilist_id,unapproveddoctors.visitcardclinicphoto,unapproveddoctors.doc_qualification,unapproveddoctors.doctor_addrs,unapprovedtbl_work_plan.jointworkby,unapprovedtbl_work_plan.mtp FROM unapprovedtbl_work_plan,unapproveddoctors  WHERE unapprovedtbl_work_plan.wp_rep_id='$wp_rep_id' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.jointworkby!='0' AND unapprovedtbl_work_plan.reporteddate='$reporteddate' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapprovedtbl_work_plan.drunavailable='0' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
                 $arrCol['count'] = "1";

		array_push($resultArray1,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray1))<='2')
{
echo ']';
}
else
{
 if(strlen(json_encode($resultArray))<='2')
{
}
else
{
echo ',';
}

echo $rest = substr(json_encode($resultArray1), 1, -1).']';
}
}



















?>