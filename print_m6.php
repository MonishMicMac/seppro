<?php
include("include/connect.php");

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);

$m_id16=$_REQUEST['m_id16'];
$rep_id=$_REQUEST['u_id16'];
$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];


?>
<!DOCTYPE html>
<html lang="en">

<head><title>Areawise Report</title></head>

<body onLoad="window.print();">
                    <table>
                    <tr><td>Result For :</td><td>OverAll-Productwise Report</td></tr>
                    <?php 
					$rs=mysql_query("select * from representative where rep_id='$rep_id'");
					$row_rs=mysql_fetch_array($rs);
					?>
                     <tr><td></td><td>Manager Name :</td><td><?php echo $row_rs['rep_name']; ?></td></tr>
                     <?php
					  $re=mysql_query("select * from representative where rep_under='$rep_id'");
					 $count_re=mysql_num_rows($re);
					 if($count_re>0)
					 {
					 ?>
                     <tr><td></td><td>Representative Name :</td><td></td></tr>
                     <?php
					 while($row_re=mysql_fetch_array($re))
					  {
					  $re_id=$row_re['rep_id'];
					  $rs1=mysql_query("select * from representative where rep_id='$re_id'");
					$row_rs1=mysql_fetch_array($rs1);
					  ?>
                     <tr><td></td><td></td><td><?php echo $row_rs1['rep_name']; ?></td></tr>
                     <?php
					 }
					 }
					 ?>
                     <tr><td></td><td>From Date :</td><td><?php echo $from_date; ?></td></tr>
                     <tr><td></td><td>To Date :</td><td><?php echo $to_date; ?></td></tr>
                    </table>
                         
                  
<table border="1" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<th>Product Name</th>
<th>Pincode</th>
<th>Area Name</th>
<th>Distributor Name</th>
<th>Pharmacy Name</th>
<th>Bill Date</th>
<th>Bill No</th>
<th>Quantity</th>
<th>Sale Value</th>
<th>Net Amount</th>
<th>Rpl Qnty</th>
<th>Free Qnty</th>
</tr>
<?php
$x=mysql_query("select * from rep_area where rep_id='$rep_id'");
$count_x=mysql_num_rows($x);
if($count_x>0)
{
while($row_x=mysql_fetch_array($x))
{
$area_id=$row_x['area_id'];
$y=mysql_query("select * from pincode_list where id='$area_id'");
$row_y=mysql_fetch_array($y);
$pin=$row_y['pincode'];
?>
<?php
$a=mysql_query("select DISTINCT pro_id from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and  pincode='$pin' order by pro_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
$pro_id=$row_a['pro_id'];
$b=mysql_query("select * from dist_prod where pro_id='$pro_id'");
$row_b=mysql_fetch_array($b);
$our_id=$row_b['our_id'];
if($our_id=='')
{
$d=mysql_query("select * from areawise_temp where pro_id='$pro_id'  and  m_id16='$m_id16'");
$row_d=mysql_fetch_array($d);
$product_name=$row_d['pro_name'];
}
else
{
$c=mysql_query("select * from product where id='$our_id'");
$row_c=mysql_fetch_array($c);
$product_name=$row_c['pro_name'];
}

$b65=mysql_query("select * from  representative where rep_id='$rep_id'");
$row_b65=mysql_fetch_array($b65);
?>
<tr>
<td><?php echo $row_b65['rep_name']; ?>(Manager)</td>
<td <?php if($our_id=='') { ?> style="color:#FF0000;" <?php } ?>><?php echo $product_name; ?></td>
<td colspan="11"></td>
</tr>
<?php
$e=mysql_query("select DISTINCT pincode from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id' and pincode='$pin' order by area_name asc");
$count_e=mysql_num_rows($e);
if($count_e>0)
{
$tot_pincode=0;
while($row_e=mysql_fetch_array($e))
{
$pincode=$row_e['pincode'];

$f=mysql_query("select * from  pincode_list where pincode='$pincode'");
$count_f=mysql_num_rows($f);
if($count_f>0)
{
$row_f=mysql_fetch_array($f);
$area_name=$row_f['area_name'];
}
else
{
$g=mysql_query("select * from areawise_temp where pincode='$pincode'  and  m_id16='$m_id16'");
$row_g=mysql_fetch_array($g);
$area_name=$row_g['area_name'];
}
?>
<tr>
<td colspan="2"></td>
<td><?php echo $pincode; ?></td>
<td <?php if($count_f=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $area_name; ?></td>
<td colspan="9"></td>
</tr>
<?php
$h=mysql_query("select * from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id' and pincode='$pincode' order by cust_name asc");
$count_h=mysql_num_rows($h);
if($count_h>0)
{
$tot_pharma=0;
while($row_h=mysql_fetch_array($h))
{
$cust_id=$row_h['cust_id'];
$dist_id=$row_h['dist_id'];
$net_amount=$row_h['net_amount'];
$a3=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id'");
$row_a3=mysql_fetch_array($a3);
$dis_name=$row_a3['dis_name'];
$a6=mysql_query("select * from  customer  where  dc_id='$cust_id'");
$count_a6=mysql_num_rows($a6);
if($count_a6=='0')
{
$a7=mysql_query("select cust_name  from  areawise_temp  where  cust_id='$cust_id'  and  m_id16='$m_id16'");
$row_a7=mysql_fetch_array($a7);
$customer_name=$row_a7['cust_name'];
}
else
{
$row_a6=mysql_fetch_array($a6);
$customer_name=$row_a6['cust_name'];
}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td><?php echo $dis_name; ?></td>
<td <?php if($count_a6=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $customer_name; ?></td>
<td><?php echo $row_h['bill_no']; ?></td>
<td><?php echo $row_h['bill_date']; ?></td>
<td><?php echo $row_h['quantity']; ?></td>
<td><?php echo $row_h['sale_value']; ?></td>
<td><?php echo $row_h['net_amount']; ?></td>
<td><?php echo $row_h['replace_quantity']; ?></td>
<td><?php echo $row_h['free_quantity']; ?></td>
</tr>
<?php
}
$tot_pharma=$net_amount+$tot_pharma;
}
?>
<tr><td colspan="2"></td><td colspan="11">
<span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total / Area (<?php echo $area_name; ?>) : <?php echo $tot_pharma;  ?></span>
</td></tr>
<?php
$tot_pincode=$tot_pharma+$tot_pincode;
}
?>
<tr><td colspan="13">
<span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total / Product (<?php echo $product_name; ?>) : <?php echo $tot_pincode;  ?></span>
</td></tr>
<?php
}
?>
<?php
}
}
?>
<?php
}
}
?>
<?php
$tt=mysql_query("select * from representative where rep_under='$rep_id'");
while($row_tt=mysql_fetch_array($tt))
{
$rep_id12=$row_tt['rep_id'];
?>








<?php
$x12=mysql_query("select * from rep_area where rep_id='$rep_id12'");
$count_x12=mysql_num_rows($x12);
if($count_x12>0)
{
while($row_x12=mysql_fetch_array($x12))
{
$area_id12=$row_x12['area_id'];
$y12=mysql_query("select * from pincode_list where id='$area_id12'");
$row_y12=mysql_fetch_array($y12);
$pin12=$row_y12['pincode'];
?>
<?php
$a12=mysql_query("select DISTINCT pro_id from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and  pincode='$pin12' order by pro_name asc");
$count_a12=mysql_num_rows($a12);
if($count_a12>0)
{
while($row_a12=mysql_fetch_array($a12))
{
$pro_id12=$row_a12['pro_id'];
$b12=mysql_query("select * from dist_prod where pro_id='$pro_id12'");
$row_b12=mysql_fetch_array($b12);
$our_id12=$row_b12['our_id'];
if($our_id12=='')
{
$d12=mysql_query("select * from areawise_temp where pro_id='$pro_id12'  and  m_id16='$m_id16'");
$row_d12=mysql_fetch_array($d12);
$product_name12=$row_d12['pro_name'];
}
else
{
$c12=mysql_query("select * from product where id='$our_id12'");
$row_c12=mysql_fetch_array($c12);
$product_name12=$row_c12['pro_name'];
}
$b6512=mysql_query("select * from  representative where rep_id='$rep_id12'");
$row_b6512=mysql_fetch_array($b6512);
?>
<tr>
<td><?php echo $row_b6512['rep_name']; ?>(Executive)</td>
<td <?php if($our_id12=='') { ?> style="color:#FF0000;" <?php } ?>><?php echo $product_name12; ?></td>
<td colspan="11"></td>
</tr>
<?php
$e12=mysql_query("select DISTINCT pincode from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id12' and pincode='$pin12' order by area_name asc");
$count_e12=mysql_num_rows($e12);
if($count_e12>0)
{
$tot_pincode12=0;
while($row_e12=mysql_fetch_array($e12))
{
$pincode12=$row_e12['pincode'];

$f12=mysql_query("select * from  pincode_list where pincode='$pincode12'");
$count_f12=mysql_num_rows($f12);
if($count_f12>0)
{
$row_f12=mysql_fetch_array($f12);
$area_name12=$row_f12['area_name'];
}
else
{
$g12=mysql_query("select * from areawise_temp where pincode='$pincode12'  and  m_id16='$m_id16'");
$row_g12=mysql_fetch_array($g12);
$area_name12=$row_g12['area_name'];
}
?>
<tr>
<td colspan="2"></td>
<td><?php echo $pincode12; ?></td>
<td <?php if($count_f12=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $area_name12; ?></td>
<td colspan="9"></td>
</tr>
<?php
$h12=mysql_query("select * from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id12' and pincode='$pincode12' order by cust_name asc");
$count_h12=mysql_num_rows($h12);
if($count_h12>0)
{
$tot_pharma12=0;
while($row_h12=mysql_fetch_array($h12))
{
$cust_id12=$row_h12['cust_id'];
$dist_id12=$row_h12['dist_id'];
$net_amount12=$row_h12['net_amount'];
$a312=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id12'");
$row_a312=mysql_fetch_array($a312);
$dis_name12=$row_a312['dis_name'];
$a612=mysql_query("select * from  customer  where  dc_id='$cust_id12'");
$count_a612=mysql_num_rows($a612);
if($count_a612=='0')
{
$a712=mysql_query("select cust_name  from  areawise_temp  where  cust_id='$cust_id12'  and  m_id16='$m_id16'");
$row_a712=mysql_fetch_array($a712);
$customer_name12=$row_a712['cust_name'];
}
else
{
$row_a612=mysql_fetch_array($a612);
$customer_name12=$row_a612['cust_name'];
}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td><?php echo $dis_name12; ?></td>
<td <?php if($count_a612=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $customer_name12; ?></td>
<td><?php echo $row_h12['bill_no']; ?></td>
<td><?php echo $row_h12['bill_date']; ?></td>
<td><?php echo $row_h12['quantity']; ?></td>
<td><?php echo $row_h12['sale_value']; ?></td>
<td><?php echo $row_h12['net_amount']; ?></td>
<td><?php echo $row_h12['replace_quantity']; ?></td>
<td><?php echo $row_h12['free_quantity']; ?></td>
</tr>
<?php
}
$tot_pharma12=$net_amount12+$tot_pharma12;
}
?>
<tr><td colspan="2"></td><td colspan="11">
<span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total / Area (<?php echo $area_name12; ?>) : <?php echo $tot_pharma12;  ?></span>
</td></tr>
<?php
$tot_pincode12=$tot_pharma12+$tot_pincode12;
}
?>
<tr><td colspan="13">
<span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total / Product (<?php echo $product_name12; ?>) : <?php echo $tot_pincode12;  ?></span>
</td></tr>
<?php
}
?>
<?php
}
}
?>
<?php
}
}
?>
<?php
}
?>
</tbody>
</table>    
 
</body>
</html>

