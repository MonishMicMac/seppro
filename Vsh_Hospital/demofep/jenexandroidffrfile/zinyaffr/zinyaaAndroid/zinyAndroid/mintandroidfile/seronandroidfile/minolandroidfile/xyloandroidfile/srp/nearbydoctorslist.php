<?php
include("connect2.php"); 


$pid=$_REQUEST['pid'];
$latitude1=$_REQUEST['latitude1'];
$longitude1=$_REQUEST['longitude1'];

$count=0;

global $asd;


$sql = "SELECT id,dr_latitude,dr_longitude FROM doctors WHERE doctors.rep_assign='$pid'"; 



$result = mysql_query($sql) or die(mysql_error());

 $p =mysql_num_rows($result);

while($row = mysql_fetch_array($result))
{
	
	--$p;

	
	
	 $theta = $longitude1 - $row['dr_longitude']; 
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($row['dr_latitude']))) + 
                (cos(deg2rad($latitude1)) * cos(deg2rad($row['dr_latitude'])) * 
                cos(deg2rad($theta))); 
    $distance = acos($distance); 
    $distance = rad2deg($distance); 
    $distance = $distance * 60 * 1.1515;
    
    $distance = $distance * 3.109344;
    
     



if($distance>6)
{

    
}
else
{


$val2=$row['id'];

$sql1 = "SELECT id,doctor_name,doc_hospital_clinic_name,doctor_addrs,doc_specific,time_specific,approvedby,managerlat,managerlong,dr_latitude,dr_longitude,doc_pin_id  FROM doctors WHERE  doctors.id='$val2'"; 



$result1 = mysql_query($sql1) or die(mysql_error());



while($row = mysql_fetch_array($result1))
{
if($count==0)
{

$val3=$row['doc_pin_id'];

$sql2 = "SELECT pincode FROM master_pincode WHERE  pin_id='$val3'"; 

$result2 = mysql_query($sql2) or die(mysql_error());



while($row2 = mysql_fetch_array($result2))
{
$val10= $row2['pincode'];

}

if($count==0)
{
$asd.='[{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"},';
'[{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"},';
}
else
{
$asd.='{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"}]';
'{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"}]';
}

$count++;

}
else
{
$count++;

if($p==0)
{
$asd.='{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"}]';
'{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"}]';
}
else 
{

$asd.='{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"},';
'{"id":"'.$row['id'].'",'.'"doctor_name":"'.$row['doctor_name'].'",'.'"doc_hospital_clinic_name":"'.$row['doc_hospital_clinic_name'].'",'.'"doctor_addrs":"'.$row['doctor_addrs'].'",'.'"doc_specific":"'.$row['doc_specific'].'",'.'"time_specific":"'.$row['time_specific'].'",'.'"approvedby":"'.$row['approvedby'].'",'.'"managerlat":"'.$row['managerlat'].'",'.'"managerlong":"'.$row['managerlong'].'",'.'"dr_latitude":"'.$row['dr_latitude'].'",'.'"dr_longitude":"'.$row['dr_longitude'].'","pincode":"'.$val10.'"},';
}

}


}


	
	
}
}


 //echo $asd;exit;
 
$filename = substr(strrchr($asd, ","), -1); 
if($filename ==']')
	{
	$op = $asd;
	}
if($filename =='}')
	{
	$op = $asd."]";
	}
	
if($filename ==',')
	{
	$last_character      = rtrim( $asd, ',' );
	$op = $last_character."]";
	}	

echo $op;
?>