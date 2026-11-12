<?php

include("../includes/connect_db.php");

$jjchkfr = mysql_query("SELECT * FROM student_profile WHERE (Phone_no='".$_REQUEST['mobile']."' || Father_phone_no='".$_REQUEST['mobile']."' || Mother_phone_no='".$_REQUEST['mobile']."') AND missedcall_date='".date('Y-m-d')."'")or die(mysql_error());
$jjchkfr_count = mysql_num_rows($jjchkfr);
if($jjchkfr_count == 0)
{
$jjchk = mysql_query("SELECT * FROM student_profile WHERE (Phone_no='".$_REQUEST['mobile']."' || Father_phone_no='".$_REQUEST['mobile']."' || Mother_phone_no='".$_REQUEST['mobile']."') ")or die(mysql_error());
while($jjchk_res = mysql_fetch_array($jjchk))
{

   if($jjchk_res['Phone_no']==$_REQUEST['mobile'])
    {


       $assphoneno = mysql_query("SELECT * FROM tbl_bulksms_details WHERE `section` LIKE '%".$jjchk_res['Standard_id'].",%' AND `section` LIKE '%, ".$jjchk_res['Section_id'] ." /%' AND bulksms_date IN('".date('Y-m-d')."','".date('Y-m-d', strtotime(' -1 day'))."')")or die(mysql_error());
$assphoneno_count = mysql_num_rows($assphoneno);
if($assphoneno_count > 0)
{
     while($assphoneno_res = mysql_fetch_array($assphoneno))
      {
       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A"; 
       $assdate = "Assignment Date:".$assphoneno_res['bulksms_date']."%0A";
 
       $desc ="Homework:".$assphoneno_res['msg']."%0A";
       

      $message=$name.$standard.$id.$assdate.$desc;
      $mobile=$jjchk_res['Phone_no'];
     $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobile."&sender=KRMPSP&message=".urlencode($message));
      $data = curl_exec($ch);
      curl_close($ch);

mysql_query("UPDATE student_profile SET missedcall_status='1',missedcall_date='".date('Y-m-d')."' WHERE Phone_no='".$_REQUEST['mobile']."'")or die(mysql_error());
      }

}
else
{
       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A";
       $con = "No homework";

       $messageel=$name.$standard.$con.$id;
     $mobileel=$jjchk_res['Phone_no'];
      $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobileel."&sender=KRMPSP&message=".urlencode($messageel));
      $data = curl_exec($ch);
      curl_close($ch);
}
    }

    

}

}
else
{
echo "no record found";
}
?>