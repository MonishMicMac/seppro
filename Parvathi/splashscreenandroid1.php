

<?php
include("connect1.php");


$username=$_REQUEST['username'];
$password=$_REQUEST['password'];


$strSQL =  mysql_query("SELECT * FROM nurse_details where username='$username' and password='$password' and nurse_status='1'");

$intNumField = mysql_num_fields($strSQL);

$resultArray = array();
while($obResult = mysql_fetch_array($strSQL))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($strSQL,$i)] = $obResult[$i];
	}
	array_push($resultArray,$arrCol);
}

if(count($resultArray)>0){
    $output_data = array(
        'status' => 'true', 
        'error_message'=>'Login successfully!',
        'data' => $resultArray[0]
        );
  echo json_encode($output_data);
 } else {
    $output_data = array(
        'status' => 'failed',
        'error_message' => 'Please Check your Mobile Number'
        );
        echo json_encode($output_data);

 }


?>\
