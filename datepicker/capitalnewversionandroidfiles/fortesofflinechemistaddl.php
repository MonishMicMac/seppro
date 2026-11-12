<?php

include("connect23.php"); 

$drname=$_REQUEST['drname'];
$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$state_id=$_REQUEST['state_id'];

$pinidarray= explode(",",$pin_id);
$pincodearray = explode(",",$pincode);
$drnamearray= explode(",",$drname);

for($i=0;$i< count($pinidarray);$i++)
{



 $jjxx = mysql_query("SELECT * FROM tbl_customer_master WHERE shop_name= '$drnamearray[$i]' AND pincode= '$pincodearray[$i]' AND rep_id= '$rep_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$pincode1=trim($pincodearray[$i]);
$sql=mysql_query("SELECT id,dist_id FROM pincode_list WHERE pincode='$pincode1' order by id asc limit 1");
$row=mysql_fetch_array($sql);


$jjrepid = mysql_query("SELECT mark_id FROM representative WHERE id='$rep_id'");
$jjrepid_res=mysql_fetch_array($jjrepid);

$select=mysql_query("SELECT pin_id FROM pincode_list where pincode='$pincode1' limit 1");
$sel_row=mysql_fetch_array($select);
$pin_id=$sel_row['pin_id'];

$jjsdzz = mysql_query("insert into tbl_customer_master(shop_name,pincode,rep_id,pin_id,area_id,district_id,state_id,division_id)values('$drnamearray[$i]','$pincode1','$rep_id','$pin_id','".$row['id']."','".$row['dist_id']."','$state_id','".$jjrepid_res['mark_id']."')")or die(mysql_error());


$lastid = mysql_insert_id();


$jjsdzz = mysql_query("insert into tbl_cds_master(tbl_cds_dcsid,tbl_cds_pinid,tbl_cds_areaid,tbl_cds_stateid,tbl_cds_districtid,tbl_cds_repid,tbl_cds_divisionid,tbl_cds_pincode,tbl_cds_status)values('$lastid','$pin_id','".$row['id']."','$state_id','".$row['dist_id']."','$rep_id','".$jjrepid_res['mark_id']."','$pincode1','C')")or die(mysql_error());


}


}


?>