<?php
include('connect.php');








$chkall=mysql_query("SELECT * FROM clinetcreation WHERE name='".$_REQUEST['name']."' AND pincode='".$_REQUEST['pincode']."' AND address='".$_REQUEST['address']."' AND mobileno='".$_REQUEST['mobileno']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
echo '0';


}
else
{
mysql_query("INSERT INTO clinetcreation(companyname,name,address,pincode,type,mobileno,repid,date,time,emailid,landmark,typeofcustomer)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['name']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['type']."','".$_REQUEST['mobileno']."','".$_REQUEST['repid']."','".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['emailid']."','".$_REQUEST['landmark']."','".$_REQUEST['tycu']."')")or die(mysql_error());



$succ=mysql_query("SELECT id FROM clinetcreation WHERE companyname='".$_REQUEST['companyname']."' AND time='".$_REQUEST['time']."' AND emailid='".$_REQUEST['emailid']."' AND landmark='".$_REQUEST['landmark']."' AND date='".$_REQUEST['date']."' AND type='".$_REQUEST['type']."' AND name='".$_REQUEST['name']."' AND pincode='".$_REQUEST['pincode']."' AND address='".$_REQUEST['address']."' AND mobileno='".$_REQUEST['mobileno']."'")or die(mysql_error());

$data=mysql_fetch_assoc($succ);

echo $data['id'];






}






?>