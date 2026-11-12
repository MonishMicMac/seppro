<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{

if(isset($_SESSION['wise']))
{
$wise=$_SESSION['wise'];
$manager=$_SESSION['manager'];
$from_date=$_SESSION['from_date'];
$to_date=$_SESSION['to_date'];
$from_string=strtotime($from_date);
$to_string=strtotime($to_date);
/*echo $from_date;
echo $from_string;
echo $to_date;

echo $to_string;*/
}
include("encrypt.php");
require_once("include/select.php");
$ad=new select1();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
</style>
	

</head>

<body onLoad="window.print();">
	
                   <?php
                   if($manager!='1')
                   {
                   ?>
					<table>
                    <?php
                    $b=mysql_query("select * from representative where rep_id='$manager'");
					$row_b=mysql_fetch_array($b);
                    ?>
                    <tr><td>Manager Name:</td><td><?php echo $row_b['rep_name']; ?></td></tr>
                    <tr><td>Executive Name:</td><td></td></tr>
                     <?php
					$a=mysql_query("select * from representative where rep_under='$manager'");
					$count_a=mysql_num_rows($a);
					if($count_a>0)
					{
					while($row_a=mysql_fetch_array($a))
					{
					?>
                     <tr><td></td><td><?php echo $row_a['rep_name']; ?></td></tr>
                    <?php
					}
					?>
                    <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                    <?php
					}
					else
					{
					?>
                     <tr><td></td><td>No One Under Him</td></tr>
                    <?php
					}
					
					?>
                   </table>
                   <?php
				   }
				   else
				   {
				   ?>
                   <table>
                   <tr><td>Manager List</td><td></td></tr>
                   <?php
				   $c=mysql_query("select * from representative where position='manager'");
				   $count_c=mysql_num_rows($c);
				   if($count_c>0)
				   {
				   while($row_c=mysql_fetch_array($c))
				   {
				   ?>
                   <tr><td></td><td><?php echo $row_c['rep_name']; ?></td></tr>
                   <?php
				   }
				   ?>
                   <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                   <?php
				   }
				   else
				   {
				   ?>
                   <tr><td></td><td>No Manager Yet</td></tr>
                   <?php
				   }
				   ?>
                   </table>
                   <?php
                   }
                   ?>
                   
      
                   
                   <?php
				   
                 if($manager=='1')
                   {
                   ?>   
                   
                   <table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
                   <tr>
                   <th style="width:200px;text-align:center;">Product Name</th>
                   <th style="width:60px;text-align:center;">Pincode</th>
                   <th style="width:90px;text-align:center;">Area Name</th>
                   <th style="width:130px;text-align:center;">Rep Name</th>
                   <th style="width:130px;text-align:center;">Position</th>
                   <th style="width:130px;text-align:center;">Distributor</th>
                   <th style="width:200px;text-align:center;">Customer Name</th>
                   <th style="width:70px;text-align:center;">Bill Date</th>
                   <th style="width:70px;text-align:center;">Bill No</th>
                   <th style="width:60px;text-align:center;">Qnty</th>
                   <th style="width:70px;text-align:center;">Sale Value</th>
                   <th style="width:70px;text-align:center;">Net Amount</th>
                   <th style="width:60px;text-align:center;">Replace Qnty</th>
                   <th style="width:76px;text-align:center;">Free Qnty</th>
                   </tr>
                   <?php
				   $d=mysql_query("select * from representative where position='manager'");
				   $count_d=mysql_num_rows($d);
				   if($count_d>0)
				   {
				   while($row_d=mysql_fetch_array($d))
				   {
				   $rep_id_d=$row_d['rep_id'];
				   //echo "select * from rep_area where rep_id='$rep_id_d'";
				   $e=mysql_query("select * from rep_area where rep_id='$rep_id_d'");
				   $count_e=mysql_num_rows($e);
				   if($count_e>0)
				   {
				   while($row_e=mysql_fetch_array($e))
				   {
				   $area_id_e=$row_e['area_id'];
				   $f=mysql_query("select * from pincode_list where id='$area_id_e'");
				    while($row_f=mysql_fetch_array($f))
				   {
				   $pincode_f=$row_f['pincode'];
				   //echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'";
				  // echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				  $tot2=0;
				   $g=mysql_query("select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $count_g=mysql_num_rows($g);
				   if($count_g>0)
				   {
				    
				   while($row_g=mysql_fetch_array($g))
				   {
				   $pro_id_g=$row_g['pro_id'];
				   $h=mysql_query("select  * from dist_prod where pro_id='$pro_id_g'");
				   $row_h=mysql_fetch_array($h);
				   $our_id_h=$row_h['our_id'];
				   
				   $i=mysql_query("select  * from product where id='$our_id_h'");
				   $row_i=mysql_fetch_array($i);
				   $pro_name_i=$row_i['pro_name'];
				   ?>
                   <tr>
                   <td><div style="text-align:center;"><?php echo $pro_name_i; ?></div></td>
                   <td colspan="13">
                   <?php
				   //echo "select DISTINCT cust_id from areawise_temp where pro_id='$pro_id_g'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $tot1=0;
				    $j=mysql_query("select DISTINCT pincode from areawise_temp where pro_id='$pro_id_g' and pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   while($row_j=mysql_fetch_array($j))
				   {
				   $pincode_j=$row_j['pincode'];
				   $k=mysql_query("select * from pincode_list where  pincode='$pincode_j'");
				   $row_k=mysql_fetch_array($k);
				   $id_k=$row_k['id'];
				   
				   
				   $n=mysql_query("select * from rep_area where area_id='$id_k'");
				   $row_n=mysql_fetch_array($n);
				   $rep_id_n=$row_n['rep_id'];
				   
				   //echo "select * from representative where rep_id='$rep_id_n'";
				    $o=mysql_query("select * from representative where rep_id='$rep_id_n'");
				   $row_o=mysql_fetch_array($o);
				   
				   ?>
                   
                   <table style="margin-left:-9px; margin-top:-7px;">
                   <tr>
                   <td><div style="width:60px;text-align:center;"><?php echo $row_j['pincode'];  ?></div></td>
                   <td><div style="width:90px;text-align:center;"><?php echo $row_k['area_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_o['rep_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_o['position'];  ?></td>
                   
                   <td>
                   <?php
				   //echo "select * from areawise_temp where pro_id='$pro_id_g' and cust_id='$cust_id_j'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $l=mysql_query("select * from areawise_temp where pro_id='$pro_id_g' and pincode='$pincode_j'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $tot=0;
				   while($row_l=mysql_fetch_array($l))
				   {
				  $cust_id_l=$row_l['cust_id'];
				  $m=mysql_query("select * from customer where dc_id='$cust_id_l'");
				  $row_m=mysql_fetch_array($m);
				  
				  $dist_id_l=$row_l['dist_id'];
				  $p=mysql_query("select * from distributor where dis_id='$dist_id_l'");
				  $row_p=mysql_fetch_array($p);
				  
				    ?>
                   <table style="margin-left:-9px; margin-top:-7px;"><tr>
                   <td><div style="width:130px;text-align:center;"><?php echo  $row_p['dis_name']; ?></div></td>
                   <td><div style="width:200px;text-align:center;"><?php echo  $row_m['cust_name']; ?></div></td>
                  <td><div style="width:70px;text-align:center;"><?php echo  $row_l['bill_no']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['bill_date']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['quantity']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['sale_value']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['net_amount']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['replace_quantity']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['free_quantity']; ?></div></td>
                   </tr></table>
                   <?php
				   $tot=$tot+$row_l['net_amount'];
				   }
				   ?>
                   </td>
                   </tr>
                
</table>
             <?php
			    $tot1=$tot1+$tot;
                   }
				   ?>
                   </td>
                   </tr>
                   <tr><td colspan="14"><span style="color:#0000FF; font-size:14px; font-weight:bold; float:right;">Net Amount Total/Product:<?php echo $tot1; ?></span></td></tr>
                   <?php
				     $tot2=$tot2+$tot1;
				   }
				 ?>
                 <tr><td colspan="14"><span style="color:#0000FF; font-size:16px; font-weight:bold; float:right;">Net Amount Total/Representative:<?php echo $tot2; ?></span></td></tr>
                 <?php
				   }
				   }
				   }
				   }
				   ?>
                   
				   
				     <tr><td colspan="14"><span style="font-weight:bold; font-size:18px; color:#0000FF;">Representative Under :
                      <?php 
					  $rr=mysql_query("select * from representative where rep_id='$rep_id_d'");
					 $row_rr=mysql_fetch_array($rr); ?>
					<?php  echo $row_rr['rep_name']; ?></span>
					 </td></tr>
				   
				   
				   <?php
				  
				   $da=mysql_query("select * from representative where rep_under='$rep_id_d'");
				   $count_da=mysql_num_rows($da);
				   if($count_da>0)
				   {
				  
				   while($row_da=mysql_fetch_array($da))
				   {
				   $rep_id_da=$row_da['rep_id'];
				   //echo "select * from rep_area where rep_id='$rep_id_d'";
				   $ea=mysql_query("select * from rep_area where rep_id='$rep_id_da'");
				   $count_ea=mysql_num_rows($ea);
				   if($count_ea>0)
				   {
				   while($row_ea=mysql_fetch_array($ea))
				   {
				   $area_id_ea=$row_ea['area_id'];
				   $fa=mysql_query("select * from pincode_list where id='$area_id_ea'");
				    while($row_fa=mysql_fetch_array($fa))
				   {
				   $pincode_fa=$row_fa['pincode'];
				   //echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'";
				  // echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				  $tot2a=0;
				   $ga=mysql_query("select  DISTINCT pro_id from areawise_temp where pincode='$pincode_fa'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $count_ga=mysql_num_rows($ga);
				   if($count_ga>0)
				   {
				    
				   while($row_ga=mysql_fetch_array($ga))
				   {
				   $pro_id_ga=$row_ga['pro_id'];
				   $ha=mysql_query("select  * from dist_prod where pro_id='$pro_id_ga'");
				   $row_ha=mysql_fetch_array($ha);
				   $our_id_ha=$row_ha['our_id'];
				   
				   $ia=mysql_query("select  * from product where id='$our_id_ha'");
				   $row_ia=mysql_fetch_array($ia);
				   $pro_name_ia=$row_ia['pro_name'];
				   ?>
                   <tr>
                   <td><div style="text-align:center;"><?php echo $pro_name_ia; ?></div></td>
                   <td colspan="13">
                   <?php
				   //echo "select DISTINCT cust_id from areawise_temp where pro_id='$pro_id_g'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $tot1a=0;
				    $ja=mysql_query("select DISTINCT pincode from areawise_temp where pro_id='$pro_id_ga' and pincode='$pincode_fa'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   while($row_ja=mysql_fetch_array($ja))
				   {
				   $pincode_ja=$row_ja['pincode'];
				   $ka=mysql_query("select * from pincode_list where  pincode='$pincode_ja'");
				   $row_ka=mysql_fetch_array($ka);
				   $id_ka=$row_ka['id'];
				   
				   
				   $na=mysql_query("select * from rep_area where area_id='$id_ka'");
				   $row_na=mysql_fetch_array($na);
				   $rep_id_na=$row_na['rep_id'];
				   
				   //echo "select * from representative where rep_id='$rep_id_n'";
				    $oa=mysql_query("select * from representative where rep_id='$rep_id_na'");
				   $row_oa=mysql_fetch_array($oa);
				   
				   ?>
                   
                   <table style="margin-left:-9px; margin-top:-7px;">
                   <tr>
                   <td><div style="width:60px;text-align:center;"><?php echo $row_ja['pincode'];  ?></div></td>
                   <td><div style="width:90px;text-align:center;"><?php echo $row_ka['area_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_oa['rep_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_oa['position'];  ?></td>

                   
                   <td>
                   <?php
				   //echo "select * from areawise_temp where pro_id='$pro_id_g' and cust_id='$cust_id_j'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $la=mysql_query("select * from areawise_temp where pro_id='$pro_id_ga' and pincode='$pincode_ja'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $tota=0;
				   while($row_la=mysql_fetch_array($la))
				   {
				  $cust_id_la=$row_la['cust_id'];
				  $ma=mysql_query("select * from customer where dc_id='$cust_id_la'");
				  $row_ma=mysql_fetch_array($ma);
				  
				  $dist_id_la=$row_la['dist_id'];
				  $pa=mysql_query("select * from distributor where dis_id='$dist_id_la'");
				  $row_pa=mysql_fetch_array($pa);
				  
				    ?>
                   <table style="margin-left:-9px; margin-top:-7px;"><tr>
                   <td><div style="width:130px;text-align:center;"><?php echo  $row_pa['dis_name']; ?></div></td>
                   <td><div style="width:200px;text-align:center;"><?php echo  $row_ma['cust_name']; ?></div></td>
                  <td><div style="width:70px;text-align:center;"><?php echo  $row_la['bill_no']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['bill_date']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['quantity']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['sale_value']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['net_amount']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['replace_quantity']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['free_quantity']; ?></div></td>
                   </tr></table>
                   <?php
				   $tota=$tota+$row_la['net_amount'];
				   }
				   ?>
                   </td>
                   </tr>
                
</table>
             <?php
			    $tot1a=$tot1a+$tota;
                   }
				   ?>
                   </td>
                   </tr>
                   <tr><td colspan="14"><span style="color:#0000FF; font-size:14px; font-weight:bold; float:right;">Net Amount Total/Product:<?php echo $tot1a; ?></span></td></tr>
                   <?php
				     $tot2a=$tot2a+$tot1a;
				   }
				 ?>
                 <tr><td colspan="14"><span style="color:#0000FF; font-size:16px; font-weight:bold; float:right;">Net Amount Total/Representative:<?php echo $tot2a; ?></span></td></tr>
                 <?php
				   }
				   }
				   }
				   }
				   }
				  
				   }
				   else
				   {
				   ?>
                   <tr><td colspan="14">No Representative Under him</td></tr>
                   <?php
				   }
				     }
				   
				   }
				   else
				   {
				   ?>
                   <tr><td colspan="14">No Manager Yet</td></tr>
                   <?php
				   }
				   ?>
                  </table>
                  
                  
                  
                  <?php
				  }
				  else
				  {
				  ?>
                  
                 <table class="table table-striped table-bordered bootstrap-datatable datatable">
                   <tr>
                   <th style="width:200px;text-align:center;">Product Name</th>
                   <th style="width:60px;text-align:center;">Pincode</th>
                   <th style="width:90px;text-align:center;">Area Name</th>
                   <th style="width:130px;text-align:center;">Rep Name</th>
                   <th style="width:130px;text-align:center;">Position</th>
                   <th style="width:130px;text-align:center;">Distributor</th>
                   <th style="width:200px;text-align:center;">Customer Name</th>
                   <th style="width:70px;text-align:center;">Bill Date</th>
                   <th style="width:70px;text-align:center;">Bill No</th>
                   <th style="width:60px;text-align:center;">Qnty</th>
                   <th style="width:70px;text-align:center;">Sale Value</th>
                   <th style="width:70px;text-align:center;">Net Amount</th>
                   <th style="width:60px;text-align:center;">Replace Qnty</th>
                   <th style="width:76px;text-align:center;">Free Qnty</th>
                   </tr>
                   <?php
				   $d=mysql_query("select * from representative where rep_id='$manager'");
				   $count_d=mysql_num_rows($d);
				   if($count_d>0)
				   {
				   while($row_d=mysql_fetch_array($d))
				   {
				   $rep_id_d=$row_d['rep_id'];
				   //echo "select * from rep_area where rep_id='$rep_id_d'";
				   $e=mysql_query("select * from rep_area where rep_id='$rep_id_d'");
				   $count_e=mysql_num_rows($e);
				   if($count_e>0)
				   {
				   while($row_e=mysql_fetch_array($e))
				   {
				   $area_id_e=$row_e['area_id'];
				   $f=mysql_query("select * from pincode_list where id='$area_id_e'");
				    while($row_f=mysql_fetch_array($f))
				   {
				   $pincode_f=$row_f['pincode'];
				   //echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'";
				  // echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				  $tot2=0;
				   $g=mysql_query("select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $count_g=mysql_num_rows($g);
				   if($count_g>0)
				   {
				    
				   while($row_g=mysql_fetch_array($g))
				   {
				   $pro_id_g=$row_g['pro_id'];
				   $h=mysql_query("select  * from dist_prod where pro_id='$pro_id_g'");
				   $row_h=mysql_fetch_array($h);
				   $our_id_h=$row_h['our_id'];
				   
				   $i=mysql_query("select  * from product where id='$our_id_h'");
				   $row_i=mysql_fetch_array($i);
				   $pro_name_i=$row_i['pro_name'];
				   ?>
                   <tr>
                   <td><div style="text-align:center;"><?php echo $pro_name_i; ?></div></td>
                   <td colspan="13">
                   <?php
				   //echo "select DISTINCT cust_id from areawise_temp where pro_id='$pro_id_g'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $tot1=0;
				    $j=mysql_query("select DISTINCT pincode from areawise_temp where pro_id='$pro_id_g' and pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   while($row_j=mysql_fetch_array($j))
				   {
				   $pincode_j=$row_j['pincode'];
				   $k=mysql_query("select * from pincode_list where  pincode='$pincode_j'");
				   $row_k=mysql_fetch_array($k);
				   $id_k=$row_k['id'];
				   
				   
				   $n=mysql_query("select * from rep_area where area_id='$id_k'");
				   $row_n=mysql_fetch_array($n);
				   $rep_id_n=$row_n['rep_id'];
				   
				   //echo "select * from representative where rep_id='$rep_id_n'";
				    $o=mysql_query("select * from representative where rep_id='$rep_id_n'");
				   $row_o=mysql_fetch_array($o);
				   
				   ?>
                   
                   <table style="margin-left:-9px; margin-top:-7px;">
                   <tr>
                   <td><div style="width:60px;text-align:center;"><?php echo $row_j['pincode'];  ?></div></td>
                   <td><div style="width:90px;text-align:center;"><?php echo $row_k['area_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_o['rep_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_o['position'];  ?></td>
                   
                   <td>
                   <?php
				   //echo "select * from areawise_temp where pro_id='$pro_id_g' and cust_id='$cust_id_j'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $l=mysql_query("select * from areawise_temp where pro_id='$pro_id_g' and pincode='$pincode_j'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $tot=0;
				   while($row_l=mysql_fetch_array($l))
				   {
				  $cust_id_l=$row_l['cust_id'];
				  $m=mysql_query("select * from customer where dc_id='$cust_id_l'");
				  $row_m=mysql_fetch_array($m);
				  
				  $dist_id_l=$row_l['dist_id'];
				  $p=mysql_query("select * from distributor where dis_id='$dist_id_l'");
				  $row_p=mysql_fetch_array($p);
				  
				    ?>
                   <table style="margin-left:-9px; margin-top:-7px;"><tr>
                   <td><div style="width:130px;text-align:center;"><?php echo  $row_p['dis_name']; ?></div></td>
                   <td><div style="width:200px;text-align:center;"><?php echo  $row_m['cust_name']; ?></div></td>
                  <td><div style="width:70px;text-align:center;"><?php echo  $row_l['bill_no']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['bill_date']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['quantity']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['sale_value']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_l['net_amount']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['replace_quantity']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_l['free_quantity']; ?></div></td>
                   </tr></table>
                   <?php
				   $tot=$tot+$row_l['net_amount'];
				   }
				   ?>
                   </td>
                   </tr>
                
</table>
             <?php
			    $tot1=$tot1+$tot;
                   }
				   ?>
                   </td>
                   </tr>
                   <tr><td colspan="14"><span style="color:#0000FF; font-size:14px; font-weight:bold; float:right;">Net Amount Total/Product:<?php echo $tot1; ?></span></td></tr>
                   <?php
				     $tot2=$tot2+$tot1;
				   }
				 ?>
                 <tr><td colspan="14"><span style="color:#0000FF; font-size:16px; font-weight:bold; float:right;">Net Amount Total/Representative:<?php echo $tot2; ?></span></td></tr>
                 <?php
				   }
				   }
				   }
				   }
				   ?>
                   
				   
				     <tr><td colspan="14"><span style="font-weight:bold; font-size:18px; color:#0000FF;">Representative Under :
                      <?php 
					  $rr=mysql_query("select * from representative where rep_id='$rep_id_d'");
					 $row_rr=mysql_fetch_array($rr); ?>
					<?php  echo $row_rr['rep_name']; ?></span>
					 </td></tr>
				   
				   
				   <?php
				  
				   $da=mysql_query("select * from representative where rep_under='$rep_id_d'");
				   $count_da=mysql_num_rows($da);
				   if($count_da>0)
				   {
				  
				   while($row_da=mysql_fetch_array($da))
				   {
				   $rep_id_da=$row_da['rep_id'];
				   //echo "select * from rep_area where rep_id='$rep_id_d'";
				   $ea=mysql_query("select * from rep_area where rep_id='$rep_id_da'");
				   $count_ea=mysql_num_rows($ea);
				   if($count_ea>0)
				   {
				   while($row_ea=mysql_fetch_array($ea))
				   {
				   $area_id_ea=$row_ea['area_id'];
				   $fa=mysql_query("select * from pincode_list where id='$area_id_ea'");
				    while($row_fa=mysql_fetch_array($fa))
				   {
				   $pincode_fa=$row_fa['pincode'];
				   //echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'";
				  // echo "select  DISTINCT pro_id from areawise_temp where pincode='$pincode_f'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				  $tot2a=0;
				   $ga=mysql_query("select  DISTINCT pro_id from areawise_temp where pincode='$pincode_fa'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $count_ga=mysql_num_rows($ga);
				   if($count_ga>0)
				   {
				    
				   while($row_ga=mysql_fetch_array($ga))
				   {
				   $pro_id_ga=$row_ga['pro_id'];
				   $ha=mysql_query("select  * from dist_prod where pro_id='$pro_id_ga'");
				   $row_ha=mysql_fetch_array($ha);
				   $our_id_ha=$row_ha['our_id'];
				   
				   $ia=mysql_query("select  * from product where id='$our_id_ha'");
				   $row_ia=mysql_fetch_array($ia);
				   $pro_name_ia=$row_ia['pro_name'];
				   ?>
                   <tr>
                   <td><div style="text-align:center;"><?php echo $pro_name_ia; ?></div></td>
                   <td colspan="13">
                   <?php
				   //echo "select DISTINCT cust_id from areawise_temp where pro_id='$pro_id_g'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $tot1a=0;
				    $ja=mysql_query("select DISTINCT pincode from areawise_temp where pro_id='$pro_id_ga' and pincode='$pincode_fa'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   while($row_ja=mysql_fetch_array($ja))
				   {
				   $pincode_ja=$row_ja['pincode'];
				   $ka=mysql_query("select * from pincode_list where  pincode='$pincode_ja'");
				   $row_ka=mysql_fetch_array($ka);
				   $id_ka=$row_ka['id'];
				   
				   
				   $na=mysql_query("select * from rep_area where area_id='$id_ka'");
				   $row_na=mysql_fetch_array($na);
				   $rep_id_na=$row_na['rep_id'];
				   
				   //echo "select * from representative where rep_id='$rep_id_n'";
				    $oa=mysql_query("select * from representative where rep_id='$rep_id_na'");
				   $row_oa=mysql_fetch_array($oa);
				   
				   ?>
                   
                   <table style="margin-left:-9px; margin-top:-7px;">
                   <tr>
                   <td><div style="width:60px;text-align:center;"><?php echo $row_ja['pincode'];  ?></div></td>
                   <td><div style="width:90px;text-align:center;"><?php echo $row_ka['area_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_oa['rep_name'];  ?></div></td>
                   <td><div style="width:130px;text-align:center;"><?php echo $row_oa['position'];  ?></td>
                   
                   <td>
                   <?php
				   //echo "select * from areawise_temp where pro_id='$pro_id_g' and cust_id='$cust_id_j'  and bill_string>='$from_string' AND bill_string<='$to_string'";
				   $la=mysql_query("select * from areawise_temp where pro_id='$pro_id_ga' and pincode='$pincode_ja'  and bill_string>='$from_string' AND bill_string<='$to_string'");
				   $tota=0;
				   while($row_la=mysql_fetch_array($la))
				   {
				  $cust_id_la=$row_la['cust_id'];
				  $ma=mysql_query("select * from customer where dc_id='$cust_id_la'");
				  $row_ma=mysql_fetch_array($ma);
				  
				  $dist_id_la=$row_la['dist_id'];
				  $pa=mysql_query("select * from distributor where dis_id='$dist_id_la'");
				  $row_pa=mysql_fetch_array($pa);
				  
				    ?>
                   <table style="margin-left:-9px; margin-top:-7px;"><tr>
                   <td><div style="width:130px;text-align:center;"><?php echo  $row_pa['dis_name']; ?></div></td>
                   <td><div style="width:200px;text-align:center;"><?php echo  $row_ma['cust_name']; ?></div></td>
                  <td><div style="width:70px;text-align:center;"><?php echo  $row_la['bill_no']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['bill_date']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['quantity']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['sale_value']; ?></div></td>
                   <td><div style="width:70px;text-align:center;"><?php echo  $row_la['net_amount']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['replace_quantity']; ?></div></td>
                   <td><div style="width:60px;text-align:center;"><?php echo  $row_la['free_quantity']; ?></div></td>
                   </tr></table>
                   <?php
				   $tota=$tota+$row_la['net_amount'];
				   }
				   ?>
                   </td>
                   </tr>
                
</table>
             <?php
			    $tot1a=$tot1a+$tota;
                   }
				   ?>
                   </td>
                   </tr>
                   <tr><td colspan="14"><span style="color:#0000FF; font-size:14px; font-weight:bold; float:right;">Net Amount Total/Product:<?php echo $tot1a; ?></span></td></tr>
                   <?php
				     $tot2a=$tot2a+$tot1a;
				   }
				 ?>
                 <tr><td colspan="14"><span style="color:#0000FF; font-size:16px; font-weight:bold; float:right;">Net Amount Total/Representative:<?php echo $tot2a; ?></span></td></tr>
                 <?php
				   }
				   }
				   }
				   }
				   }

				  
				   }
				   else
				   {
				   ?>
                   <tr><td colspan="14">No Representative Under him</td></tr>
                   <?php
				   }
				     }
				   
				   }
				   else
				   {
				   ?>
                   <tr><td colspan="14">No Manager Yet</td></tr>
                   <?php
				   }
				   ?>
                  </table>
                  
                  <?php
				  }
				  ?>
                  
                  
                
		
</body>
</html>
<?php
}
?>
