<?php


include("connect2.php"); 
$pid=$_REQUEST['pid'];



$proid = explode(",",$pid);
for($i=0;$i< count($proid);$i++)
{
$jj = mysql_query("SELECT * FROM temp_doctor_store WHERE id=$proid[$i]")or die(mysql_error());
 
$jj_res = mysql_fetch_array($jj);


     mysql_query(" INSERT INTO doctors(doc_hospital_clinic_name,doctor_name,rep_assign,rep_id,doc_specilist_id,doc_qualification,patientpervisit,doc_pincode,doctor_addrs,doc_pin_id,prescriber) VALUES('".$jj_res['hospitalname']."','".$jj_res['drname']."','".$jj_res['repassign']."','".$jj_res['repid']."','".$jj_res['specialist']."','".$jj_res['qualification']."','".$jj_res['patientpervisit']."','".$jj_res['docpincode']."','".$jj_res['docaddress']."','".$jj_res['docpinid']."','".$jj_res['prescriber']."')")or die(mysql_error());


mysql_query("DELETE FROM temp_doctor_store WHERE id=$proid[$i]")or die(mysql_error());


}

?>
