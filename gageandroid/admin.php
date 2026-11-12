<?php
include("connectsms.php");
if($_REQUEST['mode']=='dash')
{
	$student=mysql_query("SELECT COUNT(stu_id) AS STUDENT FROM student_profile") or die(mysql_error());
	$student_res=mysql_fetch_array($student);
	$staff=mysql_query("SELECT COUNT(s_id) AS STAFF FROM staff_profile") or die(mysql_error());
	$staff_res=mysql_fetch_array($staff);
	$standard=mysql_query("SELECT COUNT(sn_id) AS STANDARD FROM mst_st_names") or die(mysql_error());
	$standard_res=mysql_fetch_array($standard);
	echo '[{"student":"'.$student_res['STUDENT'].'","staff":"'.$staff_res['STAFF'].'","standard":"'.$standard_res['STANDARD'].'"}]';
}

if($_REQUEST['mode']=='indteach')
{
	$staff="SELECT * FROM staff_profile WHERE s_id='".$_REQUEST['staffid']."'";
	$objQuery = mysql_query($staff);
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
}


if($_REQUEST['mode']=='cirins')
{
	date_default_timezone_set("Asia/Kolkata");
	if($_REQUEST["cirtype"]=="ALL")
	{
		mysql_query("INSERT INTO staff_circular(circular_staff_names,circular_staff_ids,circular_message,circular_date,circular_time)VALUES('All','All','".mysql_real_escape_string($_REQUEST['cir_message'])."','".date("Y-m-d")."','".date("H:i:s")."')") or die(mysql_error());
	}
	if($_REQUEST["cirtype"]=="SPEC")
	{
		$SQL = mysql_query("SELECT Name FROM staff_profile WHERE s_id IN (".substr($_REQUEST['cir_staff'],0,-1).")")or die(mysql_error());
			while($RS=mysql_fetch_object($SQL))
			{
				$name.=$RS->Name.",";
			}
		mysql_query("INSERT INTO staff_circular(circular_staff_names,circular_staff_ids,circular_message,circular_date,circular_time)VALUES('".$name."','".$_REQUEST['cir_staff']."','".mysql_real_escape_string($_REQUEST['cir_message'])."','".date("Y-m-d")."','".date("H:i:s")."')") or die(mysql_error());
	}

}

if($_REQUEST['mode']=='cirview')
{
	$cirview="SELECT * FROM staff_circular ORDER BY cir_id DESC";
	$objQuery = mysql_query($cirview);
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
}



if($_REQUEST['GAGE']=='cirview')
{
	if($_REQUEST['mode']=='ALL')
	{
		$cirview="SELECT * FROM staff_circular ORDER BY cir_id DESC";
	}
	if($_REQUEST['mode']=='SPEC')
	{
		$cirview="SELECT * FROM `staff_circular` WHERE concat(',',`circular_staff_ids`) LIKE '%,".$_SESSION['m_id'].",%'ORDER BY cir_id DESC";
	}
	
	$objQuery = mysql_query($cirview);
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
}



if($_REQUEST['mode']=='stuatt')
{
	if($_REQUEST['atttype']=='stdsec')
	{
		$ay=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
  		$ay_res=mysql_fetch_array($ay);
  		$say=explode("-",$ay_res['calendar_sdate']);$eay=explode("-",$ay_res['calendar_edate']); $ayc=$say[0]."-".$eay[0];

		$absstdseccount="SELECT COUNT(a_id) AS ABSCNT,(SELECT COUNT(stu_id) FROM student_profile WHERE Standard_id=student_attendance.standard_id AND Section_id=student_attendance.section_id) as STUCNT FROM student_attendance WHERE standard_id='".$_REQUEST['stdid']."' AND section_id='".$_REQUEST['secid']."' AND date='".date('Y-m-d')."' AND academic_year='$ayc' GROUP BY standard_id,section_id";
		//$cirview="SELECT COUNT(a_id) AS ABSCNT,(SELECT COUNT(stu_id) FROM student_profile WHERE Standard_id=student_attendance.standard_id AND Section_id=student_attendance.section_id) as STUCNT FROM student_attendance WHERE standard_id='".$_REQUEST['stdid']."' AND section_id='".$_REQUEST['secid']."' AND date='2017-04-24' AND academic_year='2016-2017' GROUP BY standard_id,section_id";
		$stdsec = mysql_query($absstdseccount)or die(mysql_error());
		$stdsec_res = mysql_fetch_array($stdsec);
		$stdsecpresent=$stdsec_res['STUCNT']-$stdsec_res['ABSCNT'];
		echo '[{"total":"'.$stdsec_res['STUCNT'].'","present":"'.$stdsecpresent.'","absent":"'.$stdsec_res['ABSCNT'].'"}]';

	}

	if($_REQUEST['atttype']=='overall')
	{
		$ay=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
  		$ay_res=mysql_fetch_array($ay);
  		$say=explode("-",$ay_res['calendar_sdate']);$eay=explode("-",$ay_res['calendar_edate']); $ayc=$say[0]."-".$eay[0];

		$absoverallcount="SELECT COUNT(a_id) AS ABSCNT, `standard_id` , `section_id` , `standard_name` , `section_name`,(SELECT COUNT(stu_id) FROM student_profile WHERE Standard_id=student_attendance.standard_id AND Section_id=student_attendance.section_id) as STUCNT FROM student_attendance WHERE date='".date('Y-m-d')."' AND academic_year='$ayc' GROUP BY standard_id,section_id";
		$overall = mysql_query($absoverallcount)or die(mysql_error());
		if(mysql_num_rows($overall)>0)
		{
			echo '[';
			while($overall_res = mysql_fetch_array($overall))
			{
				$overallpresent=$overall_res['STUCNT']-$overall_res['ABSCNT'];
				$ovcnt.='{"total":"'.$overall_res['STUCNT'].'","present":"'.$overallpresent.'","absent":"'.$overall_res['ABSCNT'].'"},';
			}
			echo substr($ovcnt,0,-1).']';
		}
		else
		{
			echo '[]';
		}
		

	}

}

?>