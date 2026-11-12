<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_mapping')
{
$p_id=$_POST['distrib_id'];
$cust_id=$_POST['cut_id'];
$fil_ary=array_filter($p_id);
$final=array_values($fil_ary);
$keys=array_keys($fil_ary);
$key_count=count($keys)-1;
$matched_values=array();
for($i=0;$i<=$key_count;$i++)
{
   $matched_values[]=$cust_id[$keys[$i]];
}

for($j=0;$j<=$key_count;$j++)
{
    mysql_query("insert into customer_mapping(distributor_cust_id,customer_id)values('".$matched_values[$j]."','".$final[$j]."')")or die(mysql_query());
}

echo '<script type="text/javascript">alert("Customer mapped sucessfully");window.location.href="distributor_customer_mapping.php";</script>';






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

