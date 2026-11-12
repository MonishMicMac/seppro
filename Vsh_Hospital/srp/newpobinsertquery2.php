<?php
include("connect2.php"); 

$pob_type=$_REQUEST['pob_type'];
$dc_id=$_REQUEST['dc_id'];
$stockist_type=$_REQUEST['stockist_type'];
$stockist_id=$_REQUEST['stockist_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$mrp=$_REQUEST['mrp'];
$paymentterms=$_REQUEST['paymentterms'];

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


mysql_query("insert into mst_pob(pob_type,dc_id,stockist_type,stockist_id,pob_product,pob_product_qty,pob_free_qty,cdate,ctime,repid,paymentterms,pobbillno,chemistid,druglic,regno)values('$pob_type','$dc_id','$stockist_type','$stockist_id','$proid[$i]','$qtyid[$i]','$mrpid[$i]','$c_date','$c_time','$repid','$paymentterms','$pono','$chemistid','$druglic','$regno')")or die(mysql_error());



}

$jjrepname = mysql_query("SELECT rep_name FROM representative WHERE id = '$repid'")or die(mysql_error());
$jjrename_res = mysql_fetch_array($jjrepname);

$leaverepid= $repid;

$repname= $jjrename_res['rep_name'];
$leavedate= $c_date;
$leavereason= 'pob';


$a = mysql_query("SELECT managerid FROM assigningreptomanager WHERE repid='$repid'")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{

$jjgcm  = mysql_query("SELECT * FROM gcm_users WHERE name='".$jj['managerid']."'")or die(mysql_error());
while($jjgcm_res = mysql_fetch_array($jjgcm))
{

$gcmlen = strlen($jjgcm_res['gcm_regid']);
    if($gcmlen <5)
    {
    }
    else
    {
           echo $jjgcm_res['gcm_regid'];echo "<br>";
           
    
$regId = $jjgcm_res['gcm_regid'];

    $message = $leaverepid.",".$leavedate.",".$leavereason.",".$repname;
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
    }
}

}


}



?>