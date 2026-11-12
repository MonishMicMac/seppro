<?php
include('connect.php');

if($_REQUEST['mode']=='oview')
{
$exp=explode("-",$_REQUEST['date']);
$date=$exp[0]."-".$exp[1];
$strSQL = "SELECT  * FROM rental where r_status ='1' AND r_closedate LIKE '%".$date."%' AND r_clid='".$_REQUEST['cid']."'";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			if(mysql_field_name($objQuery,$i)=='r_pro_id'){
		 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		 	$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$obResult[$i].")");
			$row=mysql_fetch_array($sql);
			$arrCol['pro_name']=$row['pro_name'];
		}
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
}


if($_REQUEST['mode']=='deview')
{
$strSQL1 = mysql_query("SELECT  r_status FROM rental where r_id ='".$_REQUEST['rid']."'")or die(mysql_error());
$strSQL_res = mysql_fetch_array($strSQL1);

if($strSQL_res['r_status']=='1')
{
 $strSQL = "SELECT rethis_id,rethis_pay_type,ret_id,repthis_proid,pro_name,repthis_clid,rethis_pay_date,rethis_pay_amt,rethis_assignid,rethis_feedback,rethis_update FROM rentol_historp,product where ret_id ='".$_REQUEST['rid']."' AND product.id=rentol_historp.repthis_proid";
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
}
}

?>