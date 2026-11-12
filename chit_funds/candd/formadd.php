<?php
include('connect.php');








$chkall=mysql_query("SELECT * FROM profileenrollment WHERE membername='".$_REQUEST['membername']."' AND shopmobile='".$_REQUEST['shopmobile']."' AND pharamaname='".$_REQUEST['pharamaname']."' AND mobile='".$_REQUEST['mobile']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{
mysql_query("INSERT INTO profileenrollment(membername,firmname,proprietor,address,zone,bloodgroup,shopphoneres,shopmobile,shopemail,dlno,dateofissue,validity,pharamaname,regno,mobile,email,tinno,cstno,choose)VALUES('".$_REQUEST['membername']."','".$_REQUEST['firmname']."','".$_REQUEST['proprietor']."','".$_REQUEST['address']."','".$_REQUEST['zone']."','".$_REQUEST['bloodgroup']."','".$_REQUEST['shopphoneres']."','".$_REQUEST['shopmobile']."','".$_REQUEST['shopemail']."','".$_REQUEST['dlno']."','".$_REQUEST['dateofissue']."','".$_REQUEST['validity']."','".$_REQUEST['pharamaname']."','".$_REQUEST['regno']."','".$_REQUEST['mobile']."','".$_REQUEST['email']."','".$_REQUEST['tinno']."','".$_REQUEST['cstno']."','".$_REQUEST['choose']."')")or die(mysql_error());
}






?>