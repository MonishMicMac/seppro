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
  $freight_charges=$replist_res['freight_charges'];


  $sql_visitor_info=mysql_query("SELECT * FROM `mst_visitior_record` where id='".$replist_res['visitor_id']."' ");
  $row_visitor_info=mysql_fetch_array($sql_visitor_info);
  /*$discount=$row_visitor_info['discount'];*/

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
          <table style="width: 80%;">
            <br>
            <br>
            <br>
            <tr>
              <td>Mr/Mrs.<?php echo  $row_visitor_info['visitor_name']; ?></td>
            </tr>
            <tr>
              <td><?php echo $row_visitor_info['visitor_address']; ?> </td>
            </tr>

            <tr>
              <td><?php echo $row_visitor_info['visitior_mobile']; ?> </td>
            </tr>
            <tr>
              <td><?php echo $row_visitor_info['site_landmark']; ?> </td>
            </tr>
            <tr>
              <td><?php echo $row_visitor_info['gstno']; ?> </td>
            </tr>

          </table>
        </td>
        <td>
          <table style="width: 30%;float: right;">
            <tr style="width:75%;float:right;">
              <td><a class="brand" href="#"><img alt="Micandmac" src="logo/<?php echo $logo_name; ?>" align="right"/> <span></span></a></td>
            </tr>
            <tr>
              <td style="text-align: right;">
                <label>Showroom & Sales Office</label>
              </td>
            </tr>
            <tr><td style="text-align: right;">
              <label>AC:127 & 129,Shanthi Colony,Anna Nagar,</label></td></tr>
              <tr><td style="text-align: right;"><label>(Opp Shree Mithai).Chennai-600040</label></td>
              </tr>
              <tr><td style="text-align: right;"><label>Phone:26285447/26207432/9841317111</label></td></tr>
              <tr><td style="text-align: right;"><label>Helpline:9841218111(Office Hours)</label></td></tr>
              <tr><td style="text-align: right;"><label>Email:retail@dynamic.in/sales@dynamic.in</label></td></tr>
              <tr><td style="text-align: right;"><label>GSTIN:33-AAAPN3744N-1ZL</label></td></tr>
              <!-- <tr><td><label>CST No:630789/211293</label></td></tr> -->
              <tr>
                <td style="text-align: right;"><label>Monday- Saturday:10:00 am-7:30pm</label></td>
              </tr>

            </table>

          </td>
        </tr>

      </table>
      <table style="width: 100%;">
        <tr>
         <!-- <tr><td><label>Sunday Holiday</label></td> -->
           <td style="border: 1px solid black;width: 20%;"><b>Quotation No:</b><?php echo $replist_res['quotation_no']; ?></td>       
           <td style="float: left;border: 1px solid black;">Date:<?php echo date("d-m-Y",strtotime($replist_res['c_date'])); ?></td>
         </tr>
       </table>
       <br>
       <table style="/*border: 1px solid black;*/width: 100%;" class="tb1" cellpadding="0" cellspacing="0">
        <tr>
          <th style="border: 1px solid black;">S.No</th>
          <th style="border: 1px solid black;">Product Image</th>
          <th style="border: 1px solid black;">Code</th>
          <th style="border: 1px solid black;">Description</th>
          <!-- <th style="border: 1px solid black;">Unit</th> -->
          <th style="border: 1px solid black;">Rate</th>
          <th style="border: 1px solid black;">Qty</th>
          <th style="border: 1px solid black;">Amount</th>
          <th style="border: 1px solid black;">Discount</th>
        </tr>
        <?php 
        $sql_visitor_product=mysql_query("SELECT * FROM `tbl_visitor_quotation_price` where quotation_id='".$_REQUEST['quotation_id']."' ");
        $jj=1;
        $fareamount1='';
        while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){
         $dis_type=$row_visitor_product['discount_type'];
         $dis_value=$row_visitor_product['discount_value'];
         $discount1=$row_visitor_product['discount'];

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
        <td style="border: 1px solid black;"><?php echo strtoupper($pro_id_res['brand_name']).'-'.ucwords(strtolower($pro_id_res['pro_name'])); ?></td><!-- 
        <td style="border: 1px solid black;"><?php echo $pro_id_res['packing']; ?></td> -->
        
        <td style="border: 1px solid black;"><?php echo $row_visitor_product['offer_price']; ?></td>
        <td style="border: 1px solid black;"><?php echo $row_visitor_product['quantity']; ?></td>        

        <td style="border: 1px solid black;"><?php echo $row_visitor_product['total']; ?></td>
        <td style="border: 1px solid black;"><?php
        if($dis_type=='Value'){
         $discount=$row_visitor_product['discount'];
         echo $discount;
       }
       elseif($dis_type=='Percentage'){         
        $discount1 = ( $fareamount1 / 100 )* $dis_value;
        echo $discount1;
      }
      elseif($dis_type=='0' OR $dis_type==''){
        echo  $discount2='';
      }
      ?></td> 

    </tr>
    <?php 
    $fareamount1=$fareamount1+$row_visitor_product['total'];
    $faredisamount1=$faredisamount1+$row_visitor_product['discount']; 
    $faredisamount2=$faredisamount1+$discount1; 

    ?>
    <?php  $jj++; } ?>


    <tr style="border: 1px solid black;width: 20%;" class="tb1">
       <!--  <td style="width:25%;border: 1px solid black;" rowspan="4">
        Customer's Name and Address<br>
        <?php echo $row_visitor_info['visitor_name'].'&'.$row_visitor_info['visitor_address'] ?>
      </td> -->
      <td style="word-wrap: break-word;border: 1px solid black;width: 40%;height: 20%;" rowspan="4" colspan="5">
        <p style="font-size: 18px;text-align: left;margin-top: 0px;">Terms & Conditions:</p>
        <!-- <ul style="text-align: left;"> -->
         <p style="font-size: 10px;">As per applicable GST at  12% /18% /28%.
           Included Delivery Charges extra  ( any transit damage is not our responsibility).
           Cheque subject to realization.
           All Visa, Master & Diners cards Accepted * Conditions apply.
           Strictly Exchange within 2days only ( provided the material is in Saleable condition i.e. intact with Box )
           No Refund.
         Our responsibility ceases once the materials are thoroughly checked and taken delivery from our Godown.Disputes subject to Chennai Jurisdiction.Cheques favoring Dynamic Marketing is (subject to realization).Installation by respective brand customer care only on chargeable basis.E.&O.E.</p>
         <!-- </ul> -->
       </td>
       <td style="width:10%;border: 1px solid black;width: 20%;" >Sub Total</td>

       <td style="width:10%;border: 1px solid black;width: 20%;" colspan="2"><?php echo $fareamount1; ?></td>
     </tr>
     <?php 


     ?>
     <tr class="tb1" >
      <td style="width:10%;height:25%;border: 1px solid black;" >(-)Discount</td>
      <td style="width:10%;height:25%;border: 1px solid black;" colspan="2">
        <?php
      echo $faredisamount2;
      ?>

    </td>
  </tr>
  <tr class="tb1">
    <td style="height:30%;border: 1px solid black;word-break: break-all;"> (+)Freight / Insurance/&nbsp;&nbsp;&nbsp;&nbsp; Packing etc</td>
    <td style="width:10%;height:25%;border: 1px solid black;" colspan="2"><?php echo $freight_charges ?></td>
  </tr>
  <tr class="tb1">
    <td style="width:10%;height:25%;border: 1px solid black;">Grand Total</td>
    <td style="width:10%;height:25%;border: 1px solid black;" colspan="2">

      <?php 
      /*if($dis_type=='Value'){
        echo $fareamount1-$discount+$freight_charges;
      }
      elseif($dis_type=='Percentage'){
        echo $fareamount1-$discount2+$freight_charges;
      }
      elseif($dis_type=='0' OR $dis_type==''){
        echo $fareamount1+$freight_charges;
     }*/
     echo $fareamount1-$faredisamount2+$freight_charges;
     ?>

   </td>
 </tr>
<!-- </table>
  <table style="border:1px solid black;width: 100%;"> -->
    <tr>
       <!--  <td style="width:25%;height:70%;text-align: center;" rowspan="4" valign="top">Customer`s Signature</td>
        <td style="width:25%;height:70%;text-align: center;" rowspan="4" valign="top">Checked by</td> -->
        <td style="width:50%;text-align: left;border: 1px solid black;" rowspan="4" valign="top" colspan="5">Remarks</td>
        <td style="width:25%;text-align: center;border-right:1px solid black;" colspan="5">
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
          <td style="width:25%;height:50%;text-align: center;border-bottom:2px solid black;border-right: 1px solid black;" colspan="5">Authorised Signatory</td>
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