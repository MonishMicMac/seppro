<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];



$strSQL = "SELECT student_id,stuname FROM  student_attendance where day= '$day' AND month= '$month' AND year= '$year'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		if($i==1)
		{
		$handle_subject=$obResult[$i];
		if($handle_subject!='')
		{
		$subject_name='';
		$explode_handle_subject=explode(',',$handle_subject);
		foreach($explode_handle_subject as $value)
		{

		$a=mysql_query("select Name from student_profile where stu_id='$value'");
		$row_a=mysql_fetch_array($a);
		$subject_name.=$row_a['Name'].',';
		}
		$org_subject_name=rtrim($subject_name, ",");
		$arrCol[mysql_field_name($objQuery,$i)] = $org_subject_name;
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
			
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	echo json_encode($resultArray);

?>