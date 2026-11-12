<?php
include("connectsms.php");



$standid=$_REQUEST['standid'];
$secid=$_REQUEST['secid'];
$msg=$_REQUEST['msg'];

//$types="General";
//mysql_query("INSERT INTO tbl_bulksms_details (bulksms_type,staff_name,section,msg,bulksms_date,bulksms_time,status) VALUES ('".$types."','".$_SESSION["_LOG"]."','".$result."','".$_REQUEST["sms_msg"]."','".date("Y-m-d")."','".date("H:i:s")."','".$_REQUEST["catgeory"]."')");


$stdsecnameid="SELECT Name,Phone_no,standard_name,section_name FROM student_profile WHERE Standard_id='$standid' AND Section_id='$secid'";
	$objQuery = mysql_query($stdsecnameid);
	while($obResult = mysql_fetch_object($objQuery))
	{
		$mobile = $obResult->Phone_no;
				$com_mobile=urlencode($mobile);
				$msg1="Dear parent,\n";
				$message=urlencode($msg1.$msg);
				$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=Aac4dfcca0d1a68bee41eb002f7dc57a3&to=".$com_mobile."&sender=SNMSSS&message=".urlencode($message));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				echo $data = curl_exec($ch);
				if($data === false)
				{
					echo 'Curl error: ' . curl_error($ch);
				}
				
		
	}	
		

?>