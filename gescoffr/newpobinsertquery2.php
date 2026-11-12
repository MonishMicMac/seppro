<?php
include("connect1.php");
$pob_type=$_REQUEST['pob_type'];
$dc_id=$_REQUEST['dc_id'];
$stockist_type=$_REQUEST['stockist_type'];
$stockist_id=$_REQUEST['stockist_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$mrp=$_REQUEST['mrp'];
$paymentterms=$_REQUEST['paymentterms'];


$tptr=$_REQUEST['tptr'];


$repid=$_REQUEST['repid'];
$pono=$_REQUEST['pono'];
$chemistid=$_REQUEST['chemistid'];

$druglic=$_REQUEST['druglic'];
$regno=$_REQUEST['regno'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);
$mrpid= explode(",",$mrp);
$tptrid = explode(",",$tptr);

global $leaverepid,$repname,$leavedate,$leavereason;

$antony= mysql_query("SELECT * FROM mst_pob WHERE pobbillno= '$pono'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

   }
   else
   {
for($i=0;$i< count($proid);$i++)
{


mysql_query("insert into mst_pob(pob_type,dc_id,stockist_type,stockist_id,pob_product,pob_product_qty,pob_free_qty,nego,cdate,ctime,repid,paymentterms,pobbillno,chemistid,druglic,regno)values('$pob_type','$dc_id','$stockist_type','$stockist_id','$proid[$i]','$qtyid[$i]','$mrpid[$i]','$tptrid[$i]','$c_date','$c_time','$repid','$paymentterms','$pono','$chemistid','$druglic','$regno')")or die(mysql_error());



}
}



?>