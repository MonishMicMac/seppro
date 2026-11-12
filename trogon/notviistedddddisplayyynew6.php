<?php

include("connect23.php"); 

ini_set('memory_limit', '-1');

$rep_id=$_REQUEST['rep_id'];
 $date=date('Y-m-d');


global $notvisitedcount;

$missedcount='0';
$bfgrt='0';
$vistedcalls='0';

$full_date=date("Y-m-d",strtotime($date));
 $full_date5=date("Y-m",strtotime($date));



$v56sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id,count(wp_dc_id) AS cdc from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date='$full_date'  and drunavailable='0'");
$v56sssCNT= mysql_num_rows($v56sss);

if($v56sssCNT==0)
{

}
if($v56sssCNT>0)
{
$row56 = mysql_fetch_array($v56sss);
 $rto=$row56['wp_dc_id'];


}
else
{
$rto=0;
}


$v56sss51=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id,count(wp_dc_id) AS cdc from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date LIKE '%".$full_date5."%'  and drunavailable='0' AND attendancestatus='1' GROUP BY wp_dc_id HAVING cdc>=2");
$v56sssCNT51= mysql_num_rows($v56sss51);	
// echo $v56sssCNT51;
if($v56sssCNT51==0)
{

}
if($v56sssCNT51>0)
{
	
while($row5651 = mysql_fetch_array($v56sss51))
{
	$rto51[]=$row5651['wp_dc_id'];
}

 $rto51=implode(",",$rto51);


}
else
{
$rto51=0;
}
// echo $rto.'-';
// echo $rto51;


if(strlen($resp)=='0')
{
  $pandiyan=$rto.",".$rto51;
}
else
{	
  $pandiyan=$rto.",".$rto51;	
}

"SELECT id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite FROM doctors WHERE  id NOT IN (".$pandiyan.") AND `rep_assign` =$rep_id";

$strSQL = "SELECT id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name  FROM doctors WHERE  `rep_assign` =$rep_id";


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