<?php

include("connect.php"); 





$strSQL = "SELECT repgivenasleave.leaveapplieddate,repgivenasleave.expenses,representative.rep_name FROM repgivenasleave,representative WHERE representative.id=repgivenasleave.repid AND repgivenasleave.expenses='leave'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>