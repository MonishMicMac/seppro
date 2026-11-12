<?php

include("connect1.php");

$did=$_REQUEST['did'];

$date=$_REQUEST['date'];





$strSQL = "SELECT productid,qty FROM pobbooking1 WHERE client_id='$did' AND cdate='$date'";



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

                $sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['productid'].")");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>