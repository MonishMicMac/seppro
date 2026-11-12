<?php

include("connect.php"); 



$leaveapplieddate=$_REQUEST['leaveapplieddate'];


$strSQL = "SELECT repgivenasleave.leaveapplieddate,repgivenasleave.expenses,representative.rep_name FROM repgivenasleave,representative WHERE representative.id=repgivenasleave.repid AND repgivenasleave.expenses='leave' AND repgivenasleave.leaveapplieddate LIKE '$leaveapplieddate%'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>