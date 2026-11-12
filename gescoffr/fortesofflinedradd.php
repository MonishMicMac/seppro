<?php

include("connect1.php");

$drname=$_REQUEST['drname'];
$rep_id=$_REQUEST['rep_id'];
$pincode=$_REQUEST['pincode'];
$state_id=$_REQUEST['state_id'];


$pincodearray = explode(",",$pincode);
$drnamearray= explode(",",$drname);

for($i=0;$i< count($pincodearray);$i++)
{



 $jjxx = mysql_query("SELECT * FROM doctors WHERE doctor_name= '$drnamearray[$i]' AND doc_pincode= '$pincodearray[$i]' AND rep_id= '$rep_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$pincode1=trim($pincodearray[$i]);
$sql=mysql_query("SELECT id,dist_id,pin_id FROM pincode_list WHERE pincode='$pincode1' order by id asc limit 1");
$row=mysql_fetch_array($sql);


$jjrepid = mysql_query("SELECT mark_id FROM representative WHERE id='$rep_id'");
$jjrepid_res=mysql_fetch_array($jjrepid);


$jjsdzz = mysql_query("insert into doctors(doctor_name,doc_pincode,rep_id,doc_pin_id,doc_area_id,doc_district_id,state_id,division_id)values('$drnamearray[$i]','$pincode1','$rep_id','".$row['pin_id']."','".$row['id']."','".$row['dist_id']."','$state_id','".$jjrepid_res['mark_id']."')")or die(mysql_error());


$lastid = mysql_insert_id();


$jjsdzz = mysql_query("insert into tbl_cds_master(tbl_cds_dcsid,tbl_cds_pinid,tbl_cds_areaid,tbl_cds_stateid,tbl_cds_districtid,tbl_cds_repid,tbl_cds_divisionid,tbl_cds_pincode,tbl_cds_status)values('$lastid','".$row['pin_id']."','".$row['id']."','$state_id','".$row['dist_id']."','$rep_id','".$jjrepid_res['mark_id']."','$pincode1','D')")or die(mysql_error());


}


}


?>
