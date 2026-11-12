<?php

include("connect.php"); 

 $id=$_REQUEST['id'];


$strSQL = "SELECT representative.id,representative.rep_name,IFNULL((SELECT (case when expenses='leave' then '1' end) as status FROM repgivenasleave WHERE repid=assigningreptomanager.repid AND expenses='leave' group by expenses),'0') as status
 FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid";
$objQuery = $je->prepare($strSQL);

	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($antony);



?>