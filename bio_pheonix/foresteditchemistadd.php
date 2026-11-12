<?php

include("connect23.php"); 


$idd=$_REQUEST['idd'];
$shop_name=$_REQUEST['shop_name'];

$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$state_id=$_REQUEST['state_id'];
$changepincode=$_REQUEST['changepincode'];

if($changepincode=='not')
{
$jjsdzz = mysql_query("UPDATE tbl_customer_master SET shop_name='$shop_name' WHERE id='$idd'")or die(mysql_error());

}
else
{
$pincode1=trim($pincode);
$sql=mysql_query("SELECT id,dist_id FROM pincode_list WHERE pincode='$pincode1' order by id asc limit 1");
$row=mysql_fetch_array($sql);

$jjsdzz = mysql_query("UPDATE tbl_customer_master SET shop_name='$shop_name',pin_id='$pin_id',rep_id='$rep_id',pincode='$pincode',area_id='".$row['id']."',district_id='".$row['dist_id']."',state_id='$state_id' WHERE id='$idd'")or die(mysql_error());



}






?>