<?php
include("connect.php");


$manager_id=$_REQUEST['manager_id'];




$strSQL = "SELECT managerid,(select rep_name from representative where id=assigningreptomanager.managerid) manager_name,repid,(select rep_name from representative where id=assigningreptomanager.repid) rep_name FROM assigningreptomanager,representative WHERE managerid IN (select repid from assigningreptomanager,representative where assigningreptomanager.managerid=representative.id and managerid='$manager_id' and representative.adminon='1') AND assigningreptomanager.managerid=representative.id AND representative.rep_id!='0'";

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
	// if($obResult['managerid']==$obResult['repid'])
	// {
		$rep_ck1=mysql_query("SELECT IFNULL(count(case when reorting.attendance='0' then 1 END),0) as pending,IFNULL(count(case when reorting.attendance='1' then 1 END),0) as visit,count(*) as planned FROM reorting where (reorting.repid='".$obResult['managerid']."' or reorting.not_assign_schedulle='5')  AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
		$rep_row1 = mysql_fetch_array($rep_ck1);
		$arrCol['mpending'] = $rep_row1['pending'];
		$arrCol['mvisit'] = $rep_row1['visit'];
		$arrCol['mplanned'] = $rep_row1['planned'];

		$rep_ck2=mysql_query("SELECT count(*) AS countlog FROM Activity_log where managerid='".$obResult['managerid']."'  AND date LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
		$rep_row2 = mysql_fetch_array($rep_ck2);
		$arrCol['log_count'] = $rep_row2['countlog'];
	// }
	// else
	// {
		$rep_ck=mysql_query("SELECT IFNULL(count(case when reorting.attendance='0' then 1 END),0) as pending,IFNULL(count(case when reorting.attendance='1' then 1 END),0) as visit,count(*) as planned FROM reorting where (reorting.repid='".$obResult['repid']."' or reorting.not_assign_schedulle='5') AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
		$rep_row = mysql_fetch_array($rep_ck);
		$arrCol['pending'] = $rep_row['pending'];
		$arrCol['visit'] = $rep_row['visit'];
		$arrCol['planned'] = $rep_row['planned'];
	// }
	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);



?>