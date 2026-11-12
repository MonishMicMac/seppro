<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$status=$_REQUEST['status'];

if($status=='1')
{











$strSQL = "SELECT reorting.id,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

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
}
else if($status=='2')

{







$strSQL = "SELECT reorting.id,reorting.remarks,clinetcreation.id as clientid,reorting.reportedtime,reorting.sparepartneeded,reorting.pickups,reorting.comingtime,reorting.complaints,reorting.amount,reorting.comingtime,reorting.reporteddate,reorting.scheduleddate,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.attendance='1' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

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

$sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].")");
		$rows=mysql_fetch_array($sqls);
		$arrCol['reppro_name']=$rows['pro_name'];
		
		array_push($resultArray,$arrCol);
	}
	
	echo json_encode($resultArray);







}
else if($status=='3')

{








$strSQL = "SELECT reorting.id,clinetcreation.id as clientid,reorting.remarks,reorting.comingtime,reorting.sparepartneeded,reorting.pickups,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.scheduleddate,reorting.reportedtime,reorting.reporteddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.attendance='0' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.scheduledtime DESC";

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


}





?>