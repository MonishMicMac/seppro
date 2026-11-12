<?php
include("connect23.php"); 

$pid=$_REQUEST['pid'];
$repid=$_REQUEST['repid'];


if($pid=='ALL')
{
mysql_query("UPDATE doctors SET dr_latitude='',dr_longitude='' WHERE rep_assign=$repid")or die(mysql_error());
}
else
{
$proid = explode(",",$pid);





for($i=0;$i< count($proid);$i++)
{



mysql_query("UPDATE doctors SET dr_latitude='',dr_longitude='' WHERE id=$proid[$i]")or die(mysql_error());


}

}





?>