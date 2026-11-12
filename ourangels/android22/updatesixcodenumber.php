<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$student_id=$_REQUEST['student_id'];
$phoneno=$_REQUEST['phoneno'];
$activationcode=$_REQUEST['activationcode'];
	
	 
	$flag['code']=0;
	 
	if($r=mysql_query("UPDATE student_profile SET activationcode= '$activationcode' WHERE student_id='$student_id'",$con))
	{
		$flag['code']=1;

        $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=".$phoneno."&sender=KALIGI&message=".'Activation code:'.$activationcode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
	}
	 
	print(json_encode($flag));
	mysql_close($con);

?>