
<?php
include('connect.php');

$strSQL = "SELECT  * FROM representative WHERE mobile='".$_REQUEST['mobile']."'";




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
	
	echo '{"title":{"episodes":'.json_encode($resultArray).', "year": 2016} }';

?>