<?php

include("connectsms.php");

$acyear=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$acyear_res=mysql_fetch_array($acyear);
$syear=explode("-",$acyear_res['calendar_sdate']);
$eyear=explode("-",$acyear_res['calendar_edate']);
$acy=$syear[0]."-".$eyear[0];

if($_REQUEST['mode']=='stuattlist')
{

$stdid=$_REQUEST['stdid'];
$secid=$_REQUEST['secid'];

$date=date("Y-m-d",strtotime($_REQUEST['date']));


//$acy=$_REQUEST['acy'];


//$strSQL= "SELECT student_profile.stu_id,student_profile.student_id,student_profile.Name,(CASE WHEN student_attendance.status LIKE '%A%' AND student_attendance.student_id=student_profile.student_id  THEN 1 ELSE 0 END) AS TOTAL FROM student_attendance,student_profile WHERE student_attendance.standard_id='$stdid' AND student_attendance.section_id='$secid' AND date='$date' AND student_attendance.standard_id=student_profile.Standard_id AND student_attendance.section_id=student_profile.Section_id GROUP BY student_profile.student_id";

$strSQL= "SELECT student_profile.stu_id,student_profile.student_id,student_profile.Name,IFNULL(REPLACE(student_attendance.status,'A',1),0) TOTAL FROM student_profile LEFT JOIN `student_attendance` ON student_profile.student_id = student_attendance.student_id AND student_attendance.`date`='$date' AND student_attendance.`status`='A' WHERE
 student_profile.standard_id = '$stdid' AND student_profile.section_id = '$secid' AND student_profile.Academic_year = '$acy' ORDER BY TOTAL DESC";
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
}

if($_REQUEST['mode']=='stuattins')
{
  $expstuid=explode(",",$_REQUEST['stuid']);

  for($j=0;$j<count($expstuid);$j++)
  {
   $stuattchk=mysql_query("SELECT * FROM student_attendance WHERE student_id='$expstuid[$j]' AND standard_id='".$_REQUEST['stdid']."' AND section_id='".$_REQUEST['secid']."' AND date='".$_REQUEST['adate']."' AND status='".$_REQUEST['status']."' ")or die(mysql_error());//AND staff_id='".$_REQUEST['staffid']."'
   if(mysql_num_rows($stuattchk)>0)
   {
	mysql_query("DELETE FROM student_attendance WHERE student_id='$expstuid[$j]' AND standard_id='".$_REQUEST['stdid']."' AND section_id='".$_REQUEST['secid']."' AND date='".$_REQUEST['adate']."' AND status='".$_REQUEST['status']."'")or die(mysql_error());// AND staff_id='".$_REQUEST['staffid']."'
   }
   else
   {
	$expdate=explode("-",$_REQUEST['adate']);
        $day=$expdate[2];$mnth=$expdate[1];$year=$expdate[0];
	$studet=mysql_query("SELECT standard_name,section_name,Name FROM student_profile WHERE student_id='$expstuid[$j]'")or die(mysql_error());
        $studet_res=mysql_fetch_array($studet);
 	mysql_query("INSERT INTO student_attendance(student_id,standard_id,section_id,standard_name,section_name,student_name,staff_id,date,day,month,year,status,c_date)VALUES('$expstuid[$j]','".$_REQUEST['stdid']."','".$_REQUEST['secid']."','".$studet_res['standard_name']."','".$studet_res['section_name']."','".$studet_res['Name']."','".$_REQUEST['staffid']."','".$_REQUEST['adate']."','$day','$mnth','$year','".$_REQUEST['status']."','".date('Y-m-d H:i:s')."')")or die(mysql_error());
   }
 }
}

if($_REQUEST['mode']=='stulist')
{
	$stulist="SELECT stu_id,student_id,Name FROM student_profile WHERE Standard_id='".$_REQUEST['std']."' AND Section_id='".$_REQUEST['sec']."' AND Academic_year='$acy'";
	$objQuery = mysql_query($stulist);
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

if($_REQUEST['mode']=='stufull')
{

	$stulist="SELECT * FROM student_profile WHERE stu_id='".$_REQUEST['stuid']."'";
	$objQuery = mysql_query($stulist);
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

if($_REQUEST['mode']=='stumark')
{
	// echo "SELECT `tbl_mark_entry`.student_id AS STUID ,Name,exam_name,SUM(mark_obtained) AS TM FROM `tbl_mark_entry`,student_profile,mst_examname WHERE tbl_mark_entry.`student_id`='".$_REQUEST['stuid']."' AND `mark_acadamic_year`='".$_REQUEST['acy']."' AND `tbl_mark_entry`.`student_id`=student_profile.stu_id  AND mst_examname.en_id=`tbl_mark_entry`.`exam_id` GROUP BY exam_id";
	$stumark="SELECT `tbl_mark_entry`.student_id AS STUID ,Name,exam_name,SUM(mark_obtained) AS TM FROM `tbl_mark_entry`,student_profile,mst_examname WHERE tbl_mark_entry.`student_id`='".$_REQUEST['stuid']."' AND `mark_acadamic_year`='$acy' AND `tbl_mark_entry`.`student_id`=student_profile.stu_id  AND mst_examname.en_id=`tbl_mark_entry`.`exam_id` GROUP BY exam_id";
	$objQuery = mysql_query($stumark);
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
	
	$stuatt="SELECT COUNT(a_id) AS CNT, MONTHNAME(STR_TO_DATE(month, '%m')) AS MNTH,month FROM student_attendance WHERE `student_id` ='".$_REQUEST['stuid']."' AND academic_year='$acy' GROUP BY month";
	$objQuery = mysql_query($stuatt);
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
?>