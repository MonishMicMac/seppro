<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
	mysql_select_db("pankaj");

$imeino=$_REQUEST['rep_imeino'];

if($imeino !='')
{
$sql = mysql_query("SELECT id FROM representative where rep_imeino='$imeino'");
$row=mysql_fetch_array($sql);
$rep_id=$row['id'];




$strSQL = "SELECT id,rep_name,smsreportingnumber,welcomewishes,dummyid,welcomeurl,emailidforsending,welcomeclose,dateoftourplan,supportnumber,version,blockopeningmonth,playurl,(select count(*) from representative where rep_id>0) as count FROM representative where rep_imeino='$imeino'";

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
		$arrCol['v1'] ='0';
		$arrCol['v2'] = '0';
		$arrCol['dr_full_cnt'] = '0';
		array_push($resultArray,$arrCol);
	}
	mysql_close($con);
	
	echo json_encode($resultArray);


} else {
echo '[]';
}



?>