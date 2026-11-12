<?php
include("connect1.php"); 


$favourite=$_REQUEST['favourite'];
$id=$_REQUEST['id'];

if($favourite=="One Time Visit")
{
	mysql_query("update doctors set favourite='1' where id='$id'")or die(mysql_error());

}
else if($favourite=="Two Time Visit")
{
	mysql_query("update doctors set favourite='2' where id='$id'")or die(mysql_error());

}
else if($favourite=="Three Time Visit")
{
	mysql_query("update doctors set favourite='3' where id='$id'")or die(mysql_error());

}




?>