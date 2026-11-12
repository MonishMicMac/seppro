<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$filename= $_REQUEST['filename'];
$s_id= $_REQUEST['s_id'];
$s_id= explode(",",$s_id);

for ($start=0; $start < count($s_id); $start++) 
{


$stu = "SELECT Phone_no FROM staff_profile WHERE s_id='".$s_id[$start]."' GROUP BY Phone_no";
		$stu_rs = mysql_query($stu);
		echo mysql_error();
			while($yuvaraj=mysql_fetch_object($stu_rs))
{
				
				$mobile = $yuvaraj->Phone_no;

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