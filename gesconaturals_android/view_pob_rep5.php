<?php

include("connect1.php");

$repid=$_REQUEST['repid'];

if($_REQUEST['status']=='1')
{
	$datemonth=date('Y-m-d');
}
elseif($_REQUEST['status']=='2')
{
	$datemonth=date('Y-m',strtotime($_REQUEST['curr_date']));
}

if($_REQUEST['stockistid']=='')
{
	$stid="";
	$stid1="";
}
elseif($_REQUEST['stockistid']!='' || $_REQUEST['stockistid']!='0')
{
	$stid="AND doctors.stockist_id='".$_REQUEST['stockistid']."'";
	$stid1="AND pobbooking_prime.stockistid='".$_REQUEST['stockistid']."'";
}


if($_REQUEST['pob']=='1')
{
	$strSQL = "SELECT pobbooking.qty,pobbooking.productid,product.pro_name,product.ptr,(pobbooking.cdate) As currentdate,(pobbooking.qty*product.ptr) AS totpob,pobbooking.client_id,doctors.doctor_name FROM pobbooking,product,doctors WHERE pobbooking.productid=product.id AND pobbooking.client_id=doctors.id AND pobbooking.`repid`='".$repid."' ".$stid."  AND pobbooking.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking.pob_id";
}
elseif($_REQUEST['pob']=='2')
{	

	// echo "SELECT pobbooking_prime.qty,pobbooking_prime.productid,product.pro_name,product.ptr,(pobbooking_prime.cdate) As currentdate,(pobbooking_prime.qty*product.ptr) AS totpob,pobbooking_prime.client_id FROM pobbooking_prime,product WHERE pobbooking_prime.productid=product.id  AND pobbooking_prime.`repid`='".$repid."' ".$stid1."  AND pobbooking_prime.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking_prime.pob_id";
	$strSQL = "SELECT pobbooking_prime.qty,pobbooking_prime.productid,product.pro_name,product.ptr,(pobbooking_prime.cdate) As currentdate,(pobbooking_prime.qty*product.ptr) AS totpob,pobbooking_prime.client_id FROM pobbooking_prime,product WHERE pobbooking_prime.productid=product.id  AND pobbooking_prime.`repid`='".$repid."' ".$stid1."  AND pobbooking_prime.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking_prime.pob_id";
}
elseif($_REQUEST['pob']=='3')
{
	$strSQL = "SELECT pobbooking_second.qty,pobbooking_second.productid,product.pro_name,product.ptr,(pobbooking_second.cdate) As currentdate,(pobbooking_second.qty*product.ptr) AS totpob,pobbooking_second.client_id,doctors.doctor_name FROM pobbooking_second,product,doctors WHERE pobbooking_second.productid=product.id AND pobbooking_second.client_id=doctors.id AND pobbooking_second.`repid`='".$repid."' ".$stid."  AND pobbooking_second.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking_second.pob_id";
}



// echo "SELECT pobbooking.qty,pobbooking.productid,product.pro_name,product.ptr,(pobbooking.qty*product.ptr) AS totpob,pobbooking.client_id,doctors.doctor_name FROM pobbooking,product,doctors WHERE pobbooking.productid=product.id AND pobbooking.client_id=doctors.id AND pobbooking.`repid`='".$repid."' AND pobbooking.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking.pob_id";




// echo "SELECT pobbooking.qty,pobbooking.productid,product.pro_name,product.ptr,(pobbooking.cdate) As currentdate,(pobbooking.qty*product.ptr) AS totpob,pobbooking.client_id,doctors.doctor_name FROM pobbooking,product,doctors WHERE pobbooking.productid=product.id AND pobbooking.client_id=doctors.id AND pobbooking.`repid`='".$repid."' ".$stid."  AND pobbooking.cdate LIKE '%".$datemonth."%' GROUP BY pobbooking.pob_id";





$objQuery = mysql_query($strSQL);
$intNumField = mysql_num_fields($objQuery);
$resultArray = array();
while($obResult = mysql_fetch_array($objQuery))
{
	$totcomform2=0;
	$totcomform=0;
	$totcomformpdt=0;
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
	}

	if($_REQUEST['pob']=='1')
	{
		$monthpobtotal1=mysql_query("SELECT GROUP_CONCAT(pobbooking.qty) AS qty,GROUP_CONCAT(pobbooking.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking.qty*product.ptr) AS totpob,pobbooking.client_id,doctors.doctor_name,(select doctor_name from doctors1 where doctors1.id=doctors.stockist_id) AS stockist_name FROM pobbooking,product,doctors WHERE pobbooking.productid=product.id AND pobbooking.client_id=doctors.id AND pobbooking.`repid`='".$repid."' AND pobbooking.cdate LIKE '%".$datemonth."%' AND pobbooking.client_id='".$obResult['client_id']."'");


		$monthpobtotal12=mysql_query("SELECT GROUP_CONCAT(pobbooking.qty) AS qty,GROUP_CONCAT(pobbooking.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking.qty*product.ptr) AS totpob,pobbooking.client_id,doctors.doctor_name FROM pobbooking,product,doctors WHERE pobbooking.productid=product.id AND pobbooking.client_id=doctors.id AND pobbooking.`repid`='".$repid."' AND pobbooking.cdate LIKE '%".$datemonth."%' ");
	}
	elseif($_REQUEST['pob']=='2')
	{
		$monthpobtotal1=mysql_query("SELECT GROUP_CONCAT(pobbooking_prime.qty) AS qty,GROUP_CONCAT(pobbooking_prime.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking_prime.qty*product.ptr) AS totpob,pobbooking_prime.client_id,(select doctor_name from doctors1 where doctors1.id=pobbooking_prime.stockistid) AS stockist_name FROM pobbooking_prime,product WHERE pobbooking_prime.productid=product.id  AND pobbooking_prime.`repid`='".$repid."' AND pobbooking_prime.cdate LIKE '%".$datemonth."%' ");


		$monthpobtotal12=mysql_query("SELECT GROUP_CONCAT(pobbooking_prime.qty) AS qty,GROUP_CONCAT(pobbooking_prime.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking_prime.qty*product.ptr) AS totpob,pobbooking_prime.client_id FROM pobbooking_prime,product WHERE pobbooking_prime.productid=product.id AND pobbooking_prime.`repid`='".$repid."' AND pobbooking_prime.cdate LIKE '%".$datemonth."%' ");

		$arrCol['doctor_name'] = '';
	}
	elseif($_REQUEST['pob']=='3')
		{		$monthpobtotal1=mysql_query("SELECT GROUP_CONCAT(pobbooking_second.qty) AS qty,GROUP_CONCAT(pobbooking_second.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking_second.qty*product.ptr) AS totpob,pobbooking_second.client_id,doctors.doctor_name,(select doctor_name from doctors1 where doctors1.id=doctors.stockist_id) AS stockist_name FROM pobbooking_second,product,doctors WHERE pobbooking_second.productid=product.id AND pobbooking_second.client_id=doctors.id AND pobbooking_second.`repid`='".$repid."' AND pobbooking_second.cdate LIKE '%".$datemonth."%' AND pobbooking_second.client_id='".$obResult['client_id']."'");


	$monthpobtotal12=mysql_query("SELECT GROUP_CONCAT(pobbooking_second.qty) AS qty,GROUP_CONCAT(pobbooking_second.productid) AS productid,GROUP_CONCAT(product.pro_name) AS pro_name,GROUP_CONCAT(product.ptr) AS ptr,GROUP_CONCAT(pobbooking_second.qty*product.ptr) AS totpob,pobbooking_second.client_id,doctors.doctor_name FROM pobbooking_second,product,doctors WHERE pobbooking_second.productid=product.id AND pobbooking_second.client_id=doctors.id AND pobbooking_second.`repid`='".$repid."' AND pobbooking_second.cdate LIKE '%".$datemonth."%' ");
}




$monthpobtotal_row1 = mysql_fetch_array($monthpobtotal1);

$arrCol['stockist_name'] = $monthpobtotal_row1['stockist_name'];


$totpob1=explode(',', $monthpobtotal_row1['totpob']);

foreach($totpob1 as $totpob2)
{
	$totcomform+=$totpob2;
}
$totpdt1=explode(',', $monthpobtotal_row1['qty']);

foreach($totpdt1 as $totpdt2)
{
	$totcomformpdt+=$totpdt2;
}

$monthpobtotal_row12 = mysql_fetch_array($monthpobtotal12);

$totpob12=explode(',', $monthpobtotal_row12['totpob']);

foreach($totpob12 as $totpob22)
{
	$totcomform2+=$totpob22;
}




	// $totallpob=$monthpobtotal_row12['totpob'];

$arrCol['totpobnew'] = $totcomform;
$arrCol['totpdtnew'] = $totcomformpdt;
//	$arrCol['currentdate'] = date('Y-m-d');

$arrCol['totpoballnew'] = $totcomform2;


array_push($resultArray,$arrCol);
}
mysql_close($con);

echo json_encode($resultArray);






?>