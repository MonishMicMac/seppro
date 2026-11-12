<?php
include("connectsms.php");


//$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
//mysql_select_db($_REQUEST['db'],$con);
//date_default_timezone_set('Asia/Calcutta');

$jjstu = mysql_query("SELECT * FROM student_profile WHERE stu_id='".$_REQUEST['stuid']."'")or die(mysql_error());
$jjtu_res = mysql_fetch_array($jjstu);

echo '[';
global $str;

$jjsmsreport = mysql_query("SELECT * FROM `tbl_bulksms_details` WHERE status = 0 AND `section` LIKE '%".$jjtu_res['Standard_id'].",%' AND `section` LIKE '%, ".$jjtu_res['Section_id'] ."%' ORDER BY bulksms_id DESC")or die(mysql_error()); 
$jjsmsreport_count = mysql_num_rows($jjsmsreport);
if($jjsmsreport_count>0)
{
  while($jjsmsreport_res = mysql_fetch_array($jjsmsreport))
  {

    $sms=$jjsmsreport_res['msg'];
    $youtube_link=$jjsmsreport_res['youtube_link'];
    $msg = str_replace('"',"'",$sms);
    $bdate = $jjsmsreport_res['bulksms_date'];
    $str.='{"date":"circular","type":'.'"'.$bdate.'","sms":'.'"'.$msg.'","youtube_link":'.'"'.$youtube_link.'"},';
  } 

}

$jjsmsreport1 = mysql_query("SELECT * FROM `stu_individual_sms` WHERE `student_id` LIKE '%".$_REQUEST['stuid']."%' ORDER BY `stu_individual_sms`.`date` DESC")or die(mysql_error()); 
$jjsmsreport_count1 = mysql_num_rows($jjsmsreport1);
if($jjsmsreport_count1>0)
{
  while($jjsmsreport_res1 = mysql_fetch_array($jjsmsreport1))
  {

    $sms1=$jjsmsreport_res1['message'];
    $youtube_link=$jjsmsreport_res1['youtube_link'];
    $msg1 = str_replace('"',"'",$sms1);
    $bdate1 = $jjsmsreport_res1['date'];
    $str.='{"date":"circular","type":'.'"'.$bdate1.'","sms":'.'"'.$msg1.'","youtube_link":'.'"'.$youtube_link.'"},';
  } 




}

echo substr($str,0,-1).']';
?>
