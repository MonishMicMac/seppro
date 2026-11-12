<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
$date=$_REQUEST['date'];



$strSQL = "SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		$sql=mysql_query("SELECT count(*) as pro_name  FROM reorting WHERE repid=".$arrCol['id']." AND tdate='$date' AND typeofcall='SERVICE CALL'");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];


$sqlq=mysql_query("SELECT count(*) as sales  FROM reorting WHERE repid=".$arrCol['id']." AND tdate='$date' AND typeofcall='SALES CALL'");
		$rowq=mysql_fetch_array($sqlq);
		$arrCol['sales']=$rowq['sales'];


$sqlq11=mysql_query("SELECT count(*) as enquiry  FROM enquiry WHERE repid=".$arrCol['id']." AND date='$date'");
		$rowq11=mysql_fetch_array($sqlq11);
		$arrCol['enquiry']=$rowq11['enquiry'];

		
		array_push($resultArray,$arrCol);
	}
	echo json_encode($resultArray);



?>