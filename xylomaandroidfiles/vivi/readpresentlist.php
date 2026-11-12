<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];

$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$strSQL = "SELECT * FROM student_attendance where standardid='$standard_id' and sectionid='$section_id' and day='$day' and month='$month' and year='$year'";

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
	
	echo '{"present":'.json_encode($resultArray).',"success":1}';

?>