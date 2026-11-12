<?php

include("connect23.php"); 

    $version=$_REQUEST['version'];
    $type=$_REQUEST['type'];


   
$sql=mysql_query("SELECT *
FROM version 
WHERE version='$version' AND type='$type'
");

$sql2=mysql_query("SELECT *
FROM version 
WHERE type='$type'
");

$obResult3 = mysql_fetch_array($sql2);


$intNumField = mysql_num_fields($sql);
$resultArray = array();
while($obResult = mysql_fetch_array($sql))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($sql,$i)] = $obResult[$i];
	}
	array_push($resultArray,$arrCol);
}

$data=count($resultArray);

if($data>0){

    $output_data = array(
        'status' => 'true',
        'data' => 'Already in the Updated version'
        );
 
 } else {
    $output_data = array(
        'status' => 'failed',
        'data' => $obResult3['playstore_link'],
        'error message' => 'Please Update to the latest version'
        );
       

 }

 echo json_encode($output_data);
    


?>