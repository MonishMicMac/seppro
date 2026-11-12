<?php
include("connect23.php"); 
 


$leaveapplieddate=$_REQUEST['leaveapplieddate'];


$strSQL = "SELECT repgivenasleave.id,repgivenasleave.reason,repgivenasleave.leaveapplieddate,repgivenasleave.date,repgivenasleave.time,representative.rep_name
FROM repgivenasleave,representative
WHERE repgivenasleave.leaveapplieddate='$leaveapplieddate' AND repgivenasleave.expenses='leave' AND representative.id=repgivenasleave.repid";





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
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>