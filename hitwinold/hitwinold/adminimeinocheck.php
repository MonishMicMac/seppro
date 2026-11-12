
<?php
include('connect.php');





$result=mysql_query("SELECT count(*) as total from clinetcreation");
$data=mysql_fetch_assoc($result);
 

$strSQL = "SELECT  * FROM representative WHERE rep_imeino='".$_REQUEST['imeino']."' or image='".$_REQUEST['imeino']."' ";
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


                 $arrCol['cusid']=$data['total'];


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>