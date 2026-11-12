<?php

include("connect.php"); 






$strSQL = "SELECT reorting.pickups,reorting.repservice,reorting.productrequested,reorting.reasonforservice,reorting.reporteddate,reorting.repid,reorting.reportedtime,clinetcreation.mobileno,clinetcreation.pincode,clinetcreation.companyname,reorting.id,clinetcreation.id as clientid,clinetcreation.name,reorting.repreportedpro FROM reorting,clinetcreation WHERE reorting.incompletecall ='1' AND clinetcreation.id=reorting.clientid";
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

 $sqls1=mysql_query("SELECT rep_name  FROM representative WHERE id =".$arrCol['repid']."");
		$rows1=mysql_fetch_array($sqls1);
		$arrCol['rep_name']=$rows1['rep_name'];



		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>