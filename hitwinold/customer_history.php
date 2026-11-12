<?php
include('connect.php');

$rid=$_REQUEST['rid'];
$clid=$_REQUEST['clid'];
$proid=$_REQUEST['proid'];

// echo "SELECT  * FROM rentol_historp where ret_id ='$rid' AND repthis_proid LIKE '%".$proid."%' AND repthis_clid ='$clid' ";
 $strSQL = "SELECT  * FROM rentol_historp where ret_id ='$rid' AND repthis_proid LIKE '%".$proid."%' AND repthis_clid ='$clid' ";


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
		$sqlsc=mysql_query("SELECT pro_name FROM product WHERE id =".$proid."  ");             
              $rowsc=mysql_fetch_array($sqlsc);
              $arrCol["pro_name"] = $rowsc["pro_name"];

		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>