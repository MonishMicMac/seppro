<?php
$user="root";
$pass="$3pp60@2016";
$database="Vsh_hospital";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

$rep_id=$_REQUEST['rep_id'];

date_default_timezone_set("Asia/Kolkata");
 $date =date('Y-m-d');

 $sql = mysql_query("SELECT * FROM rep_inouttime where rep_id='$rep_id' AND cdate='$date' AND intime !='' ")or die(mysql_error());
//  print_r($sql);exit();

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

      mysql_close($con);

	echo json_encode($resultArray);

?>