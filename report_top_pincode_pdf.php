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

/*
					if(@$_REQUEST["division_id"]!=""){
                        $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
                    } else {
                        if($_SESSION["division_id"]!="ALL")
                            $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
                        else 
                            $division_default = "";
                    }

                

                    if(@$_REQUEST["state"]) {
                        $state_check = "and a.state_id='".(@$_REQUEST["state"])."'";
                        $state_url = "&state_id=".(@$_REQUEST["state"]);
                    } else {

                        if($_SESSION["state_id"]!="ALL") {
                            $state_check = " and a.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                        } else {
                            $state_check = "";
                        }

                        $state_url = "";
                    }*/



/*$a1=mysql_query("SELECT SUM(a.quantity) AS SQTY, SUM(a.free_quantity) AS SFQTY, SUM(a.replace_quantity) AS SRQTY, SUM(a.quantity*a.pts) AS TOTPTS, SUM(a.quantity*a.ptr) AS TOTPTR FROM areawise_temp a WHERE (a.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND a.dist_id = '".$_REQUEST["dist_id"]."' ".$division_default." ".$state_check)or die(mysql_error());$customer11=mysql_fetch_object($a1);

$html.=" <br> [PTR Value: ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($customer11->TOTPTS,2)."]";*/
$html.="</tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Top Pincode Report</td></tr>";

$html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Product Name</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">QTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No customer Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Rep Covered</th></tr>";


			  if(@$_REQUEST["division_id"]!=""){
                            $division_default = "and areawise_temp.division_id='".@$_REQUEST['division_id']."' ";
                        } else {
                         
                            $division_default = "";
                        }
                        if(@$_REQUEST["state_id"]!=""){
                            $state_default = "and areawise_temp.state_id='".@$_REQUEST['state_id']."' ";
                        } else{
                            $state_default="";
                        }
 

                        $sqltp=mysql_query("SELECT areawise_temp.pincode AS PIN, round(SUM(areawise_temp.quantity*areawise_temp.ptr)) AS TOTPTR, round(SUM(areawise_temp.quantity*areawise_temp.pts)) AS TOTPTS,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_qty FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.pincode ORDER BY TOTPTR DESC LIMIT 10");

while($product=mysql_fetch_object($sqltp)){

// First Row - Start

$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$product->PIN."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$product->TOTPTR."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$product->TOTPTS."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$product->cust_qty."</td></tr>";
//<td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->QTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->FQTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->RQTY."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->PTR,2)."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->PTS,2)."</td>
 // First Row - END

}
// }
/*$html.="<tr><td colspan=\"4\"><strong>Total</strong></td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SFQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SRQTY."</td><td align=\"right\" style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTR,2)."</td><td style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTS,2)."</td></tr>";
*/$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>