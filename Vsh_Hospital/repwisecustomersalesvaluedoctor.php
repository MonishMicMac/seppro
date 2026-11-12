<?php

include("connect23.php"); 

 
$idg = $_REQUEST['id']; 
$d = $_REQUEST['datee'];
$date=date_create($d);
$salesdate= date_format($date,"F Y");



 $strSQL = "SELECT (SELECT rep_name FROM representative where id = a.rep_id) as rep,a.rep_id,sum(quantity*pts) as tot FROM areawise_temp a WHERE a.bill_string = '$salesdate' and a.rep_id !=0 and (SELECT rep_name FROM representative where id = a.rep_id) !='' and a.rep_id NOT IN(7,8,44,49,20)  GROUP BY `rep_id`
";

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