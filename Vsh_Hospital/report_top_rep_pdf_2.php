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

if(@$_REQUEST['state_id']==''){

                        if(@$_REQUEST["division_id"]!=""){
                            $division_default = "and b.division_id='".@$_REQUEST['division_id']."' ";
                        } else {
                         
                            $division_default = "";
                        }
                        if(@$_REQUEST["state_id"]!=""){
                            $state_default = "and a.state_id='".@$_REQUEST['state_id']."' ";
                        } else{
                            $state_default="";
                        }


                        $sqltp=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");


                    $html.="<tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Top Rep Report</td></tr>";

                    $html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Rank</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">REP NAME</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">State</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of covered Product</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Covered Product</th>";



$i=1;


                    while($rep=mysql_fetch_object($sqltp)){
 
            
          

$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$i."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$rep->repname."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">";

$state=mysql_query("SELECT * from master_state where state_id='".$rep->state_id."'"); 
            $row_state=mysql_fetch_object($state);
            

$html.="".$row_state->state_name."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$rep->PROD."</td>   ";

$html.="<td><table style=\"border:1px solid #333333;\"><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Product Name</th><th align=\"center\"style=\"text-align:center;border:1px solid #333333;\">Qty</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Pincode Covered</th></tr>";


 $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$rep->rep_id."' AND `our_product_id`!='' AND (`bill_date` BETWEEN '2017/06/01' AND '2017/07/31') GROUP BY `our_product_id`");
                    while ($pro_details=mysql_fetch_object($pro)) {

 $html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$pro_details->proname."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$pro_details->pro_qty."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$pro_details->pro_pinid."</td></tr></td>";


}
$html.="</table></td></tr>";

$i++;
}

$html.="</table>";
}
if(@$_REQUEST['state_id']!=''){

    if(@$_REQUEST["division_id"]!=""){
        $division_default = "and b.division_id='".$_REQUEST['division_id']."' ";
    } else {
      
            $division_default = "";
    }
    if(@$_REQUEST["state_id"]!=""){
        $state_default = "and a.state_id='".$_REQUEST['state_id']."' ";
    } else{
        $state_default="";
    }
/*echo "SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC";
exit;*/
     $sqltp=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");


  $html.="<tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Top Rep Report</td></tr>";

  $html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Rank</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">REP NAME</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of covered Product</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Covered Product</th>";

$i=1;
                    while($rep=mysql_fetch_object($sqltp)){
 
$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$i."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$rep->repname."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$rep->PROD."</td>   ";

$html.="<td><table style=\"border:1px solid #333333;\"><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Product Name</th><th align=\"center\"style=\"text-align:center;border:1px solid #333333;\">Qty</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Pincode Covered</th></tr>";


 $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$rep->rep_id."' AND `our_product_id`!='' AND (`bill_date` BETWEEN '2017/06/01' AND '2017/07/31') GROUP BY `our_product_id`");
                    while ($pro_details=mysql_fetch_object($pro)) {



 $html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$pro_details->proname."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$pro_details->pro_qty."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$pro_details->pro_pinid."</td></tr></td>";


}
$html.="</table></td></tr>";

$i++;
}

$html.="</table>";
}  

include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
/*exit;*/
?>