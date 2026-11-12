<?php

include("connect1.php");




date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');

$repid=mysql_query("SELECT GROUP_CONCAT(id) AS RID FROM representative WHERE lastdate='$date' AND lasttime LIKE '".date('H')."%'")or die(mysql_error());

$repid_res=mysql_fetch_array($repid);
if($repid_res['RID']!=0)
{


$strSQL = "SELECT rep_name FROM representative WHERE id  NOT IN(".$repid_res['RID'].")";

}
else
{
  $strSQL = "SELECT rep_name FROM representative";
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