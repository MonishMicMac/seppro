<?php
include("connect.php"); 

$date=$_REQUEST['date'];


$type=$_REQUEST['type'];












$strSQL = "SELECT reorting.id,reorting.amount,reorting.complaints,clinetcreation.id as clientid,reorting.typeofcall,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested FROM reorting,clinetcreation WHERE reorting.repid='0' AND reorting.tdate='$date' AND typeofcall='$type' AND reorting.clientid=clinetcreation.id";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['productrequested'].")");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];
		
		array_push($resultArray,$arrCol);
	}
	echo json_encode($resultArray);





?>