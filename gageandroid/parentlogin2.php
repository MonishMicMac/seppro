<?php
include("connectpon2.php");

$schoolid=$_REQUEST['schoolid'];

$Phone_no=$_REQUEST['Phone_no'];

// $strSQL = $je->prepare("SELECT `database`,school_id,db_pwd,db_user,db_host,school_app_url,school_logo,Curriculum,Achievements,Highlights,about FROM ymst_school WHERE school_id='$schoolid'");

$strSQL = "SELECT * FROM `temp_student_profile` WHERE `scholid`='$schoolid' and `temp_stud_mobile`='$Phone_no'";

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