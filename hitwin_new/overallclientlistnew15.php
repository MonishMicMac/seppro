<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];


/*echo "SELECT id,name,address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation where repid='$pid'";
exit();*/
$sql_chk_admin=mysql_query("SELECT id FROM representative WHERE id='".$pid."' AND adminon='1'")or die(mysql_error());
if(mysql_num_rows($sql_chk_admin)==0){

	$callcount=mysql_query("SELECT GROUP_CONCAT(repid) AS repid FROM assigningreptomanager WHERE managerid='".$pid."'")or die(mysql_error());
	$callcount_row=mysql_fetch_array($callcount);

	$strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,address,Addrtess_line1 as address1,Addrtess_line2 as address2,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation where repid IN (".$callcount_row['repid'].")";
} else {
	// echo "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,address,Addrtess_line1 as address1,Addrtess_line2 as address2,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation where repid IN (select id from representative WHERE adminon='0')";
	$strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,address,Addrtess_line1 as address1,Addrtess_line2 as address2,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation where repid ='".$pid."'";
}

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