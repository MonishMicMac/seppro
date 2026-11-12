<?php

include("connect.php"); 

$repid=$_REQUEST['repid'];
// $month=date('Y-');

$strSQL = "SELECT id,tdate FROM reorting WHERE repid='$repid'  AND tdate like '%".$_REQUEST['month']."%' GROUP BY tdate ORDER BY tdate ASC ";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$cdate=$obResult['tdate'];
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		// echo "SELECT * FROM reorting WHERE repid='$repid'  AND tdate='$cdate' AND attendance='0'";
			$strSQLsts = "SELECT count(*) AS sts FROM reorting WHERE repid='$repid'  AND tdate='$cdate' AND attendance='0'";
			$objQuerysts = mysql_query($strSQLsts);
			$obResultsts = mysql_fetch_array($objQuerysts);
			// echo $obResultsts['sts'].';';
			// echo count($obResultsts).';';
			if($obResultsts['sts']!='0')
			{
				$arrCol["status"] = "1";
			}
			else
			{
				$arrCol["status"] = "0";
			}

              



		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>