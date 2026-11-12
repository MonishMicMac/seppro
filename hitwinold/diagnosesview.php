<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$id=$_REQUEST['id'];


$sql=mysql_query("SELECT product_id,collect_product_id,status FROM diagnoses_add WHERE id='$id'")or die(mysql_error());
$row=mysql_fetch_array($sql);

$product_id=rtrim($row['product_id'],",");
$collect_product_id=rtrim($row['collect_product_id'],",");

if($row['collect_product_id']=='')
{
 $strSQL="SELECT pro_name,id FROM product WHERE id IN ($product_id)";
}
else
{
	 $strSQL="SELECT pro_name,id FROM product WHERE id IN ($product_id) AND id NOT IN ($collect_product_id)";
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
	
	
	
	echo json_encode($resultArray);	


?>