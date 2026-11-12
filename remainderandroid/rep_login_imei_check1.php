
<?php
include('connect.php');

$strSQL = "SELECT  * FROM representative WHERE rep_imeino='".$_REQUEST['imeino']."' AND rep_id!='1'";
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
		// if($obResult['reg_id_sta']=='')
		// {
		// 	mysql_query("UPDATE representative SET reg_id_sta='".$_REQUEST['reg']."' WHERE rep_imeino= '".$_REQUEST['imeino']."' AND id='".$obResult['id']."'")or die(mysql_error());



		// }
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>