<?php
include("connect23.php"); 

$pid=$_REQUEST['pid'];
$repid=$_REQUEST['repid'];



$proid = explode(",",$pid);





for($i=0;$i< count($proid);$i++)
{



mysql_query("UPDATE doctors SET repiddelete=$repid,rep_id='0',rep_assign='0' WHERE id=$proid[$i]")or die(mysql_error());


}

?>