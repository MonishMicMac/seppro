<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_product')
{
$p_id=$_POST['p_id'];
$count_p_id=count($p_id);
$pro_name=$_POST['pro_name'];
$comb=$_POST['comb'];
$packing=$_POST['packing'];
$type1=$_POST['type1'];
for($i=0; $i<=$count_p_id; $i++)
{ 	
echo "update product set pro_name='$pro_name[$i]',comb='$comb[$i]',packing='$packing[$i]',type1='$type1[$i]' where id='$p_id[$i]'";
mysql_query("update product set pro_name='$pro_name[$i]',comb='$comb[$i]',packing='$packing[$i]',type1='$type1[$i]' where id='$p_id[$i]'");


}

echo "<script type='text/javascript'>alert('Product Edited Successfully');window.location='view_product.php';</script>";


}





?>