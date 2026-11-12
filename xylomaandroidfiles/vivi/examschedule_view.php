<?php
include("connectsms.php");


$stdid=$_REQUEST['stdid'];
$secid=$_REQUEST['secid'];







$lid=$_REQUEST['lid'];



$jjexam = "SELECT mst_sub.sub_name,class_test.ct_id,class_test.test_name,class_test.ctmaxmarks,class_test.ctexamdate,class_test.ctexamdate,class_test.ctsession,class_test.ctportions FROM mst_sub,class_test WHERE class_test.ctstd='$stdid' and class_test.ctsec = '$secid'  AND class_test.ct_id>'$lid'  AND mst_sub.sub_id=class_test.ctsub ORDER BY class_test.ct_id ASC";


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