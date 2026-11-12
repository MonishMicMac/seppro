<?php
include("include/connect.php");
$did_abb=$_GET['q'];
if($did_abb === "")
{
 echo "1";   
}
else
{
$result2=mysql_query("select * from distributor where dis_abb='$did_abb'") or die(mysql_error());
$count=mysql_num_rows($result2);
if($count=='0')
{
echo "0";
}
else
{
echo "1";
}
}
