<?php
include("connect23.php"); 



$state_id=$_REQUEST['state_id'];
$district_id=$_REQUEST['district_id'];
$newpincode=$_REQUEST['newpincode'];
$areaname=$_REQUEST['areaname'];
$rep_id=$_REQUEST['rep_id'];

$sql=mysql_query("SELECT state_name FROM master_state WHERE state_id='$state_id'");
$row=mysql_fetch_array($sql);
$state_name=$row['state_name'];

mysql_query("INSERT INTO master_pincode(state_id,district_id,pincode) VALUES('$state_id','$district_id','$newpincode')");
$pin_id=mysql_insert_id();

mysql_query("INSERT INTO pincode_list(state_id, state_name, dist_id, area_name, pin_id, pincode, c_date, c_time) VALUES('$state_id', '$state_name', '$district_id', '$areaname', '$pin_id', '$newpincode',CURDATE(),CURTIME())");

?>