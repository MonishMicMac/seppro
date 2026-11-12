<?php

include("connectsms.php");

$phonenumber = $_REQUEST['phonenumber'];



//$jjxx = mysql_query("SELECT * FROM student_profile WHERE Phone_no= '$phonenumber' OR Father_phone_no= '$phonenumber' OR Mother_phone_no= '$phonenumber'") or die(mysql_error());
//$jjxx_count = mysql_num_rows($jjxx);

//mysql_query("UPDATE student_profile SET activationpassword='12345' WHERE Phone_no='$phonenumber'");


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