<?php
include("connect2.php"); 

$repid=$_REQUEST['repid'];


$strSQL = "SELECT * 
FROM mst_pob,doctors,master_pincode
WHERE mst_pob.repid='$repid' AND doctors.id=mst_pob.dc_id AND master_pincode.pin_id=doctors.doc_pin_id AND mst_pob.pobstatus='0' group by mst_pob.pobbillno ORDER BY mst_pob.pob_id DESC";





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