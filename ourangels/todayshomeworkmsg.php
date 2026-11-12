<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$stu = "SELECT Father_phone_no FROM student_profile WHERE Standard_id=".$_REQUEST["std_id"]." AND Section_id=".$_REQUEST["sec_id"]." GROUP BY Father_phone_no";
		$stu_rs = mysql_query($stu);
		echo mysql_error();
			while($yuvaraj=mysql_fetch_object($stu_rs)){
				
				$mobile = $yuvaraj->Father_phone_no;

				$com_mobile=urlencode($mobile);
                                $messages=str_replace("$","%0A",$_REQUEST["msg"]);
				$message=urlencode($messages);
				


$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=".$com_mobile."&sender=KALIGI&message=".$message);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);
				
		
				
			}

?>