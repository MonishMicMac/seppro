<?php

include('connect23.php');
$exp = explode(',',$_REQUEST['docid']);
for($i=0;$i<count($exp);$i++)
{	
	
	$jj = mysql_query("SELECT * FROM unapproveddoctors WHERE id= '$exp[$i]' AND rep_id= '".$_REQUEST['repid']."'")or die(mysql_error());
	while($jjres=mysql_fetch_array($jj))
	{
		mysql_query("INSERT INTO doctors(doctor_name,dob,anniversary,doc_gender,rep_assign,chemist_id,rep_id,doc_specilist_id,doc_qualification,patientpervisit,doc_category,doc_patient_type,doc_yr_practice,doc_practice_loc,doc_practice_pday,doc_pincode,doc_current_loc,doc_classification,doc_loc_address,dr_latitude,dr_longitude,doc_specific,time_specific,visitpermonth,doc_regis_no,doctor_addrs,doc_district_id,doc_area_id,doc_pin_id,doc_contact_no,email,doc_hospital_clinic_name,doc_status,c_time,c_date,approvedby,managerlat,managerlong,managerapprovestatus,areanameee,prescriber,applyforedit,onetimeallowforrep,repiddelete,visitintervaltovisit,stationtype,visitcardclinicphoto,favourite,plottingopentwotimes,state_id,division_id,viistcount)VALUES('".$jjres['doctor_name']."','".$jjres['dob']."','".$jjres['anniversary']."','".$jjres['doc_gender']."','".$jjres['rep_assign']."','".$jjres['chemist_id']."','".$jjres['rep_id']."','".$jjres['doc_specilist_id']."','".$jjres['doc_qualification']."','".$jjres['patientpervisit']."','".$jjres['doc_category']."','".$jjres['doc_patient_type']."','".$jjres['doc_yr_practice']."','".$jjres['doc_practice_loc']."','".$jjres['doc_practice_pday']."','".$jjres['doc_pincode']."','".$jjres['doc_current_loc']."','".$jjres['doc_classification']."','".$jjres['doc_loc_address']."','".$jjres['dr_latitude']."','".$jjres['dr_longitude']."','".$jjres['doc_specific']."','".$jjres['time_specific']."','".$jjres['visitpermonth']."','".$jjres['doc_regis_no']."','".$jjres['doctor_addrs']."','".$jjres['doc_district_id']."','".$jjres['doc_area_id']."','".$jjres['doc_pin_id']."','".$jjres['doc_contact_no']."','".$jjres['email']."','".$jjres['doc_hospital_clinic_name']."','".$jjres['doc_status']."','".$jjres['c_time']."','".$jjres['c_date']."','".$jjres['approvedby']."','".$jjres['managerlat']."','".$jjres['managerlong']."','".$jjres['managerapprovestatus']."','".$jjres['areanameee']."','".$jjres['prescriber']."','".$jjres['applyforedit']."','".$jjres['onetimeallowforrep']."','".$jjres['repiddelete']."','".$jjres['visitintervaltovisit']."','".$jjres['stationtype']."','".$jjres['visitcardclinicphoto']."','".$jjres['favourite']."','".$jjres['plottingopentwotimes']."','".$jjres['state_id']."','".$jjres['division_id']."','".$jjres['viistcount']."')")or die(mysql_error());


		mysql_query("UPDATE unapproveddoctors SET rep_id='0',rep_assign='0' WHERE id='$exp[$i]'")or die(mysql_error());
	}
}


?>