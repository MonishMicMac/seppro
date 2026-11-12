<?php

include("connectsms.php");




$phonenumber=$_REQUEST['phonenumber'];
$activationpassword=$_REQUEST['activationcode'];




$strSQL= "SELECT * FROM student_profile WHERE (Phone_no= '$phonenumber' OR Father_phone_no= '$phonenumber' OR Mother_phone_no= '$phonenumber') AND activationpassword='$activationpassword'";




$objQuery = mysql_query($strSQL);
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