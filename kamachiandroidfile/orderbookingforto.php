<?php
include("connect2.php"); 

$pid=$_REQUEST['pid'];

$date=$_REQUEST['date'];





$strSQL = "SELECT * FROM mst_pob,doctors WHERE  mst_pob.cdate='$date' AND mst_pob.repid='$pid' AND doctors.id=mst_pob.dc_id GROUP BY mst_pob.pobbillno";





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