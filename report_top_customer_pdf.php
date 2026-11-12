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
 

                        $sqltp=mysql_query("SELECT our_cust_id,(select shop_name from tbl_customer_master where id =areawise_temp.our_cust_id) as CUSTOMER_NAME,ROUND(SUM(areawise_temp.quantity*ptr),2) AS PTR,ROUND(SUM(areawise_temp.quantity*pts),2) AS PTS ,sum(areawise_temp.quantity) as qty,COUNT(DISTINCT(areawise_temp.rep_id)) as rep_id FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." GROUP BY our_cust_id ORDER BY SUM(areawise_temp.quantity*ptr) DESC LIMIT 10");

                  


                    $html.="</tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Top Product Report</td></tr>";

                    $html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Customer Name</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Qty</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTR</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTS</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Rep</th></tr>";





// exit();
                    while($Customer=mysql_fetch_object($sqltp)){

// First Row - Start
/* $rep_sql=mysql_query("select id from representative");
$count=mysql_num_rows($rep_sql);*/


$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$Customer->CUSTOMER_NAME."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$Customer->qty."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$Customer->PTR."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$Customer->PTS."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$Customer->rep_id."</td></tr>";


}

$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>