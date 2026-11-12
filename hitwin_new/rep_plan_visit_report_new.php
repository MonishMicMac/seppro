
<?php
include('connect.php');


if($_REQUEST['pvpstatus']=='0')
{
	$strSQL = "SELECT *,reorting.id as report_id FROM reorting,clinetcreation where reorting.clientid=clinetcreation.id AND reorting.attendance='0' AND (reorting.repid='".$_REQUEST['repid']."'or reorting.not_assign_schedulle='5') AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%' ";

}
//pending
elseif($_REQUEST['pvpstatus']=='1')
{

	$strSQL = "SELECT *,reorting.id as report_id FROM reorting,clinetcreation where reorting.clientid=clinetcreation.id AND (reorting.repid='".$_REQUEST['repid']."' or reorting.not_assign_schedulle='5') AND reorting.attendance='1' AND reorting.reporteddate LIKE '%".$_REQUEST['wpdate']."%' ";

}
//visited
elseif($_REQUEST['pvpstatus']=='2')
{
	$strSQL = "SELECT *,reorting.id as report_id FROM reorting,clinetcreation where reorting.clientid=clinetcreation.id AND (reorting.repid='".$_REQUEST['repid']."' or reorting.not_assign_schedulle='5') AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%' ";

}
//planned


// SELECT  * FROM assigningreptomanager WHERE managerid='".$_REQUEST['repid']."' AND admincontral='2'




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

	if($obResult['repreportedpro']!='')
	{
		$rep_ck=mysql_query("SELECT GROUP_CONCAT(pro_name) AS pro_name FROM product where id  IN (".$obResult['repreportedpro'].")  ")or die(mysql_error());
		$rep_row = mysql_fetch_array($rep_ck);
		$arrCol['pro_name'] = $rep_row['pro_name'];
	}
	else
	{
		$arrCol['pro_name'] = '';
	}

	if($obResult['productrequested']!='')
	{
		$rep_ck1=mysql_query("SELECT GROUP_CONCAT(pro_name) AS pro_name FROM product where id  IN (".$obResult['productrequested'].")  ")or die(mysql_error());
		$rep_row1 = mysql_fetch_array($rep_ck1);
		$arrCol['req_pro_name'] = $rep_row1['pro_name'];
	}
	else
	{
		$arrCol['req_pro_name'] = '';
	}


	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);

?>