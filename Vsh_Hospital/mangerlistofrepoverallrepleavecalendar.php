<?php

include("connect.php"); 




$id=$_REQUEST['id'];

$strSQL = "SELECT repgivenasleave.leaveapplieddate,repgivenasleave.expenses,representative.rep_name FROM repgivenasleave,representative,assigningreptomanager WHERE representative.id=repgivenasleave.repid AND repgivenasleave.expenses='leave' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>