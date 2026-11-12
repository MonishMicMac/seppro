<?php
include("connect1.php"); 

$disid=$_REQUEST['disid'];
// $repid=$_REQUEST['repid'];

$feedback=$_REQUEST['feedback'];
$managerlat=$_REQUEST['managerlat'];
$managerlong=$_REQUEST['managerlong'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");

$disid1 = explode(",",$disid);
for($i=0;$i< count($disid1);$i++)
{
	// echo "SELECT * FROM doctors WHERE stockist_id='".$disid1[$i]."' ";
	$objQuery = mysql_query("SELECT * FROM doctors WHERE stockist_id='".$disid1[$i]."' ");

	while($obResult = mysql_fetch_array($objQuery))
	{
		// echo $obResult['id'];
		// echo "UPDATE tbl_work_plan SET jointworkapproval='5',feedback='$feedback',managerlat='$managerlat',managerlong='$managerlong',managerdate='$c_date' WHERE wp_dc_id = '".$obResult['id']."' ";
		mysql_query("UPDATE tbl_work_plan SET jointworkapproval='1',feedback='$feedback',managerlat='$managerlat',managerlong='$managerlong',managerdate='$c_date' WHERE wp_dc_id = '".$obResult['id']."' ")or die(mysql_error());
	}
}
?>
