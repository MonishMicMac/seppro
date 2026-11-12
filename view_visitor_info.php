<?php 
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];

if(!isset($_SESSION['id']))
{

  echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}else{

  $replist = mysql_query("SELECT * FROM mst_visitior_record where id='".$_REQUEST['visitor_id']."' ")or die(mysql_error());
  $replist_res = mysql_fetch_array($replist);

 $replist1 = mysql_query("SELECT * FROM tbl_visitor_interest where visitor_id='".$_REQUEST['visitor_id']."' ")or die(mysql_error());
  $replist_res1 = mysql_fetch_array($replist1);

  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Visitor Info</title>
    <style type="text/css">
    .tb1{
      text-align: center;
    }
  </style>
</head>
 <!-- <body onload="window.print()"> -->
 <body>

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
   </tr>
 </tr>
</table>

<table>
  <tr>
    <td>Client Contact Details</td>
    <td>Site Address</td>
    <td>Date:15/10/2018</td>
  </tr>
  <tr>
    <td><?php echo $replist_res['visitor_name']; ?></td>
    <td><?php echo $replist_res['site_address']; ?></td>
    <td><?php echo $replist_res['visitior_mobile']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td> Referred By:</td>
    <td><?php echo $replist_res['iknewfrom']; ?></td>
  </tr>
</table>
<table style="border: 1px solid black;width: 100%;" class="tb1">
  <tr>
    <th style="border: 1px solid black;">S.No</th>
    <th style="border: 1px solid black;">Group</th>
    <th style="border: 1px solid black;">Category/Type</th>
    <th style="border: 1px solid black;">Brand</th>
    <th style="border: 1px solid black;">Time Frame</th>
  </tr>
  <?php 
  $sql_visitor_product=mysql_query("SELECT * FROM `tbl_visitor_interest` where visitor_id='".$_REQUEST['visitor_id']."' ");
  $jj=1;
  $fareamount1='';
  while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){
    ?>
    <tr>
      <td style="border: 1px solid black;"><?php echo $jj; ?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['group_name']; ?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['category'];?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['brand']; ?></td>
      <td style="border: 1px solid black;"><?php echo $row_visitor_product['timeframe']; ?></td>
    </tr>
    <?php  $jj++; } ?>
  </table>

  <table>
    <tr>
      <td>Remarks:</td>
      <td><?php echo $replist_res['suggestion']; ?></td>
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