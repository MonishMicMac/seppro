<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];

$acayear = date("Y")."-".date("Y",strtotime("+1 year"));



$jjexam = "SELECT * FROM tbl_progressreport,mst_subexamname,mst_examname WHERE tbl_progressreport.student_id='$studid' AND tbl_progressreport.academicyear='$acayear' AND  tbl_progressreport.exam_id=mst_examname.en_id AND tbl_progressreport.subexam_id=mst_subexamname.senid ORDER BY pid DESC";

$objQuery = mysql_query($jjexam);
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