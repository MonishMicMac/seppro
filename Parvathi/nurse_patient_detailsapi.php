<?php


include("connect1.php");

// $id=$_REQUEST['id'];
$id=$_REQUEST['id'];
// print($id);exit();
// $sql=mysql_query("SELECT incharge.*,telecaller_assign_manager.incharge_id
// FROM `incharge` 
// JOIN telecaller_assign_manager on incharge.id=telecaller_assign_manager.incharge_id
// WHERE incharge.id='$incharge_id'");


$sql=mysql_query("SELECT nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,nurse_assign.c_date,
nurse_assign.remarks,nurse_assign.fromdate,nurse_assign.todate,nurse_assign.fromtime,nurse_assign.totime,nurse_assign.time_slots,nurse_assign.status as status1,
nurse_assign.is_completed,nurse_assign.re_assign,nurse_assign.re_assign_id,nurse_assign.re_assign_name,
-- inouttime_nurse.task_id as taskid,inouttime_nurse.nurse_id as nurseid,inouttime_nurse.patient_id as patientid,inouttime_nurse.intime,inouttime_nurse.outtime,  
-- inouttime_nurse.latitude,inouttime_nurse.longtitude,inouttime_nurse.remarks as remark,inouttime_nurse.date,inouttime_nurse.status as status2,
patient_details.contact_person,patient_details.phone_no,patient_details.address,patient_details.location,patient_details.patient_name
FROM `nurse_assign` 
LEFT JOIN patient_details on patient_details.id=nurse_assign.patient_id
-- LEFT JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
Where nurse_assign.nurse_id='$id'  AND  nurse_assign.status ='1'
  AND nurse_assign.re_assign ='0'  AND nurse_assign.is_completed ='0' 

");


// $sql=mysql_query("SELECT nurse_assign.id as row_id,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,nurse_assign.c_date,
// nurse_assign.remarks,nurse_assign.fromdate,nurse_assign.todate,nurse_assign.fromtime,nurse_assign.totime,nurse_assign.time_slots,nurse_assign.status as status1,
// nurse_assign.is_completed,nurse_assign.re_assign,nurse_assign.re_assign_id,nurse_assign.re_assign_name
// FROM `nurse_assign` 
// LEFT JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
// Where nurse_assign.nurse_id='$id'
// ");

// $obResult = mysql_fetch_array($sql)
  


$intNumField = mysql_num_fields($sql);
$resultArray = array();
while($obResult = mysql_fetch_array($sql))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($sql,$i)] = $obResult[$i];
	}

    $intime=$obResult['intime'];
    $outtime=$obResult['outtime'];

    // print_r($outtime);exit();
if($intime =='0' && $outtime == '0'){

    $arrCol['livestatus'] = 'assigned';


}elseif($intime !='0'){

    $arrCol['livestatus'] = 'ongoing';

}


	array_push($resultArray,$arrCol);
}


if(count($resultArray)>0){
    $output_data = array(
        'status' => 'true',
        'data' => $resultArray
        );
  echo json_encode($output_data);
 } else {
    $output_data = array(
        'status' => 'failed',
        'data' => []
        );
        echo json_encode($output_data);

 }


?>