<?php
include("include/connect.php");
$mark_abb=$_GET['q'];
$result2=mysql_query("select * from marketer where mark_abb='$mark_abb'") or die(mysql_error());
$count=mysql_num_rows($result2);
if($count=='0')
{
echo "Avaliable";
}
else
{
echo "Not Avaliable";
}



?>