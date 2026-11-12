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


       $assphoneno = mysql_query("SELECT * FROM assignment WHERE standard_id='".$jjchk_res['Standard_id']."' AND section_id='".$jjchk_res['Section_id']."' AND assignment_date IN('".date('Y-m-d')."','".date('Y-m-d', strtotime(' -1 day'))."')")or die(mysql_error());
$assphoneno_count = mysql_num_rows($assphoneno);
if($assphoneno_count > 0)
{
     while($assphoneno_res = mysql_fetch_array($assphoneno))
      {
       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A"; 
       $assdate = "Assignment Date:".$assphoneno_res['assignment_date']."%0A";
       $subject = "Subject:".$assphoneno_res['subject']."%0A";
       $desc ="Homework:".$assphoneno_res['description']."%0A";
       $page =  "Page:".$assphoneno_res['pageno']."%0A";
       $lastdate = "Submission Date:".$assphoneno_res['deadline_date'];

      $message=$name.$standard.$id.$assdate.$subject.$desc.$page.$lastdate;
      $mobile=$jjchk_res['Phone_no'];
     /* $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobile."&sender=KRMPSP&message=".urlencode($message));
      $data = curl_exec($ch);
      curl_close($ch);*/

mysql_query("UPDATE student_profile SET missedcall_status='1',missedcall_date='".date('Y-m-d')."' WHERE Phone_no='".$_REQUEST['mobile']."'")or die(mysql_error());
      }

}
else
{
       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A";
       $con = "No homework";

       $messageel=$name.$standard.$id.$con;
      $mobileel=$jjchk_res['Phone_no'];
      /*$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobileel."&sender=KRMPSP&message=".urlencode($messageel));
      $data = curl_exec($ch);
      curl_close($ch);*/
}
    }

    

    if($jjchk_res['Mother_phone_no']==$_REQUEST['mobile'])
    {

       $assmotherphoneno = mysql_query("SELECT * FROM assignment WHERE standard_id='".$jjchk_res['Standard_id']."' AND section_id='".$jjchk_res['Section_id']."' AND assignment_date IN('".date('Y-m-d')."','".date('Y-m-d', strtotime(' -1 day'))."')")or die(mysql_error());
$assmotherphoneno_count = mysql_num_rows($assmotherphoneno);
if($assmotherphoneno_count> 0)
{
     while($assmotherphoneno_res = mysql_fetch_array($assmotherphoneno))
      {

       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A"; 
       $assdate = "Assignment Date:".$assmotherphoneno_res['assignment_date']."%0A";
       $subject = "Subject:".$assmotherphoneno_res['subject']."%0A";
       $desc ="Homework:".$assmotherphoneno_res['description']."%0A";
       $page =  "Page:".$assmotherphoneno_res['pageno']."%0A";
       $lastdate = "Submission Date:".$assmotherphoneno_res['deadline_date'];

      $messagemo=$name.$standard.$id.$assdate.$subject.$desc.$page.$lastdate;
      $mobilemo=$jjchk_res['Phone_no'];
     /* $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobilemo."&sender=KRMPSP&message=".urlencode($messagemo));
      $data = curl_exec($ch);
      curl_close($ch);*/

mysql_query("UPDATE student_profile SET missedcall_status='1',missedcall_date='".date('Y-m-d')."' WHERE Phone_no='".$_REQUEST['mobile']."'")or die(mysql_error());
    }
}
else
{
       $name = "Name:".$jjchk_res['Name']."%0A";
       $standard = "Standard:".$jjchk_res['standard_name']."-".$jjchk_res['section_name']."%0A";
       $id = "StudentID:".$jjchk_res['student_id']."%0A";
       $con1 = "No homework";
       $messageelmo=$name.$standard.$id.$con1;
      $mobileelmo=$jjchk_res['Phone_no'];
      /*$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobileelmo."&sender=KRMPSP&message=".urlencode($messageelmo));
      $data = curl_exec($ch);
      curl_close($ch);*/
}
    }
}

}
else
{
echo "no record found";
}
?>