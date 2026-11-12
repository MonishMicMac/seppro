<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];


/*echo "SELECT id,name,address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation where repid='$pid'";
exit();*/




// $strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation WHERE (type='PRIVATE' OR type_1='Marketing')";


$wp_rep_id_check = mysql_query("SELECT cus_add_status, cus_view_status FROM representative WHERE id='$pid' ")or die(mysql_error());

$rep_or_marketer =  mysql_fetch_array($wp_rep_id_check);

$rep_or_mark  = 0;
if($rep_or_marketer['cus_add_status'] == 1 && $rep_or_marketer['cus_view_status'] == 1){
	$rep_or_mark  = 1;
}

if($rep_or_mark == 1){

	// $strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation WHERE type_1='Marketing' AND repid='$pid' ";

	$strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation WHERE type_1='Marketing' ";

}else{

	// $strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation WHERE repid='$pid' ";

	$strSQL = "SELECT id,desgination,name1,NAME1DESIG,name2,mobileno1,emailid1,name,CONCAT(address,',',Addrtess_line1,',',Addrtess_line2) as address,typeofcustomer,pincode,type,mobileno,repid,date,time,companyname,latts,longgs,emailid,landmark,IFNULL((select rep_name from representative where id =clinetcreation.repid),'No NAME') as rep_name FROM clinetcreation ";

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