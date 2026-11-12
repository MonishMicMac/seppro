<?php
error_reporting(0);
include("include/connect.php");
if(@$_REQUEST["from_date"]!=""){
    $bill_default = "and a.bill_string='".$_REQUEST["from_date"]."'";
    $bill_url = "&from_date=".$_REQUEST["from_date"];

    echo ":";

} else {
    $SQL = mysql_query("SELECT bill_string FROM `primary_sales` order by str_to_date(concat(\"01\",LEFT(SUBSTRING_INDEX( SUBSTRING_INDEX( bill_string,  ' ', 1 ) ,  ' ', -1 ),3),TRIM( SUBSTR(  bill_string, LOCATE(  ' ',  bill_string ) ) )),\"%d%b%Y\") desc limit 1");
    while ($customer21=mysql_fetch_array($SQL)) {
        $bill_default1=$customer21["bill_string"];
        $bill_default="and a.bill_string='".$customer21["bill_string"]."'";
        $bill_url="&from_date=".$customer21["bill_string"];
    }

    echo " for ".$bill_default1." :";
}

if(@$_REQUEST["division_id"]!=""){
    $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
} else {
    if($_SESSION["division_id"]!="ALL")
        $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
    else 
        $division_default = "";
}


                            // if($_SESSION["state_id"]!="ALL") {
                            //     $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                            // } else {
                            //     $state_check = " ";
                            // }
if(@$_REQUEST["st_id"]) {
    $state_check = "and b.state_id='".(@$_REQUEST["st_id"])."'";
    $state_url = "&state_id=".(@$_REQUEST["st_id"]);
} else {

    if($_SESSION["state_id"]!="ALL") {
        $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
    } else {
        $state_check = "";
    }

    $state_url = "";
}



if(@$_REQUEST["product_id"]!=""){
    $pdt_default = "and c.our_id='".@$_REQUEST["product_id"]."'";
    $pdt_url="&product_id=".$_REQUEST["product_id"];
} else {
    $pdt_default = "and c.our_id!=''";
    $pdt_group= "GROUP BY d.id"; 
    $pdt_url="";
}

if(isset($_REQUEST['division_id']))
{

  	// echo "SELECT b.state_id,d.pro_name from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id WHERE and c.our_id='".$_REQUEST['proid']."' GROUP BY b.state_id ";
    ?> <option value="">---Select---</option> <?php
    $P=mysql_query("SELECT id,pro_name from  product  a  WHERE 1 ".$division_default.""); while($I=mysql_fetch_object($P)){ ?>
    <option value="<?=$I->id; ?>"><?=$I->pro_name; ?></option>
    <?php 
} 
}









