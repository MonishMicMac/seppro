
<?php
include('connect.php');


$strSQL = "SELECT id,rep_name FROM `representative` WHERE `rep_id`!= '0' order by id ASC ";


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
	// $rep_ck=mysql_query("SELECT IFNULL(count(case when reorting.attendance='0' then 1 END),0) as pending,IFNULL(count(case when reorting.attendance='1' then 1 END),0) as visit,count(*) as planned FROM reorting where reorting.repid='".$obResult['id']."'  AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
	// $rep_row = mysql_fetch_array($rep_ck);
	// $arrCol['pending'] = $rep_row['pending'];
	// $arrCol['visit'] = $rep_row['visit'];
	// $arrCol['planned'] = $rep_row['planned'];
	

	// $objQuery1 = mysql_query("SELECT representative.rep_name,representative.id,(case when representative.rep_id='0' then 'Representative' else 'Manager' end) as role FROM representative,assigningreptomanager where representative.id=assigningreptomanager.repid AND assigningreptomanager.managerid='".$obResult['id']."' AND assigningreptomanager.repid!='".$obResult['id']."' GROUP BY assigningreptomanager.repid");
	// while($obResult1 = mysql_fetch_array($objQuery1))
	// {
	// 	$rep_ck1=mysql_query("SELECT IFNULL(count(case when reorting.attendance='0' then 1 END),0) as pending,IFNULL(count(case when reorting.attendance='1' then 1 END),0) as visit,count(*) as planned FROM reorting where reorting.repid='".$obResult1['id']."'  AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
	// 	$rep_row1 = mysql_fetch_array($rep_ck1);
	// 	$arrCol1['pending'] = $rep_row1['pending'];
	// 	$arrCol1['visit'] = $rep_row1['visit'];
	// 	$arrCol1['planned'] = $rep_row1['planned'];
	// 	$finaloutputnew5.='{"rep_name":"'.$obResult1['rep_name'].'","id":"'.$obResult1['id'].'","role":"Representative","pending":"'.$arrCol1['pending'].'","visit":"'.$arrCol1['visit'].'","planned":"'.$arrCol1['planned'].'","manager":"'.$obResult['rep_name'].'"},';
	// }
	// $finaloutputnewrep5= substr($finaloutputnew5, 0, -1);

	// $rep_list="[".$finaloutputnewrep5."]";

	// $finaloutputnew.='{"rep_name":"'.$obResult['rep_name'].'","id":"'.$obResult['id'].'","role":"Manager","pending":"'.$arrCol['pending'].'","visit":"'.$arrCol['visit'].'","planned":"'.$arrCol['planned'].'","manager":"","rep_list":'.$rep_list.'},';

	array_push($resultArray,$arrCol);
}
// $finaloutputnew1= substr($finaloutputnew, 0, -1);

// echo "[".$finaloutputnew1."]";
mysql_close($con);

echo json_encode($resultArray);

?>