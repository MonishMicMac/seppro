<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$start5=0;
$text_line = $_REQUEST['text_line'];
$text_line = explode(",",$text_line);

for ($start=0; $start < count($text_line); $start++) 
{

$text_line1 = $_REQUEST['text_line1'];
$text_line1 = explode(":",$text_line1);
for ($start1=0; $start1 < count($text_line1); $start1++) 
{





$text_line3 = $text_line1[$start1];
$text_line3 = explode(",",$text_line3);
for ($start2=0; $start2 < count($text_line3); $start2++) 
{




$stu = "SELECT Father_phone_no FROM student_profile WHERE standard_id='".$text_line[$start5]."' AND section_id='".$text_line3[$start2]."' GROUP BY Father_phone_no";
		$stu_rs = mysql_query($stu);
		echo mysql_error();
			while($yuvaraj=mysql_fetch_object($stu_rs)){
				
				$mobile = $yuvaraj->Father_phone_no;

				$com_mobile=urlencode($mobile);
                               
				$message=urlencode($_REQUEST["msg"]);
				$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A1559734c81f9c9f8dc0ce9fbcb1812fb&to=".$com_mobile."&sender=SORNML&message=".$message);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				$data = curl_exec($ch);
				
		
				
			}







}

$start5++;




}


exit;

}






			

?>