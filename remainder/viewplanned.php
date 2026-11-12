<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$status=$_REQUEST['status'];

if($status=='1')
{
$strSQL = "SELECT clinetcreation.id,clinetcreation.id as clientid,clinetcreation.name,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.type,clinetcreation.mobileno,reorting.scheduleddate,reorting.scheduledtime FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.tdate='$date' AND clinetcreation.id=reorting.clientid";




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
}
else if($status=='2')

{
$strSQL = "SELECT reorting.id,clinetcreation.id as clientid,clinetcreation.name,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.type,clinetcreation.mobileno,reorting.reporteddate,reorting.reportedtime,reorting.amountcollected FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.tdate='$date' AND reorting.attendance='1' AND clinetcreation.id=reorting.clientid";




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
}
else if($status=='3')

{
$strSQL = "SELECT reorting.id,clinetcreation.id as clientid,clinetcreation.name,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.type,clinetcreation.mobileno,reorting.scheduleddate,reorting.scheduledtime FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.tdate='$date' AND reorting.attendance='0' AND clinetcreation.id=reorting.clientid";




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
}





?>