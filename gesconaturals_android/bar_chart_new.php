<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];


global $missedcount,$notvisitedcount;

$totalvistedwithoutrepeatedcount='0';

$full_date=date("Y-m-d",strtotime($date));

$strSQL = "SELECT id,doc_contact_no,doctor_name,doc_pincode,email FROM doctors1 where rep_id='".$_REQUEST['rep_id']."'  ";




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

		// echo "SELECT b.id as product_id, b.pro_name as product_name, (CASE WHEN d.qty IS NULL THEN 0 ELSE d.qty END) as qty, (CASE WHEN d.self IS NULL THEN 0 ELSE d.self END) as self, (CASE WHEN d.open IS NULL THEN 0 ELSE d.open END) as open, (CASE WHEN d.close IS NULL THEN 0 ELSE d.close END) as close,(CASE WHEN d.client_id IS NULL THEN 0 ELSE d.client_id END) as client_id FROM product b LEFT JOIN (SELECT a.productid, a.qty, a.self, a.open, a.close,a.client_id FROM pobbooking a INNER JOIN (SELECT max(cdate) as cdate FROM pobbooking WHERE client_id=\"".$obResult["id"]."\") c ON a.cdate=c.cdate WHERE a.client_id=\"".$obResult["id"]."\") d on d.productid=b.id ";
// echo "SELECT b.id as product_id, b.pro_name as product_name, (CASE WHEN d.qty IS NULL THEN 0 ELSE d.qty END) as qty, (CASE WHEN d.self IS NULL THEN 0 ELSE d.self END) as self, (CASE WHEN d.open IS NULL THEN 0 ELSE d.open END) as open, (CASE WHEN d.close IS NULL THEN 0 ELSE d.close END) as close,(CASE WHEN d.client_id IS NULL THEN 0 ELSE d.client_id END) as client_id FROM product b LEFT JOIN (SELECT a.productid, a.qty, a.self, a.open, a.close,a.client_id FROM pobbooking_order a INNER JOIN (SELECT max(cdate) as cdate FROM pobbooking_order WHERE client_id=\"".$obResult["id"]."\") c ON a.cdate=c.cdate WHERE a.client_id=\"".$obResult["id"]."\") d on d.productid=b.id AND b.state_id='".$_REQUEST['sta_id']."' ORDER BY b.id";

		$objQuery1 = mysql_query("SELECT b.id as product_id, b.pro_name as product_name, (CASE WHEN d.qty IS NULL THEN 0 ELSE d.qty END) as qty, (CASE WHEN d.self IS NULL THEN 0 ELSE d.self END) as self, (CASE WHEN d.open IS NULL THEN 0 ELSE d.open END) as open, (CASE WHEN d.close IS NULL THEN 0 ELSE d.close END) as close,(CASE WHEN d.client_id IS NULL THEN 0 ELSE d.client_id END) as client_id FROM product b LEFT JOIN (SELECT a.productid, a.qty, a.self, a.open, a.close, a.client_id FROM pobbooking_order a INNER JOIN (SELECT max(cdate) as cdate FROM pobbooking_order WHERE client_id=\"".$obResult["id"]."\") c ON a.cdate=c.cdate WHERE a.client_id=\"".$obResult["id"]."\") d on d.productid=b.id WHERE b.state_id=\"".$_REQUEST['sta_id']."\" ORDER BY b.id");
		$intNumField1 = mysql_num_fields($objQuery1);
		$resultArray1 = array();
		while($obResult1 = mysql_fetch_array($objQuery1))
		{
			$arrCol1 = array();
			for($i=0;$i<$intNumField1;$i++)
			{
				$arrCol1[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
			}	
			$arrCol1["client_id"] = $obResult["id"];	
			array_push($resultArray1,$arrCol1);
		}
		$arrCol["sales"] = $resultArray1;
		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	echo json_encode($resultArray);	
	
	
	
?>