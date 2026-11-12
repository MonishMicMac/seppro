<?php
  // include("connection_db.php");
include("connectsms.php");
   $resultArray = array();
   // SCHOOL STRENGTH - START
   if(@$_REQUEST["GAGE"]=="STRENGTH"){
       $Strength = mysql_query("SELECT `standard_name`,count(`standard_name`) AS Total,SUM(CASE WHEN `Sex` = 'MALE' THEN 1 else 0 END) AS Boys,SUM(CASE WHEN `Sex` = 'FEMALE' THEN 1 else 0 END) AS Girls FROM `student_profile` GROUP BY `standard_name` ORDER BY CAST(Standard_id AS UNSIGNED INTEGER)");
       $intNumField = mysql_num_fields($Strength);
       while($R=mysql_fetch_array($Strength)){
         $arrCol = array();
         for($i=0;$i<$intNumField;$i++)
         {
            $arrCol[mysql_field_name($Strength,$i)] = $R[$i];
         }
         array_push($resultArray,$arrCol);
       }
   }
   // SCHOOL STRENGTH - END
   // TODAY BIRTHDAY - STUDENT - START
   if(@$_REQUEST["GAGE"]=="STUDENTBIRTHDAY"){
       $BIRTH=mysql_query("SELECT Name,standard_name,section_name FROM `student_profile` WHERE DATE_FORMAT(STR_TO_DATE(DOB,'%Y-%m-%d'),'%m-%d') = DATE_FORMAT(CURDATE(),'%m-%d')") or die(mysql_error());
       $intNumField = mysql_num_fields($BIRTH);
       while($R=mysql_fetch_array($BIRTH)){
            $arrCol = array();
            for($i=0;$i<$intNumField;$i++)
            {
               $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
            }
            array_push($resultArray,$arrCol);
       }
   }
   // TODAY BIRTHDAY - STUDENT - END
   // GAGE - STANDARD DETAILS - START
   if(@$_REQUEST["GAGE"]=="SCHOOLSTANDARD"){
      $BIRTH=mysql_query("SELECT standard_name,group_concat(DISTINCT section_name) Section,count(`standard_name`) AS Total,SUM(CASE WHEN `Sex` = 'MALE' THEN 1 else 0 END) AS Boys,SUM(CASE WHEN `Sex` = 'FEMALE' THEN 1 else 0 END) AS Girls FROM `student_profile` GROUP BY standard_name  ORDER BY CAST(Standard_id AS UNSIGNED INTEGER)") or die(mysql_error());
      $intNumField = mysql_num_fields($BIRTH);
      while($R=mysql_fetch_array($BIRTH)){
           $arrCol = array();
           for($i=0;$i<$intNumField;$i++)
           {
              $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
           }
           array_push($resultArray,$arrCol);
      }
   }
   // GAGE - STANDARD DETAILS - END
   // SCHOOL SUBJECTS - START
   if(@$_REQUEST["GAGE"]=="SUBJECTS"){
	   $BIRTH=mysql_query("SELECT sub_id,sub_name,status FROM mst_sub WHERE sub_name!='N\/A'") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   // SCHOOL SUBJECTS - END
    // SCHOOL STANDARD SECTIONWISE - START
   if(@$_REQUEST["GAGE"]=="STANDARD"){
   		$STANDARD=mysql_query("SELECT `tbl_stc_stn_assign_sec`.`sec_id`,`mst_st_names`.s_names,`mst_st_names`.sn_id FROM `tbl_stc_stn_assign_sec`,`mst_st_names` WHERE `mst_st_names`.`s_names`='".$_REQUEST["standard"]."' AND `tbl_stc_stn_assign_sec`.`sn_id`=`mst_st_names`.`sn_id`") or die(mysql_error());
		$S=mysql_fetch_array($STANDARD);
	   $BIRTH=mysql_query("SELECT concat('".$S['s_names']."','-',sec_name) STD,sec_id,".$S['sn_id']." std FROM mst_sec WHERE sec_id IN (".$S['sec_id'].")") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   // SCHOOL STANDARD SECTIONWISE - END
   // SCHOOL STUDENT LIST & STANDARD SECTIONWISE - START
   if(@$_REQUEST["GAGE"]=="STUDENTS"){
	   $BIRTH=mysql_query("SELECT stu_id,Name,student_id,standard_name,section_name FROM student_profile WHERE standard_id='".$_REQUEST["standard"]."' AND section_id='".$_REQUEST["section"]."'") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   // SCHOOL STUDENT LIST & STANDARD SECTIONWISE - END
   // STUDENT HW & CIRCULAR SMS - START
   if(@$_REQUEST["GAGE"]=="STUDENTSMS"){
	   $BIRTH=mysql_query("SELECT bulksms_type,msg,CONCAT(DATE_FORMAT(bulksms_date, '%d-%m-%Y'),' ',bulksms_time) DateTime,status FROM `tbl_bulksms_details` WHERE `section` like '%".$_REQUEST["standard"].", ".$_REQUEST["section"]."%' ORDER BY bulksms_id DESC") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   // STUDENT HW & CIRCULAR SMS - END
   // STUDENT INDIVIDUAL SMS - START
   if(@$_REQUEST["GAGE"]=="STUDENTINDIVIDUALSMS"){
	   $BIRTH=mysql_query("SELECT name,message,CONCAT(DATE_FORMAT(date, '%d-%m-%Y'),' ',time) DateTime FROM `stu_individual_sms`  WHERE student_id='".$_REQUEST["student"]."' ORDER BY stu_indi_id DESC") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   // STUDENT INDIVIDUAL SMS - END
   // SCHOOL EVENTS - START
   if(@$_REQUEST["GAGE"]=="EVENTS"){
	   $BIRTH=mysql_query("SELECT DATE_FORMAT(holiday_date, '%d-%m-%Y') H_DATE,DATE_FORMAT(to_date, '%d-%m-%Y') TO_DATE,reserved_holiday_title, status FROM `calendar`") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL EVENTS - END
   // SCHOOL STAFF STRENGTH - START
   if(@$_REQUEST["GAGE"]=="STAFFSTRENGTH"){
	   $BIRTH=mysql_query("SELECT COUNT(*) AS STAFFTOT,SUM(CASE WHEN (staff_type='Teaching' OR staff_type='')  THEN 1 ELSE 0 END) TEACHING,SUM(CASE WHEN staff_type='Non-Teaching' THEN 1 ELSE 0 END) NONTEACHING FROM `staff_profile`") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL STAFF STRENGTH - END
   // SCHOOL STAFF STRENGTH - START
   if(@$_REQUEST["GAGE"]=="STAFF"){
	   $BIRTH=mysql_query("SELECT * FROM `staff_profile`") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL STAFF STRENGTH - END
   // SCHOOL STAFF STRENGTH - START
   if(@$_REQUEST["GAGE"]=="CLASSTEACHERS"){
	   $BIRTH=mysql_query("select CONCAT(staff_profile.Name,' ',staff_profile.Last_name) SNAME,staff_profile.Staff_id,mst_st_names.s_names,mst_sec.sec_name from staff_profile,mst_st_names,mst_sec WHERE class_teacher='1' AND mst_st_names.sn_id=staff_profile.Standard_id AND mst_sec.sec_id=staff_profile.Section_id ORDER BY mst_st_names.sn_id,mst_sec.sec_id") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL STAFF STRENGTH - END
   // SCHOOL STAFF CIRCULAR - START
   if(@$_REQUEST["GAGE"]=="STAFFCIRCULAR"){
	   $BIRTH=mysql_query("select * from staff_circular ORDER BY cir_id DESC") or die(mysql_error());
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL STAFF CIRCULAR - END
   // SCHOOL STAFF CIRCULAR - START
   if(@$_REQUEST["GAGE"]=="STDSECTIONSUB"){
	   $showSubjects=mysql_query("SELECT * FROM tbl_stc_stn_sec_assign_sub WHERE sn_id='".@$_GET["standard"]."' AND sec_id='".$_REQUEST["section"]."' ");
           $Subject = mysql_fetch_object($showSubjects);
           $BIRTH=mysql_query("SELECT sub_id,sub_name,status FROM mst_sub WHERE sub_id IN (".$Subject->sub_id.") GROUP BY sub_id");
	   $intNumField = mysql_num_fields($BIRTH);
	   while($R=mysql_fetch_array($BIRTH)){
			$arrCol = array();
			for($i=0;$i<$intNumField;$i++)
			{
			   $arrCol[mysql_field_name($BIRTH,$i)] = $R[$i];
			}
			array_push($resultArray,$arrCol);
	   }
    }
   //  SCHOOL STAFF CIRCULAR - END
  // echo json_encode($resultArray);

//////////////// New for management//////////////////
if($_REQUEST['GAGE']=='cirins')
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


  if($_REQUEST['GAGE']=='stdsec')
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


	 if($_REQUEST['GAGE']=='overall')
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

	if($_REQUEST['GAGE']=='indteach')
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
	//mysql_close($con);	
	//echo json_encode($resultArray);
}


if($_REQUEST['GAGE']=='indteach')
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
	/*mysql_close($con);	
	echo json_encode($resultArray);*/
}

 echo json_encode($resultArray);
	//////////////// New for management//////////////////
?>