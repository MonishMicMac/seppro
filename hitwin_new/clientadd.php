<?php
include('connect.php');

$chkall=mysql_query("SELECT * FROM clinetcreation WHERE name='".$_REQUEST['name']."' AND name1='".$_REQUEST['name1']."' AND name2='".$_REQUEST['name2']."' AND pincode='".$_REQUEST['pincode']."' AND address='".$_REQUEST['address']."' AND mobileno='".$_REQUEST['mobileno']."' AND mobileno1='".$_REQUEST['mobileno1']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
echo '0';


}
else
{
mysql_query("INSERT INTO clinetcreation(companyname,name,name1,name2,address,pincode,type,mobileno,mobileno1,repid,date,time,emailid,emailid1,landmark,typeofcustomer,desgination,NAME1DESIG)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['name']."','".$_REQUEST['name1']."','".$_REQUEST['name2']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['type']."','".$_REQUEST['mobileno']."','".$_REQUEST['mobileno1']."','".$_REQUEST['repid']."','".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['emailid']."','".$_REQUEST['emailid1']."','".$_REQUEST['landmark']."','".$_REQUEST['tycu']."','".$_REQUEST['desginationnew']."','".$_REQUEST['namenew']."')")or die(mysql_error());

$id = mysql_insert_id();

$succ=mysql_query("SELECT id FROM clinetcreation WHERE id='".$id."' ")or die(mysql_error());

$data=mysql_fetch_assoc($succ);

echo $data['id'];






}






?>
