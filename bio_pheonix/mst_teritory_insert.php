<?php
include("connect23.php"); 


$teritery_name=$_REQUEST['teritoryname'];

$station=$_REQUEST['station'];
$division_idd=$_REQUEST['divisionidd'];

$pincode=$_REQUEST['pincode'];
$rep_id=$_REQUEST['rep_id'];
$state_id=$_REQUEST['state_id'];


mysql_query("INSERT INTO mst_tertiary(state_id,tertiary_name,teritary_rep_id,teritary_type)VALUES('$state_id','$teritery_name','$rep_id','$station')")or die(mysql_error());
$t_id=mysql_insert_id();

$proid = explode(",",$pincode);

for($i=0;$i<count($proid);$i++) {

$select=mysql_query("SELECT pin_id FROM pincode_list where pincode='$proid[$i]' limit 1");
$sel_row=mysql_fetch_array($select);
$pin_id=$sel_row['pin_id'];

mysql_query("INSERT INTO tbl_tertiary(state_id,tertiary_id,tertiary_pin)VALUES('$state_id','$t_id','$pin_id')")or die(mysql_error());

mysql_query("INSERT INTO rep_area(rep_id,pin_id,c_date,c_time,division_idd)VALUES('$rep_id','$pin_id',CURDATE(),CURTIME(),'$division_idd')")or die(mysql_error());

}



?>