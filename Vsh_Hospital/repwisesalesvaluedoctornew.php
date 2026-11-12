<?php

include("connect23.php"); 

 
$idg = $_REQUEST['id']; 
$d = $_REQUEST['datee'];
$date=date_create($d);
$salesdate= date_format($date,"F Y");

/*echo "SELECT a.rep_id,(SELECT doctor_name FROM doctors WHERE id=b.doctor_id) as doctor,b.doctor_id,a.pro_name,sum(a.quantity*a.pts) as total FROM areawise_temp a LEFT JOIN
    tbl_doctor_chemist b ON a.our_cust_id = b.chemist_id  WHERE a.bill_string = '$salesdate' and a.rep_id ='$idg' and a.rep_id != 0 group by b.doctor_id";exit();*/


 $strSQL = "SELECT a.rep_id,(SELECT doctor_name FROM doctors WHERE id=b.doctor_id) as doctor,b.doctor_id,a.pro_name,sum(a.quantity*a.pts) as total FROM areawise_temp a LEFT JOIN
    tbl_doctor_chemist b ON a.our_cust_id = b.chemist_id  WHERE a.bill_string = '$salesdate' and a.rep_id ='$idg' and a.rep_id != 0 group by b.doctor_id";

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