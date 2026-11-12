<?php
include("include/connect.php");

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);
$m_id16=$_REQUEST['m_id16'];
$rr_id=$_REQUEST['rr_id'];
$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Representative Report-My Performance</title></head>
<body onLoad="window.print();">

                    <table>
                    <tr><td>Result For :</td><td>Representative Report-My Performance</td></tr>
                    <?php 
					$rs=mysql_query("select * from representative where rep_id='$rr_id'");
					$row_rs=mysql_fetch_array($rs);
					?>
                    <tr><td></td><td>Representative Name :</td><td><?php echo $row_rs['rep_name']; ?></td></tr>
                     <tr><td></td><td>From Date :</td><td><?php echo $from_date; ?></td></tr>
                     <tr><td></td><td>To Date :</td><td><?php echo $to_date; ?></td></tr>
                    </table>
                      
<table border="1" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<th>Pin code</th>
<th>Area Name</th>
<th>Pharmacy Name</th>
<th>Distributor Name</th>
<th>Product Name</th>
<th>Bill Number</th>
<th>Bill Date</th>
<th>Quantity</th>
<th>Sale Value</th>
<th>Replacement Quantity</th>
<th>Free Quantity</th>
<th>Net Amount</th>
</tr>
<?php
$z=mysql_query("select * from  rep_area where rep_id='$rr_id'");
$count_z=mysql_num_rows($z);
if($count_z>0)
{
while($row_z=mysql_fetch_array($z))
{
$area_id=$row_z['area_id'];
$y=mysql_query("select * from  pincode_list where id='$area_id'");
$row_y=mysql_fetch_array($y);
$pincode=$row_y['pincode'];
?>

<?php
$a=mysql_query("select DISTINCT pincode from  areawise_temp  where  bill_date>='$from_date' AND bill_date<='$to_date' and  m_id16='$m_id16' and pincode='$pincode' order by area_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
$pincode_a=$row_a['pincode'];

$b=mysql_query("select * from  pincode_list where pincode='$pincode_a'");
$count_b=mysql_num_rows($b);
$row_b=mysql_fetch_array($b);
$b_id=$row_b['id'];
?>
<tr>
<td align="center"><?php echo $pincode_a; ?></td>
<?php
if($count_b=='0')
{
$b1=mysql_query("select * from  areawise_temp where pincode='$pincode_a'  and  m_id16='$m_id16'");
$row_b1=mysql_fetch_array($b1);
$aa1=$row_b1['area_name'];
?>
<td align="center" style="color:#FF0000;"><?php echo $row_b1['area_name']; ?></td>
<?php
}
else
{
$aa1=$row_b['area_name'];
?>
<td align="center"><?php echo $row_b['area_name']; ?></td>
<?php
}
?>


<td colspan="10"></td>
</tr>
<?php
$a1=mysql_query("select DISTINCT cust_id from  areawise_temp  where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a' order by cust_id asc");
$count_a1=mysql_num_rows($a1);
if($count_a1>0)
{
$tot_area=0;
while($row_a1=mysql_fetch_array($a1))
{
$cust_id=$row_a1['cust_id'];
$a6=mysql_query("select * from  customer  where  dc_id='$cust_id'");
$count_a6=mysql_num_rows($a6);
$a2=mysql_query("select cust_name,dist_id  from  areawise_temp  where  cust_id='$cust_id'  and  m_id16='$m_id16'");
$row_a2=mysql_fetch_array($a2);
$cust_name=$row_a2['cust_name'];
$dist_id=$row_a2['dist_id'];
$a3=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id'  and  m_id16='$m_id16'");
$row_a3=mysql_fetch_array($a3);
$dis_name=$row_a3['dis_name'];
?>
<tr>
<td colspan="2"></td>
<td  align="center"<?php if($count_a6=='0') {  ?> style="color:#FF0000;" <?php }?>><?php echo $cust_name; ?></td>
<td align="center"><?php echo ucwords($dis_name); ?></td>
<td colspan="8"></td>
</tr>
<?php
$a4=mysql_query("select * from  areawise_temp  where    bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a' and cust_id='$cust_id' order by pro_name asc");
$count_a4=mysql_num_rows($a4);
if($count_a4>0)
{
$tot_pharmacy=0;
while($row_a4=mysql_fetch_array($a4))
{
$pro_id=$row_a4['pro_id'];

$b=mysql_query("select * from dist_prod where pro_id='$pro_id'");
$row_b=mysql_fetch_array($b);
$our_id=$row_b['our_id'];
if($our_id=='')
{
$d=mysql_query("select * from areawise_temp where pro_id='$pro_id'  and  m_id16='$m_id16' and  dist_id='$dist_id'");
$row_d=mysql_fetch_array($d);
$product_name=$row_d['pro_name'];
}
else
{
$c=mysql_query("select * from product where id='$our_id'");
$row_c=mysql_fetch_array($c);
$product_name=$row_c['pro_name'];
}

$a5=mysql_query("select * from  areawise_temp  where  our_id!='' AND pro_id='$pro_id' and  m_id16='$m_id16'");
$count_a5=mysql_num_rows($a5);
$net_amount=$row_a4['net_amount'];
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td align="center" <?php if($our_id === '') {  ?> style="color:#FF0000;" <?php } ?>><?=ucwords($product_name); ?></td>
<td align="center"><?php echo  $row_a4['bill_no']; ?></td>
<td align="center"><?php echo $row_a4['bill_date']; ?></td>
<td align="center"><?php echo $row_a4['quantity']; ?></td>
<td align="center"><?php echo $row_a4['sale_value']; ?></td>
<td align="center"><?php echo $row_a4['replace_quantity']; ?></td>
<td align="center"><?php echo $row_a4['free_quantity']; ?></td>
<td align="center"><?php echo $row_a4['net_amount']; ?></td>
</tr>
<?php
$tot_pharmacy=$net_amount+$tot_pharmacy;
}
?>
<tr>
<td colspan="2"></td>
<td colspan="10"><span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total/Pharmacy (<?php echo $cust_name; ?>) : <?php echo $tot_pharmacy; ?></span></td>
</tr>
<?php
}
$tot_area=$tot_pharmacy+$tot_area;
}
?>
<tr>
<td colspan="12"><span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total/Area (<?php echo $aa1; ?>) : <?php echo $tot_area; ?></span></td>
</tr>
<?php
}
}
?> 
<?php
}
else
{}
?>   
<?php
}
}
?>
</tbody>
</table>  
</body>
</html>
