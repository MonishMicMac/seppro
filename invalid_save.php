<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_invalid')
{
$i_id=$_POST['i_id'];
//print_r($i_id);

$a_id=$_POST['a_id'];
//print_r($a_id);
$cnt=count($i_id);
//echo $cnt;
$our_id=$_POST['our_id'];
for($i=0;$i<=$cnt;$i++)
{
//echo "update areawise_temp set pincode='$our_id[$i]' where id='$a_id[$i]'";
mysql_query("update areawise_temp set pincode='$our_id[$i]' where id='$a_id[$i]'");

//echo "delete from invalid_total where id='$i_id[$i]'";
mysql_query("delete from invalid_total where id='$i_id[$i]'");

}


echo "<script type='text/javascript'>alert('Matched Successfully');window.location='match_invalid.php';</script>";

}


?>