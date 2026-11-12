<?php
include("connect1.php");

global $jjproid,$jpg_count,$count4,$mp4_count;

$jjproduct = mysql_query("SELECT * FROM product")or die(mysql_error());
$jjproduct_count = mysql_num_rows($jjproduct);

$outp;

$outpnu=0;

if($jjproduct_count > 0)
{
   
   while($jjproduct_res = mysql_fetch_array($jjproduct)) 
   {
  $jjproid = $jjproduct_res['id'];
  $jjproname = $jjproduct_res['pro_name'];

     $jjslide_count = mysql_query("SELECT COUNT(type) FROM tbl_product_adde_slide WHERE productid='".$jjproduct_res['id']."' AND type='jpg'")or die(mysql_error());
     $jjslide_count_res = mysql_fetch_array($jjslide_count);

   $jpg_count = $jjslide_count_res['COUNT(type)'];


     $jjslide_count = mysql_query("SELECT COUNT(type) FROM tbl_product_adde_slide WHERE productid='".$jjproduct_res['id']."' AND type='mp4'")or die(mysql_error());
     $jjslide_count_res = mysql_fetch_array($jjslide_count);

     $mp4_count = $jjslide_count_res['COUNT(type)'];
if($outpnu=='0')
{
$outp='[{"product":"'.$jjproid = $jjproduct_res['id'].'","productname":"'.$jjproname.'","image":"'.$jpg_count.'","video":"'.$mp4_count.'"},';
$outpnu++;
}
else
{
$outp=$outp.'{"product":"'.$jjproid = $jjproduct_res['id'].'","productname":"'.$jjproname.'","image":"'.$jpg_count.'","video":"'.$mp4_count.'"},';
}


   }

//echo $outp;
$jjop = substr($outp, 0, -1);
echo $jjfinop = $jjop.']';
}
else
{
echo "No Products found";
}
?>