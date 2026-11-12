<?php
include("connect1.php");


// $jj_res = mysql_fetch_array($jj);
$rep_id = $_REQUEST['rep_id'];
$wpdate=date('Y-m-d',strtotime($_REQUEST['datee']));

// echo AND rep_id='".$rep_id."';
// "select GROUP_CONCAT(DISTINCT beatid) AS beatid from doctors where stockist_id='".$_REQUEST['dis']."' AND rep_id='".$rep_id."' "
$sql5bid=mysql_query("select GROUP_CONCAT(DISTINCT beatid) AS beatid from doctors where  rep_id='".$rep_id."'  ");
	$sql5bid_row=mysql_fetch_array($sql5bid);


// echo "SELECT beadname.name,beadname.id FROM beadname WHERE  Beatwiserep.beadid IN (select beatid from doctors where stockist_id='".$_REQUEST['dis']."' AND rep_id='".$rep_id."') ";
// echo "SELECT name,id FROM beadname WHERE  id IN (".$sql5bid_row['beatid'].") ";
// exit();

// echo "SELECT beadname.name,beadname.id,Beatwiserep.pincode FROM Beatwiserep,beadname WHERE Beatwiserep.beadid=beadname.id AND Beatwiserep.beadid IN (select beatid from doctors where stockist_id='".$_REQUEST['dis']."' AND rep_id='".$rep_id."') AND Beatwiserep.repid='$rep_id' GROUP BY beadname.name";

$strSQL = "SELECT name,id FROM beadname WHERE  id IN (".$sql5bid_row['beatid'].") ";
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

	// echo "SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$rep_id."' AND beat_status='1' AND wp_date='".date('Y-m-d')."'";

	$sql5=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$rep_id."' AND wp_pin_code='".$obResult['pincode']."' AND beat_status='1' AND wp_date='".$wpdate."'");
	$row5=mysql_num_rows($sql5);

	if($row5!='0')
	{
		$arrCol['beat_status'] = '1';
	}
	else
	{
		$arrCol['beat_status'] = '0';
	}

	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);



?>