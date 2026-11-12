<?php
include "../includes/connect_db.php";
$phoneno= $_REQUEST['phoneno'];

$cdate=date("Y-m-d");

$jjsms = mysql_query("SELECT * FROM student_profile WHERE Phone_no='$phoneno'")or die(mysql_error());
while($jjsms_res = mysql_fetch_array($jjsms))
{

$jjpand = mysql_query("SELECT * FROM student_profile WHERE Phone_no='$phoneno' AND standard_id='".$jjsms_res['Standard_id']."' AND section_id='".$jjsms_res['Section_id']."'")or die(mysql_error());
$jjpan_res= mysql_fetch_array($jjpand);
$messagedate = $jjpan_res['messagedate'];

if($messagedate == '0')
{

$jjassmnt = mysql_query("SELECT * FROM assignment WHERE standard_id='".$jjsms_res['Standard_id']."' AND section_id='".$jjsms_res['Section_id']."' AND assignment_date='".date("Y-m-d")."'")or die(mysql_error());
$jjassmnt_count = mysql_num_rows($jjassmnt);
if($jjassmnt_count >0)
{
	while($jjassmnt_res = mysql_fetch_array($jjassmnt))
	{
		 $subject=$jjassmnt_res['subject']."%0A";
		 $portion = "Notes:".$jjassmnt_res['description']."%0A";
		// $deadlinedate = "Submission Date:".$jjassmnt_res['assignment_date'];
		 $mobile=$phoneno;
		$jjmissedsms=$subject.$portion;
		 
		$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobile."&sender=KRMPSP&message=".urlencode($jjmissedsms));
		$data = curl_exec($ch);
		curl_close($ch);
mysql_query("UPDATE student_profile SET messagedate='$cdate',messagesent='1' WHERE Standard_id='".$jjsms_res['Standard_id']."' AND Section_id='".$jjsms_res['Section_id']."' AND Phone_no='$phoneno'")or die(mysql);
	}

}
else
{
$content = "No home work for ";
$name = $jjsms_res['Name'].$jjsms_res['Last_name'];
$nomsg = $content.$name;
$nomobile=$phoneno;

$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$nomobile."&sender=KRMPSP&message=".urlencode($nomsg));
		$data = curl_exec($ch);
		curl_close($ch);
mysql_query("UPDATE student_profile SET messagedate='$cdate',messagesent='1' WHERE Standard_id='".$jjsms_res['Standard_id']."' AND Section_id='".$jjsms_res['Section_id']."' AND Phone_no='$phoneno'")or die(mysql);
}
}
else
{
       if($messagedate==$cdate)
        {
             
        }
        else
         {
             $jjassmnt = mysql_query("SELECT * FROM assignment WHERE standard_id='".$jjsms_res['Standard_id']."' AND section_id='".$jjsms_res['Section_id']."' AND assignment_date='".date("Y-m-d")."'")or die(mysql_error());
$jjassmnt_count = mysql_num_rows($jjassmnt);
if($jjassmnt_count >0)
{
	while($jjassmnt_res = mysql_fetch_array($jjassmnt))
	{
		 $subject=$jjassmnt_res['subject']."%0A";
		 $portion = "Notes:".$jjassmnt_res['description']."%0A";
		// $deadlinedate = "Submission Date:".$jjassmnt_res['assignment_date'];
		 $mobile=$phoneno;
		$jjmissedsms=$subject.$portion;
		 
		$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$mobile."&sender=KRMPSP&message=".urlencode($jjmissedsms));
		$data = curl_exec($ch);
		curl_close($ch);
mysql_query("UPDATE student_profile SET messagedate='$cdate',messagesent='1' WHERE Standard_id='".$jjsms_res['Standard_id']."' AND Section_id='".$jjsms_res['Section_id']."' AND Phone_no='$phoneno'")or die(mysql);
	}

}
else
{
$content = "No home work for ";
$name = $jjsms_res['Name'].$jjsms_res['Last_name'];
$nomsg = $content.$name;
$nomobile=$phoneno;

$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Ae28876d83013f180c9472db964a368d8&to=".$nomobile."&sender=KRMPSP&message=".urlencode($nomsg));
		$data = curl_exec($ch);
		curl_close($ch);
mysql_query("UPDATE student_profile SET messagedate='$cdate',messagesent='1' WHERE Standard_id='".$jjsms_res['Standard_id']."' AND Section_id='".$jjsms_res['Section_id']."' AND Phone_no='$phoneno'")or die(mysql);
}
           
         }
}
}
?>