<?php
include("connectsms.php"); 

$acy=$_REQUEST['acy'];

$subjectid=$_REQUEST['subjectid'];

$examid=$_REQUEST['examid'];

$subexamid=$_REQUEST['subexamid'];

$ex_portion=$_REQUEST['ex_portion'];

$ex_date=$_REQUEST['ex_date'];

$ex_af=$_REQUEST['ex_af'];

$ex_marks=$_REQUEST['ex_marks'];

$cdate=$_REQUEST['cdate'];

$stdid=$_REQUEST['stdid'];

$secid=$_REQUEST['secid'];

$staffid=$_REQUEST['staffid'];

$lid=$_REQUEST['lid'];




$a=mysql_query("insert into class_test(ctsub,test_name,ctportions,ctexamdate,ctsession,ctmaxmarks,ctstd,ctsec,ctdatetime,staffid)values
('$subjectid','$examid','$ex_portion','$ex_date','$ex_af','$ex_marks','$stdid','$secid','$cdate','$staffid')")or die(mysql_error());


$lid=$_REQUEST['lid'];



$jjexam = "SELECT class_test.ct_id FROM mst_sub,class_test WHERE class_test.ctstd='$stdid' and class_test.ctsec = '$secid'  AND class_test.ct_id>'$lid'  AND mst_sub.sub_id=class_test.ctsub ORDER BY class_test.ct_id ASC";


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