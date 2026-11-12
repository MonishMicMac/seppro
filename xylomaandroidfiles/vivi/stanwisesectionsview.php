<?php

include("connectsms.php");


$sn_id= $_REQUEST['sn_id'];


$strSQL = "SELECT sec_id FROM  tbl_stc_stn_assign_sec where sn_id='".$_REQUEST['sn_id']."'";
$strSQL1= mysql_query($strSQL)or die(mysql_error());
$strSQL_res=mysql_fetch_array($strSQL1);
$strSQL1 = "SELECT sec_id,sec_name FROM  mst_sec where  sec_id IN(".$strSQL_res['sec_id'].")";


$objQuery = mysql_query($strSQL1);
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