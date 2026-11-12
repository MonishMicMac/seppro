<?php

include("connect.php"); 

 $id=$_REQUEST['id'];












$a = mysql_query("SELECT productrequested,complaints,amount,servicetype FROM reorting WHERE  id='$id'")or die(mysql_error());

$jj = mysql_fetch_array($a);

 $proid=$jj['productrequested'];
 $proqty=$jj['complaints'];
$proqtyw=$jj['amount'];
$servicetype=$jj['servicetype'];




if($proid=='0')
{
echo '[]';
}
else
{


$strSQLq = "SELECT id,pro_name FROM product WHERE  `id` IN ( $proid )";
$objQuery = mysql_query($strSQLq);
	
$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
                
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
                 

		}
                    $arrCol['compl'] = $proqty;
                    $arrCol['amount'] = $proqtyw;
$arrCol['servicetype'] = $servicetype;


		array_push($resultArray,$arrCol);
	}

echo json_encode($resultArray);




}


	




?>