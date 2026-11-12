<?php

include("connect1.php");

$imeino=$_REQUEST['rep_imeino'];

if($imeino !='')
{








$sql1 = mysql_query("SELECT id,state,rep_name,version,playurl FROM representative where (rep_imeino='$imeino' OR rep_imeino1='$imeino')");
$row1=mysql_fetch_array($sql1);

$reid=$row1['id'];
$repname=$row1['rep_name'];
$repversion=$row1['version'];
$repurl=$row1['playurl'];
$repstate=$row1['state'];

if($reid=='' || $reid=='0')
{

echo '[]';


}
else
{

$reid=$row1['id'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');

$strSQL = "SELECT tbl_work_plan.attendancestatus,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.drunavailable,doctors.doctor_addrs,tbl_work_plan.wp_date,doctors.id,doctors.doctor_name,tbl_work_plan.wp_id,tbl_work_plan.attendancestatus FROM doctors,tbl_work_plan where tbl_work_plan.wp_date ='$c_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$reid' AND tbl_work_plan.wp_dc_id=doctors.id";
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
		

                 $arrCol['repname'] = $repname;
                 $arrCol['reid'] = $reid;
                 $arrCol['repversion'] = $repversion;
                 $arrCol['repurl'] = $repurl;
                 $arrCol['month'] = $c_date;
                 $arrCol['state'] = $repstate;

		array_push($resultArray,$arrCol);
	}
	mysql_close($con);
	
	




if(json_encode($resultArray)=='[]')
{


echo '[{"repname":"'.$repname.'","reid":"'.$reid.'","repversion":"'.$repversion.'","repurl":"'.$repurl.'","month":"'.'0"'.',"state":"'.$repstate.'"'.'}]';

}
else
{
echo json_encode($resultArray);
}


}




} else {
echo '[]';
}



?>