<?php
include('connect.php');

if($_REQUEST['cmd']=='add')
{

$catchk=mysql_query("SELECT * FROM category WHERE catname='".$_REQUEST['catname']."'")or die(mysql_error());
	if(mysql_num_rows($catchk))
	{
		echo "Category Already Exists";
	}
	else
	{
		mysql_query("INSERT INTO category(catname)VALUES('".$_REQUEST['catname']."')")or die(mysql_error());
		echo "Category Added";}
}

if($_REQUEST['cmd']=='view')
{


$strSQL = "SELECT  * FROM category ";


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
}



?>