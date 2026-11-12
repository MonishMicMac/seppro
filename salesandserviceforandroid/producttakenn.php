<?php

include("connect.php"); 




$repid=$_REQUEST['repid'];

$strSQL = "SELECT reorting.pickups,reorting.repservice,reorting.productrequested,reorting.reasonforservice,reorting.reporteddate,reorting.reportedtime,clinetcreation.mobileno,clinetcreation.pincode,clinetcreation.companyname,reorting.id,clinetcreation.id as clientid,clinetcreation.name,reorting.repreportedpro FROM reorting,clinetcreation WHERE reorting.incompletecall ='1' AND reorting.repid='$repid' AND clinetcreation.id=reorting.clientid";
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

             $sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].")");
		$rows=mysql_fetch_array($sqls);
		$arrCol['reppro_name']=$rows['pro_name'];



		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>