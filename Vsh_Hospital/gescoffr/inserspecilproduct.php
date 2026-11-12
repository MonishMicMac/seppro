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

$jj = mysql_query("SELECT * FROM promoted_products WHERE product_id= '$exp[$i]' AND group_name= '$group_name' AND rep_id= '$rep_id' AND doc_id='$doc_id'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


   }
   else
   {
mysql_query("insert into promoted_products(product_id,group_name,rep_id,doc_id)values('$exp[$i]','$group_name','$rep_id','$doc_id')")or die(mysql_error());


}




}











?>