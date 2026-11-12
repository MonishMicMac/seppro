<?php

include("../includes/connect_db.php");
$parentid=$_REQUEST['parentid'];
$teacherid=$_REQUEST['teacherid'];
$id=$_REQUEST['id'];


$sql=mysql_query("SELECT * FROM teachersparentchat where parentid='$parentid' and teacherid='$teacherid' order by id desc")or die(mysql_error());
$count=mysql_num_rows($sql);
if($count > 10)
{
  $rod=$count - 10;
}
else
{
  $rod=0;
}

if($id == '0')
{

$strSQL = "SELECT * FROM teachersparentchat where parentid='$parentid' and teacherid='$teacherid' order by id limit $rod,10 ";

}
else
{
$strSQL = "SELECT * FROM teachersparentchat where parentid='$parentid' and teacherid='$teacherid' and sentid='P14' and id >'$id' order by id asc limit 10 ";
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