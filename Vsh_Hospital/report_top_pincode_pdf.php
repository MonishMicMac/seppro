<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);
$html="<table style=\"width:100%;border:1px solid #333333;\"><tr><td colspan=\"9\" align=\"center\"  style=\"color:#000000; border:none;\">".$_SESSION["CNAME"]."</tr><tr><td colspan=\"9\" align=\"center\"  style=\"color:#000000;border:1px solid #333333;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."";

if(@$_REQUEST["division_id"]!=""){
    $division_default = "and areawise_temp.division_id='".@$_REQUEST["division_id"]."'";
} else {
    if($_SESSION["division_id"]!="ALL"){
        $division_default = " and areawise_temp.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
    } else {
        $division_default = "";
    }
}

if(@$_REQUEST["state_id"]) {
    $state_check = "and areawise_temp.state_id='".(@$_REQUEST["state_id"])."'";
} else {
    if($_SESSION["state_id"]!="ALL") {
        $state_check = " and areawise_temp.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
    } else {
        $state_check = "";
    }
}

$html.="</tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Top Pincode Report</td></tr>";

$html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Product Name</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">QTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No customer Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Rep Covered</th></tr>";

$sqltp=mysql_query("SELECT areawise_temp.pincode AS PIN, round(SUM(areawise_temp.quantity*areawise_temp.ptr)) AS TOTPTR, round(SUM(areawise_temp.quantity*areawise_temp.pts)) AS TOTPTS,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_qty FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_check." ".$division_default." AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.pincode ORDER BY TOTPTR DESC LIMIT 10");
while($product=mysql_fetch_object($sqltp)){
    $html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$product->PIN."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$product->TOTPTR."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$product->TOTPTS."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$product->cust_qty."</td></tr>";
}
$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>