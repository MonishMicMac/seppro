<?php
include("connect23.php"); 

$pid=$_REQUEST['pid'];
$repid=$_REQUEST['repid'];

$srepid=$_REQUEST['srepid'];



if($pid=='ALL')
{
mysql_query("UPDATE doctors SET rep_assign='$repid',rep_id='$repid',shiftid='$srepid' WHERE rep_assign='$srepid'")or die(mysql_error());
}
else
{
$proid = explode(",",$pid);





for($i=0;$i< count($proid);$i++)
{



mysql_query("UPDATE doctors SET rep_assign='$repid',rep_id='$repid',shiftid='1' WHERE id=$proid[$i]")or die(mysql_error());


}

}





?>