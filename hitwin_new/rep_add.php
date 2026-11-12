<?php
include('connect.php');
$chk=mysql_query("SELECT * FROM representative WHERE rep_id='".$_REQUEST['catid']."' AND rep_name='".$_REQUEST['rep_name']."' AND mobile='".$_REQUEST['mobile']."'")or die(mysql_error());
if(mysql_num_rows($chk)>0)
{
 	echo "Same rep already added for same category with same mobile no";
}
else
{
	mysql_query("INSERT INTO representative(rep_id,rep_name,mobile,email)VALUES('".$_REQUEST['catid']."','".$_REQUEST['rep_name']."','".$_REQUEST['mobile']."','".$_REQUEST['email']."')");
	echo "Added";
}
?>