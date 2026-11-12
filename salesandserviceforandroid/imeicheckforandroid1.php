
<?php
include('connect.php');

// echo "SELECT  * FROM representative WHERE rep_imeino='".$_REQUEST['imeino']."' AND gcm_repid='".$_REQUEST['gcm_repid']."'";

$rep_doccotktru=mysql_query("SELECT  count(*) AS checkimno FROM representative WHERE rep_imeino='".$_REQUEST['imeino']."' AND gcm_repid='".$_REQUEST['gcm_repid']."'")or die(mysql_error());
$rep_doccotktru_row = mysql_fetch_array($rep_doccotktru);
// echo $rep_doccotktru_row['checkimno'];
// exit();
if($rep_doccotktru_row['checkimno']==0)
{
mysql_query("UPDATE representative sET gcm_repid='".$_REQUEST['gcm_repid']."' WHERE rep_imeino='".$_REQUEST['imeino']."'")or die(mysql_error());

// echo "hi";
}
$strSQL = "SELECT  playurl,version,id,referenceid,companyname,spartpartemailid,offlineproduct,emailidtosend,rep_name FROM representative WHERE rep_imeino='".$_REQUEST['imeino']."' AND rep_id!='0'";
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