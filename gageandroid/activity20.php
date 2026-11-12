<?php
// include("connectsms.php");

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');

$academicyear=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$academicyear_res=mysql_fetch_array($academicyear);
$say=explode("-",$academicyear_res['calendar_sdate']);$eay=explode("-",$academicyear_res['calendar_edate']);
$ayc=$say[0]."-".$eay[0];
if($_REQUEST['AACHI']=='viewactivity')
{
$str="";
echo '[';


$activity=mysql_query("SELECT * FROM tbl_activity_category_heading,activity_category WHERE tbl_activity_category_heading.tach_standard='".$_REQUEST['stand']."' AND tbl_activity_category_heading.academic_year='$ayc' AND activity_category.ac_id=tbl_activity_category_heading.tach_category ORDER BY tach_id DESC")or die(mysql_error());
while($activity_res=mysql_fetch_array($activity))
{
	$activityimg=mysql_query("SELECT GROUP_CONCAT(tachi_image) AS ACTIMG FROM tbl_activity_category_heading_image WHERE tachi_headid='".$activity_res['tach_id']."'")or die(mysql_error());
	$activityimg_res=mysql_fetch_array($activityimg);
	$sample=$activityimg_res['ACTIMG']?$activityimg_res['ACTIMG']:"NIL";

		$str.='{"category":"'.$activity_res['ac_name'].'","catid":"'.$activity_res['tach_category'].'","heading":"'.$activity_res['tach_heading'].'","headid":"'.$activity_res['tach_id'].'","description":"'.$activity_res['tach_desc'].'","completiondate":"'.date('d-m-Y',strtotime($activity_res['tach_completiondate'])).'","assigneddate":"'.date('d-m-Y',strtotime($activity_res['tach_assigned_date'])).'","sample":"'.$sample.'"},';

}
echo substr($str,0,-1).']';
}

if($_REQUEST['AACHI']=='insactivitychat')
{
	$activity=mysql_query("INSERT INTO tbl_activity_chat(ac_catid,ac_headid,ac_msg,ac_status,ac_senderid,ac_date,ac_time,ac_academicyear,std_id,sec_id)VALUES('".$_REQUEST['cid']."','".$_REQUEST['hid']."','".$_REQUEST['msg']."','".$_REQUEST['stat']."','".$_REQUEST['sender']."','".date('Y-m-d')."','".date('h:i:s A')."','$ayc','".$_REQUEST['std']."','".$_REQUEST['sec']."')")or die(mysql_error());
}

if($_REQUEST['AACHI']=='viewactivitychat')
{
	$str="";
	$viewactivitychat=mysql_query("SELECT * FROM tbl_activity_chat WHERE ac_academicyear='$ayc' AND ac_catid='".$_REQUEST['cid']."' AND ac_headid='".$_REQUEST['hid']."'")or die(mysql_error());
	while($viewactivitychat_res=mysql_fetch_array($viewactivitychat))
	{
		if($viewactivitychat_res['ac_status']=='0')
		{
			if($viewactivitychat_res['ac_senderid']=='0')
			{
				$id="0";
				$name="Admin";	
				$std="0";
				$sec="0";
			}
			if($viewactivitychat_res['ac_senderid']!='0')
			{
				$staff=mysql_query("SELECT s_id,Name,Last_name FROM staff_profile WHERE s_id='".$viewactivitychat_res['ac_senderid']."'")or die(mysql_error());
				$staff_res=mysql_fetch_array($staff);
				$id=$staff_res['s_id'];
				$name=$staff_res['Name']." ".$staff_res['Last_name'];				
				$std="0";
				$sec="0";
			}
		}
		if($viewactivitychat_res['ac_status']=='1')
		{
			$stuname=mysql_query("SELECT stu_id,Name,Last_name,standard_name,section_name FROM student_profile WHERE Academic_year='$ayc' AND stu_id='".$viewactivitychat_res['ac_senderid']."' AND tc_status!='2'")or die(mysql_error());
			$stuname_res=mysql_fetch_array($stuname);
			$id=$stuname_res['stu_id'];
			$name=$stuname_res['Name']." ".$stuname_res['Last_name'];
			$std=$stuname_res['standard_name'];
			$sec=$stuname_res['section_name'];
		}
		$str.='{"status":"'.$viewactivitychat_res['ac_status'].'","date":"'.date('d-m-Y',strtotime($viewactivitychat_res['ac_date'])).'","time":"'.$viewactivitychat_res['ac_time'].'","msg":"'.$viewactivitychat_res['ac_msg'].'","Name":"'.$name.'","std":"'.$std.'","sec":"'.$sec.'","id":"'.$id.'"},';

	}
 	echo '['.substr($str,0,-1).']';
}


if($_REQUEST['AACHI']=='inshwchat')
{
	$activity=mysql_query("INSERT INTO homeworkchat(bulksms_id,msg,status,senderid,date,time,ac_academicyear,std_id,sec_id)VALUES('".$_REQUEST['bid']."','".$_REQUEST['msg']."','".$_REQUEST['stat']."','".$_REQUEST['sender']."','".date('Y-m-d')."','".date('h:i:s A')."','$ayc','".$_REQUEST['std']."','".$_REQUEST['sec']."')")or die(mysql_error());
}

if($_REQUEST['AACHI']=='viewhwchat')
{
	$str="";
	$viewhwchat=mysql_query("SELECT * FROM homeworkchat WHERE ac_academicyear='$ayc' AND bulksms_id='".$_REQUEST['bid']."'")or die(mysql_error());
	while($viewhwchat_res=mysql_fetch_array($viewhwchat))//AND senderid='".$_REQUEST['sender']."'
	{
		if($viewhwchat_res['status']=='0')
		{
			if($viewhwchat_res['senderid']=='0')
			{
				$id="0";
				$name="Admin";	
				$std="0";
				$sec="0";
			}
			if($viewhwchat_res['senderid']!='0')
			{
				$staff=mysql_query("SELECT s_id,Name,Last_name FROM staff_profile WHERE s_id='".$viewhwchat_res['senderid']."'")or die(mysql_error());
				$staff_res=mysql_fetch_array($staff);
				$id=$staff_res['s_id'];
				$name=$staff_res['Name']." ".$staff_res['Last_name'];				
				$std="0";
				$sec="0";
			}
		}
		if($viewhwchat_res['status']=='1')
		{
			$stuname=mysql_query("SELECT stu_id,Name,Last_name,standard_name,section_name FROM student_profile WHERE Academic_year='$ayc' AND stu_id='".$viewhwchat_res['senderid']."' AND tc_status!='2'")or die(mysql_error());
			$stuname_res=mysql_fetch_array($stuname);
			$id=$stuname_res['stu_id'];
			$name=$stuname_res['Name']." ".$stuname_res['Last_name'];
			$std=$stuname_res['standard_name'];
			$sec=$stuname_res['section_name'];
		}
		$str.='{"status":"'.$viewhwchat_res['msg'].'","date":"'.date('d-m-Y',strtotime($viewhwchat_res['date'])).'","time":"'.$viewhwchat_res['time'].'","stat":"'.$viewhwchat_res['status'].'","Name":"'.$name.'","std":"'.$std.'","sec":"'.$sec.'","id":"'.$id.'"},';

	}
 	echo '['.substr($str,0,-1).']';
}
?>