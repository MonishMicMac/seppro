<?php

include("connect2.php"); 

$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];



if($status==0)
{
$strSQL = "SELECT * FROM newlead where repid='$repid' and ordercheck='0'";
}
elseif ($status==1) 
{
	$strSQL = "SELECT * FROM newlead where repid='$repid' and ordercheck='1'";

}
elseif ($status==2)
 {
	$strSQL = "SELECT * FROM newlead where repid='$repid' and ordercheck='2'";
}


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