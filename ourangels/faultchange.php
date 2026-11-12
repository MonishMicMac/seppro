<?php

include("../includes/connect_db.php");


$standardid= $_POST['standardid'];
$sectionid= $_POST['sectionid'];
$day= $_POST['day'];
$month= $_POST['month'];
$year= $_POST['year'];
$test=$_POST['test'];



if($test=='MA')
{
$morning= 'A';

$strSQL = "SELECT * FROM  student_attendance where standardid= '".$standardid."' AND sectionid= '".$sectionid."' AND day= '".$day."' AND month= '".$month."' AND year= '".$year."' AND morning= '".$morning."'";
}
else
{
$morning= 'A';
$strSQL = "SELECT * FROM  student_attendance where standardid= '".$standardid."' AND sectionid= '".$sectionid."' AND day= '".$day."' AND month= '".$month."' AND year= '".$year."' AND afternoon= '".$morning."'";
}




$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		if($i==4)
		{
		
	 $stuname=$obResult[$i]; 
		if($stuname!='')
		{
		$subject_name='';
		$explode_handle_subject=explode(',',$stuname);
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






















































