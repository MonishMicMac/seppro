<?php
include("connect.php");
$strSQL="SELECT * FROM diagnoses_collect_history WHERE clientid='".$_REQUEST['clientid']."' AND addid='".$_REQUEST['addid']."'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 	if(mysql_field_name($objQuery,$i)=='productid')
		 	{
		 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		 	$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN ($obResult[$i])");
			$row=mysql_fetch_array($sql);
			$arrCol['pro_name']=$row['pro_name'];
		 }
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	
	
	echo json_encode($resultArray);
?>