<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_product')
{
$p_id=$_POST['p_id'];
$cnt=count($p_id);
$our_id=$_POST['our_id'];
for($i=0;$i<=$cnt;$i++)
{
    mysql_query("update dist_prod set our_id='$our_id[$i]' where id='$p_id[$i]'");
}


$a=mysql_query("select * from dist_prod where our_id!=''");
while($row_a=mysql_fetch_array($a))
{
    $p_id=$row_a['id'];
    $status=2;
    mysql_query("update dist_prod set status='$status' where id='$p_id'");
}
echo "<script type='text/javascript'>alert('Product Matched Successfully');window.location='upload_product.php';</script>";

}

