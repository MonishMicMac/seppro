<?php


include("connect.php"); 
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
$rep_id=$_REQUEST['rep_id'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];
$promoted_products=$_REQUEST['promoted_products'];
$promotion_service=$_REQUEST['promotion_service'];
$productname=$_REQUEST['productname'];
$comp=$_REQUEST['comp'];

$cash_type=$_REQUEST['cash_type'];
$cash_amount=$_REQUEST['cash_amount'];
$cheque_no=$_REQUEST['cheque_no'];
$user_type=$_REQUEST['user_type'];
$billno=$_REQUEST['billno'];

$Size_Demo=$_REQUEST['Size_Demo'];
$noPatients=$_REQUEST['noPatients'];
$noBeds=$_REQUEST['noBeds'];
$patients_inside=$_REQUEST['patients_inside'];
$Demo_time=$_REQUEST['Demo_time'];
$Demo_Date=$_REQUEST['Demo_Date'];
$Current_Frequency=$_REQUEST['Current_Frequency'];
$Agent=$_REQUEST['Agent'];
$Demo_Working_Condition=$_REQUEST['Demo_Working_Condition'];
$Time_Collected=$_REQUEST['Time_Collected'];
$Post_after_fogging_Swabs=$_REQUEST['Post_after_fogging_Swabs'];
$fogging_end1=$_REQUEST['fogging_end1'];
$fogging_started1=$_REQUEST['fogging_started1'];
$could_fumigate=$_REQUEST['could_fumigate'];
$persons_present_room=$_REQUEST['persons_present_room'];
$fogging_end=$_REQUEST['fogging_end'];
$fogging_started=$_REQUEST['fogging_started'];
$before_fogging_Plate=$_REQUEST['before_fogging_Plate'];
$Conducting_plain_water_dry=$_REQUEST['Conducting_plain_water_dry'];
$Time_Collecteddemo=$_REQUEST['Time_Collecteddemo'];
$Reschedule=$_REQUEST['Reschedule'];

$requrire=$_REQUEST['requrire'];




date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$sql=$je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date=CURDATE() AND wp_dc='D' AND wp_dc_id='$dr_id' AND wp_rep_id='$rep_id'")or die(mysql_error());
$sql->execute();
if($sql->fetchColumn()>0) 
{
	
	$strSQL3=$je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',promoted_products='$promoted_products',promotion_service='$promotion_service',productname='$productname',cash_type='$cash_type',cash_amount='$cash_amount',cheque_no='$cheque_no',user_type='$user_type',billno='$billno',competitorname='$comp',Conducting_plain_water_dry='$Conducting_plain_water_dry',before_fogging_Plate='$before_fogging_Plate',Time_Collected='$Time_Collected',fogging_started1='$fogging_started1',fogging_end1='$fogging_end1',persons_present_room='$persons_present_room',could_fumigate='$could_fumigate',fogging_started='$fogging_started',Demo_time='$Demo_time',patients_inside='$patients_inside',noBeds='$noBeds',noPatients='$noPatients',Size_Demo='$Size_Demo',fogging_end='$fogging_end',Post_after_fogging_Swabs='$Post_after_fogging_Swabs',Demo_Working_Condition='$Demo_Working_Condition',Agent='$Agent',Current_Frequency='$Current_Frequency',Demo_Date='$Demo_Date',Time_Collecteddemo='$Time_Collecteddemo',Reschedule='$Reschedule',requrire='$requrire' WHERE wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' and wp_date='$c_date'")or die(mysql_error());
		$strSQL3->execute();
	$strSQL3->rowCount();
	if($strSQL3!='0')
	{
		echo 'sucess';
	}
	else
	{
		echo 'failure';
	}

}



$sql=$je->prepare("SELECT dr_latitude,dr_longitude FROM doctors WHERE id='$dr_id'")or die(mysql_error());
$sql->execute();
$data = $sql->fetch();
if($data['dr_latitude']=='')
{
	$strSQL1 = $je->prepare("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());
	$strSQL1->execute();
}

?>