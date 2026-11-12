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
  <?php
  $log=mysql_query("select * from site_conf");
  $row_log=mysql_fetch_array($log);
  $logo_name=$row_log['logo'];
  ?>  

  <table style="width: 100%;">
    <tr>
      <td>
        <table style="width: 70%;">
          <tr>
             <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/CarysilLogo-001.jpg" width="100%" height="30%" /> <span></span></a></td>
            
             <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/Siemens-001.jpg" width="100%" height="30%" /> <span></span></a></td>
          </tr>
          <tr>
            <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/SleekLogo-001.jpg" width="100%" height="30%" /> <span></span></a></td>
           <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/Faber-001.jpg" width="100%" height="30%" /> <span></span></a></td>
        </tr>
        <tr>
          
          <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/Bosch.png" width="100%" height="30%" /> <span></span></a></td>
          <!-- <td><a class="brand" href="#"><img alt="Micandmac" src="img/dynamic_img/Whirpool-001.jpg" width="100%" height="30%" /> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></a> </td> -->
        </tr>
        </table>
      </td>
      <td>
        <table style="width: 30%;">
            <tr>
              <td><a class="brand" href="#"><img alt="Micandmac" src="logo/<?php echo $logo_name; ?>" /> <span></span></a></td>
            </tr>
            <tr>
              <td>
          <label>Showroom & Sales Office</label>
        </td>
            </tr>
          <tr><td>
            <label>Ac:127 & 129,Shanthi Colony,Anna Nagar,</label></td></tr>
            <tr><td><label>(Opp Shree Mithai),Chennai-600040</label></td>
            </tr>
            <tr><td><label>Phone:2615242,26285447,26207432,26204779</label></td></tr>
            <tr><td><label><!-- Helpline:9940298002, -->Email:retail@dynamic.in</label></td></tr>

          <!-- <tr><td><label>TIN No:338510212211 Area Code:0:52</label></td></tr>
          <tr><td><label>CST No:630789/211293</label></td></tr> -->
          <tr>
            <td><label>Monday- Saturday:10:00 am-7:30pm</label></td>

          </tr>

        </table>

      </td>
    </tr>

  </table>
  <table style="width: 40%;">
   <!--   <tr><td><label>Sunday Holiday</label></td> -->
           <td style="border: 1px solid black;width: 30%;"><b>Quotation No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $replist_res['quotation_no']; ?> & Date:<?php echo date("d-m-Y",strtotime($replist_res['c_date'])); ?></td>
         </tr>
  </table>

  <table style="/*border: 1px solid black;*/width: 100%;" class="tb1" cellpadding="0" cellspacing="0">
    <tr>
      <th style="border: 1px solid black;">S.No</th>
      <th style="border: 1px solid black;">Product Image</th>
      <th style="border: 1px solid black;">Code</th>
      <th style="border: 1px solid black;">Description</th>
      <!-- <th style="border: 1px solid black;">Unit</th> -->
      <th style="border: 1px solid black;">Qty</th>
      <th style="border: 1px solid black;">Rate</th>
      <!-- <th style="border: 1px solid black;">Rate</th> -->
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
        <td style="border: 1px solid black;">
          <?php 
          if ($pro_id_res['product_image']!='') {
          ?>
        <img src="product_image/<?php echo $pro_id_res['product_image']; ?>" width="150px" height="88px">
      <?php } ?>
        </td>
        <td style="border: 1px solid black;"><?php echo $pro_id_res['pro_id']; ?></td>
        <td style="border: 1px solid black;"><?php echo strtoupper($pro_id_res['brand_name']).'-'.$pro_id_res['pro_name'];?></td><!-- 
        <td style="border: 1px solid black;"><?php echo $pro_id_res['packing']; ?></td> -->
        <td style="border: 1px solid black;"><?php echo $row_visitor_product['quantity']; ?></td> 
        <td style="border: 1px solid black;"><?php echo $row_visitor_product['offer_price']; ?></td>
       <!--  <td style="border: 1px solid black;"><?php echo $pro_id_res['pro_mrp']; ?></td> -->
        <td style="border: 1px solid black;"><?php echo $row_visitor_product['total']; ?></td>

      </tr>
      <?php $fareamount1=$fareamount1+$row_visitor_product['total']; ?>
      <?php  $jj++; } ?>
      <?php 
          $sql_visitor_info=mysql_query("SELECT * FROM `mst_visitior_record` where id='".$_REQUEST['quotation_id']."' ");
          $row_visitor_info=mysql_fetch_array($sql_visitor_info);
          $discount=$row_visitor_info['discount'];
      ?>
    </table>
    <br>
    <table style="/*border: 1px solid black;*/width: 100%;" cellpadding="0" cellspacing="0">
      <tr style="border: 1px solid black;width: 20%;" class="tb1">
        <td style="width:25%;border: 1px solid black;" rowspan="4">
        Customer's Name and Address<br>
        <?php echo $row_visitor_info['visitor_name'].'&'.$row_visitor_info['visitor_address'] ?>
      </td>
        <td style="word-wrap: break-word;width:25%;border: 1px solid black;width: 40%;height: 20%;" rowspan="4">
          Term's & Conditions:
          <!-- <ul style="text-align: left;"> -->
          	<p>As per applicable GST of  12% /18% /28%.-
          	Delivery Charges extra  ( any transit damage is not our responsibility).-
          	Cheque subject to realization-
          	All Visa, Master & Dinners cards Accepted * Conditions apply.-
          	Strictly Exchange within 2days only ( provided the material is in Saleable condition i.e. intact with Box )-
          	No Refund-
          	Our responsibility ceases once the materials are thoroughly checked and taken delivery from our Godown</p>
          </ul>
        </td>
        <td style="width:25%;border: 1px solid black;width: 20%;" >Sub Toatal</td>

        <td style="width:25%;border: 1px solid black;width: 20%;"><?php echo $fareamount1; ?></td>
      </tr>
      <tr class="tb1" >
        <td style="width:25%;height:25%;border: 1px solid black;">Discount</td>
        <td style="width:25%;height:25%;border: 1px solid black;" ><?php echo $discount; ?></td>
      </tr>
      <tr class="tb1">
        <td style="width:25%;height:25%;border: 1px solid black;"></td>
        <td style="width:25%;height:25%;border: 1px solid black;"></td>
      </tr>
      <tr class="tb1">
        <td style="width:25%;height:25%;border: 1px solid black;">Grand Total</td>
        <td style="width:25%;height:25%;border: 1px solid black;" ><?php echo $fareamount1-$discount; ?></td>
      </tr>
    </table>
<table style="border:1px solid black;width: 100%;">
      <tr>
       <!--  <td style="width:25%;height:70%;text-align: center;" rowspan="4" valign="top">Customer`s Signature</td>
        <td style="width:25%;height:70%;text-align: center;" rowspan="4" valign="top">Checked by</td> -->
        <td style="width:50%;text-align: left;border-right: 1px solid black;" rowspan="4" valign="top" colspan="5">Remarks</td>
        <td style="width:25%;text-align: center;" colspan="4">
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
          <td style="width:25%;height:50%;text-align: center;" colspan="4">Authorised Signatory</td>
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