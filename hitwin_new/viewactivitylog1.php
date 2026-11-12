<?php
include('connect.php');

$strSQL = "SELECT  * FROM Activity_log WHERE managerid='".$_REQUEST['managerid']."' AND date LIKE '%".$_REQUEST['wpdate']."%' ORDER BY date DESC";


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
	$rep_ck2=mysql_query("SELECT name,address,companyname FROM clinetcreation where id='".$obResult['client_id']."' ")or die(mysql_error());
	$rep_row2 = mysql_fetch_array($rep_ck2);
	if(mysql_num_rows($rep_ck2)!='0')
	{
		$arrCol['client_name'] = $rep_row2['name'];
		$arrCol['client_address'] = $rep_row2['name'];
		$arrCol['company_name'] = $rep_row2['name'];
	}
	else
	{
		$arrCol['client_name'] = "";
		$arrCol['client_address'] = "";
		$arrCol['company_name'] = "";
	}
	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);

?>