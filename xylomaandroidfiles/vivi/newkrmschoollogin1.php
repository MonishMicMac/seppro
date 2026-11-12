<?php
include("connectsms.php");

$phonenumber = $_REQUEST['phonenumber'];
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

	$msg_array1=array();
	$sql="SELECT * FROM mst_geneal_information WHERE std_id='".$arrCol['Standard_id']."' AND CONCAT(',',sec_id,',') LIKE '%,".$arrCol['Section_id'].",%'";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$msg_array = array();
		$msg_array['heading']=$row['heading'];
		$msg_array['message']=$row['message'];
		$msg_array['date']=$row['date'];
		$msg_array['status']=$row['status'];

		array_push($msg_array1,$msg_array);
	}
	$arrCol['messages']=$msg_array1;

	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);
?>