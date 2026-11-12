<?php
include("connect1.php");


$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$mrp=$_REQUEST['mrp'];
$tptr=$_REQUEST['tptr'];


$repid=$_REQUEST['repid'];
$billno=$_REQUEST['billno'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);
$mrpid= explode(",",$mrp);
$tptrid = explode(",",$tptr);


$result = mysql_query("SELECT pobstatus FROM mst_pob WHERE pobbillno= '$billno'");

if ($result) {
  $row = mysql_fetch_assoc($result);
  $rt=$row['pobstatus']+1;
}

$jjsd = mysql_query("UPDATE mst_pob SET pobstatus=$rt WHERE pobbillno= '$billno'")or die(mysql_error());



$jjs = mysql_query("UPDATE mst_pob SET managerid=$repid WHERE pobbillno= '$billno'")or die(mysql_error());


for($i=0;$i< count($proid);$i++)
{


   $antony= mysql_query("SELECT * FROM mst_pob WHERE pobbillno= '$billno' AND pob_product=$proid[$i] AND pob_product_qty=$qtyid[$i] AND pob_free_qty=$mrpid[$i]")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {
$jj = mysql_query("UPDATE mst_pob SET nego=$tptrid[$i] WHERE pobbillno= '$billno' AND pob_product=$proid[$i] AND pob_product_qty=$qtyid[$i] AND pob_free_qty=$mrpid[$i]")or die(mysql_error());
   }
   else
   {



   }


}



?>