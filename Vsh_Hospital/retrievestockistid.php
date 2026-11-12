<?php
include("connect23.php"); 


$billno=$_REQUEST['billno'];





$strSQL = "SELECT * 
FROM mst_pob,mst_rcpa_stockist
WHERE mst_pob.pobbillno='$billno' AND mst_rcpa_stockist.stockist_id=mst_pob.stockist_id";





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