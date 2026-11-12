<?php 
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];

if(!isset($_SESSION['id']))
{

  echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}else{

  $replist = mysql_query("SELECT * FROM mst_visitior_quotation where id='".$_REQUEST['quotation_id']."' ")or die(mysql_error());
  $replist_res = mysql_fetch_array($replist);
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Quotation</title>
    <style type="text/css">
    .tb1{
      text-align: center;
    }

  </style>
</head>
 <body onload="window.print()">
 <!-- <body> -->

  <table style="width: 100%;" >
    <tr style="width:50%;">
     <tr>
       <?php
       $log=mysql_query("select * from site_conf");
       $row_log=mysql_fetch_array($log);
       $logo_name=$row_log['logo'];
       ?>   
       <td><a class="brand" href="#"><img alt="Micandmac" src="logo/<?php echo $logo_name; ?>" /> <span></span></a></td>
     </tr>
     <tr>
       <td>
        <label>Showroom & Sales Office</label></td>
      </tr>
      <tr><td>
        <label>Ac:127 & 129,Shardhi Colony,Anna Nagar,</label></td>
        <tr><td><label>(Opp Shree Mitai),Chennai-600040</label></td></tr>
        <tr><td><label>Phone:2615242,26285447,26207432,26204779</label></td></tr>
        <tr><td><label>Helpline:9940298002,Email:sales@dynamic.in</label></td></tr>

      </td>
    </tr>
    <tr><td><label>TIN No:338510212211 Area Code:0:52</label></td></tr>
    <tr><td><label>CST No:630789/211293</label></li></td></tr>
    <tr>
      <td><label>Monday- Saturday:10:00 am-8:00pm</label></td>

    </tr>
    <tr><td><label>Sunday Holiday</label></li></td>
     <td style="border: 1px solid black;"><b>Quotation No</b></td>
     <td><?php echo $replist_res['quotation_no']; ?></td> 
     <td>&nbsp;&nbsp;&nbsp;&nbsp; Date:<?php echo $replist_res['c_date']; ?></td>
   </tr>
 </tr>
</table>

<table style="border: 1px solid black;width: 100%;" class="tb1">
  <tr>
    <th style="border: 1px solid black;">S.No</th>
    <th style="border: 1px solid black;">Code</th>
    <th style="border: 1px solid black;">Product</th>
    <th style="border: 1px solid black;">Qty</th>
    <th style="border: 1px solid black;">Rate</th>
    <th style="border: 1px solid black;">Amount</th>
  </tr>
  <?php 
  $sql_visitor_product=mysql_query("SELECT * FROM `tbl_visitor_quotation_price` where quotation_id='".$_REQUEST['quotation_id']."' ");
  $jj=1;
  $fareamount1='';
  while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){

    $pro_id = mysql_query("SELECT * FROM product WHERE id='".$row_visitor_product['product_id']."'")or die(mysql_error());
    $pro_id_res = mysql_fetch_array($pro_id);

    ?>
    <tr>
      <td style="border: 1px solid black;"><?php echo $jj; ?></td>
      <td style="border: 1px solid black;"><?php echo $pro_id_res['pro_id']; ?></td>
      <td style="border: 1px solid black;"><?php echo $pro_id_res['pro_name'];?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['quantity']; ?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['rate']; ?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['total']; ?></td>

    </tr>
    <?php $fareamount1=$fareamount1+$row_visitor_product['total']; ?>
    <?php  $jj++; } ?>
    
  </table>
  <table style="border: 1px solid black;width: 100%;" >
    <tr style="border: 1px solid black;" class="tb1">
      <td style="width:25%;border: 1px solid black;" rowspan="4">Customer's Name and Address</td>
      <td style="word-wrap: break-word;width:25%;border: 1px solid black;" rowspan="4">
        Term's & Conditions:
        14.5% VAT include Delivery charges extra,Cheque subject to reailsatio. All Visa Master,Diners Cards accepted Conditions apply.
        Exchange within 2 ays only.
        No REFUND
      </td>
      <td style="width:25%;border: 1px solid black;" >Sub Toatal</td>

      <td style="width:25%;border: 1px solid black;" ><?php echo $fareamount1; ?></td>
    </tr>
    <tr class="tb1">
      <td style="width:25%;height:25%;border: 1px solid black;"></td>
      <td style="width:25%;height:25%;border: 1px solid black;"></td>
    </tr>
    <tr class="tb1">
      <td style="width:25%;height:25%;border: 1px solid black;"></td>
      <td style="width:25%;height:25%;border: 1px solid black;"></td>
    </tr>
    <tr class="tb1">
      <td style="width:25%;height:25%;border: 1px solid black;">Grand Total</td>
      <td style="width:25%;height:25%;border: 1px solid black;"></td>
    </tr>

    <tr style="border: 1px solid black;">
      <td style="width:25%;border: 1px solid black;height:70%;text-align: center;" rowspan="4" valign="top">Customer`s Signature</td>
      <td style="width:25%;border: 1px solid black;text-align: center;" rowspan="4" valign="top">Checked by</td>
      <td style="width:25%;text-align: center;" colspan="2">
        For Dynamic Marketing<br><br><br></td>

      </tr>
      <tr>
        <td style="width:25%;height:25%;"></td>
        <td style="width:25%;height:25%;"></td>
      </tr>
      <tr>
        <td style="width:25%;height:50%;"></td>
        <td style="width:25%;height:50%;"></td>
      </tr>

      <tr>
        <td style="width:25%;height:50%;text-align: center;" colspan="2">Authorised Signatory</td>
      </tr>

    </table>
  </body>
  </html>

  <?php } ?>

  <?php 
   /* include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;*/
  ?>