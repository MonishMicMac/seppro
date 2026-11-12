<?php
include('connect.php');








$chkall=mysql_query("SELECT * FROM clinetcreation WHERE name='".$_REQUEST['name']."' AND pincode='".$_REQUEST['pincode']."' AND address='".$_REQUEST['address']."' AND mobileno='".$_REQUEST['mobileno']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{
mysql_query("INSERT INTO clinetcreation(companyname,name,address,pincode,type,mobileno,repid,date,time)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['name']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['type']."','".$_REQUEST['mobileno']."','".$_REQUEST['repid']."','".$_REQUEST['date']."','".$_REQUEST['time']."')")or die(mysql_error());
}






?>