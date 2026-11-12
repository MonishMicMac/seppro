<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

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
				



				
		
				
			}

?>