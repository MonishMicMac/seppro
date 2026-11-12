<?php
	include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 


$year = date('Y');

echo SELECT repgivenasleave.expenses,repgivenasleave.leaveapplieddate,repgivenasleave.reason,(SELECT COUNT(*) FROM tableworkreport WHERE reported_date=repgivenasleave.leaveapplieddate AND  vender_id='$rep_id') as callcount FROM  repgivenasleave,tableworkreport  WHERE repgivenasleave.repid=tableworkreport.vender_id and repgivenasleave.repid='$rep_id' AND leaveapplieddate like '$year%' group by leaveapplieddate "; exit();



$strSQL = "SELECT repgivenasleave.expenses,repgivenasleave.leaveapplieddate,repgivenasleave.reason,(SELECT COUNT(*) FROM tableworkreport WHERE reported_date=repgivenasleave.leaveapplieddate AND  vender_id='$rep_id') as callcount FROM  repgivenasleave,tableworkreport  WHERE repgivenasleave.repid=tableworkreport.vender_id and repgivenasleave.repid='$rep_id' AND leaveapplieddate like '$year%' group by leaveapplieddate ";


$objQuery = $je->prepare($strSQL);
$objQuery ->execute();

	
	$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);





?>