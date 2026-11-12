<?php
include("connect1.php");


// $jj_res = mysql_fetch_array($jj);
$rep_id = $_REQUEST['rep_id'];
$wpdate=date('Y-m-d',strtotime($_REQUEST['datee']));

// echo "SELECT GROUP_CONCAT(DISTINCT pincode) AS pincode FROM Beatwiserep WHERE repid IN (".$rep_id.") ";

$sql5=mysql_query("SELECT GROUP_CONCAT(DISTINCT pincode) AS pincode FROM Beatwiserep WHERE repid IN (".$rep_id.") ");
$row5=mysql_fetch_array($sql5);
// echo "SELECT * FROM  doctors WHERE doc_pincode IN (".$row5['pincode'].") GROUP BY id ASC ";
// exit();
// $sql=mysql_query("SELECT * FROM  doctors WHERE doc_pincode IN (".$row5['pincode'].") AND rep_id IN (".$rep_id.") GROUP BY id ASC ");

$strSQL = "SELECT * FROM  doctors WHERE doc_pincode IN (".$row5['pincode'].") AND rep_id IN (".$rep_id.") GROUP BY id ASC ";
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

	// $sql5=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$rep_id."' AND wp_pin_code='".$obResult['pincode']."' AND beat_status='1' AND wp_date='".$wpdate."'");
	// $row5=mysql_num_rows($sql5);

	// if($row5!='0')
	// {
	// 	$arrCol['beat_status'] = '1';
	// }
	// else
	// {
		// $arrCol['beat_status'] = '0';
	// }

	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);



?>