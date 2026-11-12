<?php
include("connect23.php"); 

$pid=$_REQUEST['pid'];
$repid=$_REQUEST['repid'];

$proid = explode(",",$pid);


for($i=0;$i< count($proid);$i++)
{

mysql_query("UPDATE doctors SET favourite='0' WHERE id=$proid[$i] and rep_assign='$repid'")or die(mysql_error());


}

?>