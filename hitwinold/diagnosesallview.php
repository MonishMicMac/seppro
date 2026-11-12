<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$clientid=$_REQUEST['clientid'];
$date=date('Y-m',strtotime($_REQUEST['date']));

$strSQL="SELECT * FROM diagnoses_add WHERE client_id='$clientid' AND DATE_FORMAT(from_date,'%Y-%m')='$date'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 if(mysql_field_name($objQuery,$i)=='product_id'){
		 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		 	$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN ($obResult[$i])");
			$row=mysql_fetch_array($sql);
			$arrCol['pro_name']=$row['pro_name'];
		 }
		 if(mysql_field_name($objQuery,$i)=='collect_product_id'){
		 	$obResult[$i]=trim($obResult[$i],",");
		 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		 	$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN ($obResult[$i])");
			$row=mysql_fetch_array($sql);
			$arrCol['collect_pro_name']=$row['pro_name'];
		 } else {
		 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		 }
		}
		array_push($resultArray,$arrCol);
	}
	
	
	
	echo json_encode($resultArray);
?>