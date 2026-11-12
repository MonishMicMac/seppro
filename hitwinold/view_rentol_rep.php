<?php
include('connect.php');

$daysupply=date("Y-m-d");
$repid=$_REQUEST['repid'];

$strSQL = "SELECT  * FROM rental WHERE r_repid='$repid'";


$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();

	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		// $arrCol["countrental"] += 1;
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}

		      $sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) AS proname FROM product WHERE id IN (".$obResult['r_pro_id'].")  ");             
              $rows=mysql_fetch_array($sqls);
              $arrCol["product"] = $rows["proname"];

              $sqlsc=mysql_query("SELECT * FROM clinetcreation WHERE id =".$obResult['r_clid']."  ");             
              $rowsc=mysql_fetch_array($sqlsc);
              $arrCol["clientname"] = $rowsc["name"];
              $arrCol["address"] = $rowsc["address"];
              $arrCol["pincode"] = $rowsc["pincode"];
              $arrCol["mobileno"] = $rowsc["mobileno"];
              $arrCol["companyname"] = $rowsc["companyname"];

              $sqlsr=mysql_query("SELECT rep_name FROM representative WHERE id =".$obResult['assignid']."  ");             
              $rowsr=mysql_fetch_array($sqlsr);
              $arrCol["repname"] = $rowsr["rep_name"];
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>