<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
date_default_timezone_set('Asia/Calcutta'); 


$visitor_name = $_REQUEST['visitor_name'];

$res = mysql_query("select * from mst_visitior_quotation WHERE 1 order by id desc limit 1 ");
$row = mysql_fetch_array($res);
if(mysql_num_rows($res) == 1)
{
$rand = $row['quotation_no']+1;
if ($rand == 9999)
{
	$allocate = "1001";
}else{
	$allocate = $row['quotation_no']+1;
}

}
else {
$allocate = "1001";
}

$date=date('Y-m-d');
$time=date('h:i:s');


mysql_query("INSERT INTO `mst_visitior_quotation`(`quotation_no`, `visitor_id`, `c_date`) VALUES('".$allocate."','".$visitor_name."','".$date."')");

 $LastId = mysql_insert_id();
    

for ($j=0; $j <count($_REQUEST['outer-list1']) ; $j++) {  
	$quotation_id=$LastId;


   	$product=$_REQUEST['outer-list1'][$j]['product'];
   	$quantity=$_REQUEST['outer-list1'][$j]['quantity']; 

   	$pro_id = mysql_query("SELECT * FROM product WHERE id='".$product."'")or die(mysql_error());
    $pro_id_res = mysql_fetch_array($pro_id);

    $pro_mrp=$pro_id_res['pro_mrp'];
    $offer_price=$pro_id_res['offer_price'];
	  $total=$offer_price*$quantity;	


	mysql_query("INSERT INTO `tbl_visitor_quotation_price`(`quotation_id`, `product_id`, `quantity`, `rate`, `total`,offer_price) VALUES ('".$quotation_id."','".$product."','".$quantity."','".$pro_mrp."','".$total."','".$offer_price."')");

 }

   //echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='add_quotation.php';</script>";

 /*echo "<script type=\"text/javascript\">
        window.open('view_quotation.php?quotation_id=".$quotation_id."', '_blank')
    </script>";*/
 
/*echo "<script type='text/javascript' language='Javascript'>window.open('view_quotation.php?quotation_id=".$quotation_id."');</script>";
header("location: add_quotation.php");
exit();*/
echo "<script type=\"text/javascript\">
        window.open('view_quotation_3.php?quotation_id=".$quotation_id."')
        </script>";
 echo "<script type=\"text/javascript\">window.location='add_quotation.php';</script>";


}




        
 
?>