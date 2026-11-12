<?php

include("connect2.php"); 
$repid=$_REQUEST['repid'];

$cdate1=$_REQUEST['cdate1'];

$strSQL = "SELECT * 
FROM mst_pob,doctors,master_pincode
WHERE mst_pob.repid='$repid' AND mst_pob.cdate='$cdate1' AND  doctors.id=mst_pob.dc_id AND master_pincode.pin_id=doctors.doc_pin_id  group by mst_pob.pobbillno ORDER BY mst_pob.pob_id DESC";





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