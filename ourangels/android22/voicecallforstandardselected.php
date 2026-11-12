<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$filename= $_REQUEST['filename'];
$standard_id= $_REQUEST['standard_id'];
$standard_id = explode(",",$standard_id);

for ($start=0; $start < count($standard_id); $start++) 
{


$stu = "SELECT Father_phone_no FROM student_profile WHERE standard_id='".$standard_id[$start]."' GROUP BY Father_phone_no";
		$stu_rs = mysql_query($stu);
		echo mysql_error();
			while($yuvaraj=mysql_fetch_object($stu_rs)){
				
				$mobile = $yuvaraj->Father_phone_no;

				$com_mobile=urlencode($mobile);
                               
				echo $mob = "91".$com_mobile;

                              $ch1=curl_init("http://vapi.unicel.in/voiceapi?request=voiceobd&uname=micmacvoi&pass=t3J%28i8z8&obdid=422&type=D&dest=$mob&msgtype=P&msg=$filename");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
$response1=curl_exec($ch1);
if (curl_errno($ch1)) {
      print curl_error($ch1);
  }
curl_close($ch1);                                
echo $response1;
				
			}

}




			

?>