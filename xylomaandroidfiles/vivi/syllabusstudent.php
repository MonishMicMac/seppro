<?php

include("connectsms.php");

$std_id=$_REQUEST['std_id'];
$sub_id=$_REQUEST['sub_id'];

$strSQL= "SELECT syllabus_id,concat(syllabus_bookname,' - ',syllabus_subject_author) as book_author FROM mst_syllabus as a WHERE syllabus_std_id='$std_id' AND syllabus_subject_id='$sub_id'";
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