<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
 






$strSQL = "SELECT reorting.id,reorting.remarks,reorting.repid,reorting.sparepartneeded,reorting.pickups,reorting.reportedtime,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.reporteddate,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.clientid='$id' AND reorting.clientid=clinetcreation.id ORDER BY reorting.tdate,reorting.scheduledtime DESC";

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


$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['productrequested'].")");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];

$sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].")");
		$rows=mysql_fetch_array($sqls);
		$arrCol['reppro_name']=$rows['pro_name'];


$sqlss=mysql_query("SELECT GROUP_CONCAT(rep_name) as rep_name FROM representative WHERE id IN (".$arrCol['repid'].")");
		$rowss=mysql_fetch_array($sqlss);
		$arrCol['nameofrep']=$rowss['rep_name'];



                    $arrCol['repnames'] = $repname." - ".$num_rowss;
		array_push($resultArray,$arrCol);
	}

echo json_encode($resultArray);
	

	


?>