<?php
include("connect.php"); 
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$pid=$_REQUEST['pid'];

// echo "SELECT id,name,address,Addrtess_line1,Addrtess_line2,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation ";

$strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation ";




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
		// $Y = mysql_query("SELECT * FROM reorting WHERE clientid='".$obResult['id']."' ORDER BY id DESC ");
		// $Pg = mysql_fetch_array($Y);
		// $arrCol["visitdate"] = $Pg['reporteddate'];
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>
