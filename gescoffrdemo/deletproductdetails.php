<?php
include("connect1.php"); 




$product_id=$_REQUEST['product_id'];
$group_name=$_REQUEST['group_name'];
$rep_id=$_REQUEST['rep_id'];
$doc_id=$_REQUEST['doc_id'];


$exp = explode(',',$product_id);

$count = count($exp);

for($i=0;$i<$count;$i++)
{


 mysql_query("DELETE FROM promoted_products WHERE product_id='$exp[$i]' AND group_name='$group_name' AND rep_id='$rep_id' AND doc_id='$doc_id'")or die(mysql_error());






}











?>