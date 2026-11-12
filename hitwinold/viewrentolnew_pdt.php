<?php
include('connect.php');

// $rid=$_REQUEST['rid'];
$proid=$_REQUEST['proid'];

// $daysupply=date("Y-m",strtotime($_REQUEST['daysupply']));

// $sqlsr=mysql_query("SELECT r_id from rental WHERE r_id='".$rid."' ");             
//               $rowsr=mysql_fetch_array($sqlsr);

// echo "SELECT  * FROM product where id IN (".$rowsr['r_pro_id'].") ";

$strSQL = "SELECT  pro_name FROM product where id ='$proid' ";


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
		  // $sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) AS proname FROM product WHERE id IN (".$obResult['r_pro_id'].")  ");             
    //           $rows=mysql_fetch_array($sqls);
        


    //           $sqlsc=mysql_query("SELECT name FROM clinetcreation WHERE id =".$obResult['r_clid']."  ");             
    //           $rowsc=mysql_fetch_array($sqlsc);
    //           $arrCol["clientname"] = $rowsc["name"];

    //           $sqlsr=mysql_query("SELECT rep_name FROM representative WHERE id =".$obResult['r_repid']."  ");             
    //           $rowsr=mysql_fetch_array($sqlsr);
    //           $arrCol["repname"] = $rowsr["rep_name"];
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>