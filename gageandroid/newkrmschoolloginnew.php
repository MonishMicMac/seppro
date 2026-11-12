<?php

include("connectsms.php");

$phonenumber = $_REQUEST['phonenumber'];
$regId = $_REQUEST['regId'];


//$jjxx = mysql_query("SELECT * FROM student_profile WHERE Phone_no= '$phonenumber' OR Father_phone_no= '$phonenumber' OR Mother_phone_no= '$phonenumber'") or die(mysql_error());
//$jjxx_count = mysql_num_rows($jjxx);


if($regId!='')
{

	// $chk= mysql_query("SELECT * FROM student_profile WHERE Phone_no= '$phonenumber' OR Father_phone_no= '$phonenumber' OR Mother_phone_no= '$phoneumber'");
	$chk= mysql_query("SELECT * FROM student_profile WHERE Phone_no= '$phonenumber'");
    $chk_res=mysql_fetch_array($chk);
    if($chk_res['gcmid']=='')
    {
    	mysql_query("UPDATE student_profile SET gcmid='$regId' WHERE Phone_no='$phonenumber'");
    }
	

}



$jjxx = "SELECT * FROM student_profile WHERE Phone_no= '$phonenumber' OR Father_phone_no= '$phonenumber' OR Mother_phone_no= '$phonenumber'";


$objQuery = mysql_query($jjxx);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);





?>