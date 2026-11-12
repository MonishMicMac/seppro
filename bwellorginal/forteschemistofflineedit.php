<?php

include("connect1.php");


$idd=$_REQUEST['idd'];;
$rep_id=$_REQUEST['rep_id'];;
$pincode1=$_REQUEST['pincode1'];;
$state_id=$_REQUEST['state_id'];;

$pinidarray= explode(",",$idd);
$pincode= explode(",",$pincode1);

for($i=0;$i< count($pinidarray);$i++)
{

$pincode1=trim($pincode[$i]);
$sql=mysql_query("SELECT id,dist_id FROM pincode_list WHERE pincode='$pincode1' order by id asc limit 1");
$row=mysql_fetch_array($sql);

$select=mysql_query("SELECT pin_id FROM pincode_list where pincode='$pincode1' limit 1");
$sel_row=mysql_fetch_array($select);
$pin_id=$sel_row['pin_id'];

$jjsdzz = mysql_query("UPDATE tbl_customer_master SET pin_id='$pin_id',rep_id='$rep_id',pincode='$pincode[$i]',area_id='".$row['id']."',district_id='".$row['dist_id']."',state_id='$state_id' WHERE id='$pinidarray[$i]'")or die(mysql_error());

echo "UPDATE tbl_customer_master SET pin_id='$pin_id',rep_id='$rep_id',pincode='$pincode[$i]',area_id='".$row['id']."',district_id='".$row['dist_id']."',state_id='$state_id' WHERE id='$pinidarray[$i]'";


}



?>
