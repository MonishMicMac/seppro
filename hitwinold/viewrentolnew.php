<?php
include('connect.php');

$clientid=$_REQUEST['clientid'];
$daysupply=date("Y-m",strtotime($_REQUEST['daysupply']));



$strSQL = "SELECT  * FROM rental WHERE r_clid='".$clientid."' AND r_day_supply like  '%$daysupply%' AND r_status='0'";


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


		  $sqls=mysql_query("SELECT pro_name AS proname FROM product WHERE id IN (".$obResult['r_pro_id'].")");//GROUP_CONCAT(pro_name) AS proname          
              $rows=mysql_fetch_array($sqls);
              
              	$arrCol["product"] = $rows["proname"];
                           

              $sqlsc=mysql_query("SELECT name FROM clinetcreation WHERE id =".$obResult['r_clid']."  ");             
              $rowsc=mysql_fetch_array($sqlsc);
              $arrCol["clientname"] = $rowsc["name"];

              $sqlsr=mysql_query("SELECT rep_name FROM representative WHERE id =".$obResult['r_repid']."  ");             
              $rowsr=mysql_fetch_array($sqlsr);
              $arrCol["repname"] = $rowsr["rep_name"];
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>