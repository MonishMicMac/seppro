<?php
include("connectsms.php");

$jjstu = mysql_query("SELECT * FROM student_profile WHERE stu_id='".$_REQUEST['stuid']."'")or die(mysql_error());
$jjtu_res = mysql_fetch_array($jjstu);

echo '[';
global $str;




$jjsmsreport1 = mysql_query("SELECT * FROM `tbl_bulksms_details` WHERE status = 1 AND `section` LIKE '".$jjtu_res['Standard_id'].",%' AND `section` LIKE '%, ".$jjtu_res['Section_id'] ." /%' ORDER BY bulksms_id DESC")or die(mysql_error()); 
$jjsmsreport1_count = mysql_num_rows($jjsmsreport1);

    while($jjsmsreport1_res = mysql_fetch_array($jjsmsreport1))
    {

      $sms=$jjsmsreport1_res['msg'];
$msg = str_replace('"',"'",$sms);
$bdate = $jjsmsreport1_res['bulksms_date'];
      $str.='{"date":"homework","type":'.'"'.$bdate.'","sms":'.'"'.$msg.'"},';
    } 


$jjsmsreport = mysql_query("SELECT * FROM `tbl_bulksms_details` WHERE status = 0 AND `section` LIKE '".$jjtu_res['Standard_id'].",%' AND `section` LIKE '%, ".$jjtu_res['Section_id'] ." /%' ORDER BY bulksms_id DESC")or die(mysql_error()); 

    while($jjsmsreport_res = mysql_fetch_array($jjsmsreport))
    {

      $sms=$jjsmsreport_res['msg'];
$msg = str_replace('"',"'",$sms);
   $gdate = $jjsmsreport_res['bulksms_date'];
     $str.='{"date":"general","type":'.'"'.$gdate.'","sms":'.'"'.$msg.'"},';
    } 

    

$jjexamlist = mysql_query("SELECT * FROM exam_schedule,mst_examname,mst_subexamname WHERE std_id='".$jjtu_res['Standard_id']."' AND sec_id='".$jjtu_res['Section_id']."' AND exam_schedule.exam_type=mst_examname.en_id AND exam_schedule.exam_category=mst_subexamname.senid ORDER BY exam_id DESC")or die(mysql_error());

while($jjexamlist_res= mysql_fetch_array($jjexamlist))
    {

      $sms="Exam Name:".$jjexamlist_res['exam_name'].","."Sub Exam Name:".$jjexamlist_res['subexamname'].","."Subject:".$jjexamlist_res['subject_name'].","."From Time:".$jjexamlist_res['from_time'].","."Total Marks:".$jjexamlist_res['total_marks'].","."Duration:".$jjexamlist_res['duration'];


$edate = $jjexamlist_res['exam_date'];
      $str.='{"date":"exam","type":'.'"'.$edate.'","sms":'.'"'.$sms.'"},';
    } 



 echo substr($str,0,-1).']';

?>