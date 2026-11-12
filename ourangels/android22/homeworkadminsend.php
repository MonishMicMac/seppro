<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$std=$_REQUEST["std"];


$section=$_REQUEST["section"];
$joel=explode("^",$section);
$Message= $_REQUEST["Message"];
$msg = explode("^",$Message);
for ($i=0; $i <count($joel); $i++) 
{
	
$stu = "SELECT Father_phone_no FROM student_profile WHERE Standard_id='".$std."' AND Section_id='".$joel[$i]."' GROUP BY Father_phone_no";
		$stu_rs = mysql_query($stu);
		echo mysql_error();
			while($yuvaraj=mysql_fetch_object($stu_rs)){
				
				$mobile= $yuvaraj->Father_phone_no;

				$messages=str_replace("$","%0A",$msg[$i]);
                               
                             

                        
$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=$mobile&sender=KALIGI&message=".$messages);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);    
                             
                             

                             
}

}

				
			
?>