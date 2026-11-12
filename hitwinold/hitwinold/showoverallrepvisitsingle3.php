<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
 $date=$_REQUEST['date'];













$strSQL = "SELECT reorting.id,reorting.remarks,reorting.reportedtime,reorting.comingtime,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested FROM reorting,clinetcreation WHERE reorting.repid='$id' AND reorting.tdate='$date'  AND reorting.clientid=clinetcreation.id";

 


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
                $arrCol['repnames'] = $repname." - ".$num_rowss;
		array_push($resultArray,$arrCol);
	}


	echo json_encode($resultArray);
	


?>