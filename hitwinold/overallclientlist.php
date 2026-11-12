<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];







$strSQL = "SELECT id,name,address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation order by id DESC";// where repid='$pid'




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
?>