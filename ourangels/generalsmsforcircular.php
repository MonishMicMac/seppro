<?php
include("../includes/connect_db.php");

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
$msg = str_replace('"',"'",$sms);
$bdate = $jjsmsreport_res['bulksms_date'];
      $str.='{"date":"circular","type":'.'"'.$bdate.'","sms":'.'"'.$msg.'"},';
    } 


     echo substr($str,0,-1).']';

}


?>