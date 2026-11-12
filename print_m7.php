<?php
	include("include/connect.php");

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);



$rr_id=$_REQUEST['rr_id'];
$dist_id14=$_REQUEST['dist_id'];
$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];
$m_id16=$_REQUEST['m_id16'];

include("encrypt.php");
require_once("include/select.php");
$ad=new select1();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Areawise Report</title>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
</head>
<body onLoad="window.print();">

                    <table>
                    <tr><td>Result For :</td><td>Manager wise/Area Report</td></tr>
                    <?php 
					$rs=mysql_query("select * from representative where rep_id='$rr_id'");
					$row_rs=mysql_fetch_array($rs);
					?>
                     <tr><td></td><td>Manager Name :</td><td><?php echo $row_rs['rep_name']; ?></td></tr>
                     <?php
					  $re=mysql_query("select * from representative where rep_under='$rr_id'");
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
<th>Rep Name</th>
<th>Pincode</th>
<th>Area Name</th>
<th>Pharmacy Name</th>
<th>Distributor Name</th>
<th>Product Name</th>
<th>Bill Number</th>
<th>Bill Date</th>
<th>Qnty</th>
<th>Sale Value</th>
<th>Free Qnty</th>
<th>Rpl Qnty</th>
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
$a=mysql_query("select DISTINCT pincode from  areawise_temp  where  bill_date>='$from_date' AND bill_date<='$to_date' and  m_id16='$m_id16' and pincode='$pincode' and dist_id='$dist_id14' order by area_name asc");
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
//echo "select * from  representative where rep_id='$rr_id'";
$b65=mysql_query("select * from  representative where rep_id='$rr_id'");
$row_b65=mysql_fetch_array($b65);

?>
<tr>
<td align="center"><?php echo $row_b65['rep_name']; ?>(Manager)</td>
<td align="center"><?php echo $pincode_a; ?></td>
<?php
if($count_b=='0')
{
$b1=mysql_query("select * from  areawise_temp where pincode='$pincode_a'  and  m_id16='$m_id16'  and dist_id='$dist_id14'");
$row_b1=mysql_fetch_array($b1);
$aa1=$row_b1['area_name'];
?>
<td style="color:#FF0000;"><?php echo $row_b1['area_name']; ?></td>
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
$a1=mysql_query("select DISTINCT cust_id from  areawise_temp  where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a' and dist_id='$dist_id14' order by cust_id asc");
$count_a1=mysql_num_rows($a1);
if($count_a1>0)
{
$tot_area=0;
while($row_a1=mysql_fetch_array($a1))
{
$cust_id=$row_a1['cust_id'];
$a6=mysql_query("select * from  customer  where  dc_id='$cust_id'");
$count_a6=mysql_num_rows($a6);
$a2=mysql_query("select cust_name,dist_id  from  areawise_temp  where  cust_id='$cust_id'  and  m_id16='$m_id16'  and dist_id='$dist_id14'");
$row_a2=mysql_fetch_array($a2);
$cust_name=$row_a2['cust_name'];
$dist_id=$row_a2['dist_id'];
$a3=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id'  and  m_id16='$m_id16'");
$row_a3=mysql_fetch_array($a3);
$dis_name=$row_a3['dis_name'];
?>
<tr>
<td colspan="3"></td>
<td <?php if($count_a6=='0') {  ?> style="color:#FF0000;" <?php }?> align="center"><?php echo $cust_name; ?></td>
<td align="center"><?php echo ucwords($dis_name); ?></td>
<td colspan="8"></td>
</tr>
<?php
$a4=mysql_query("select * from  areawise_temp  where    bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a' and cust_id='$cust_id' and dist_id='$dist_id14' order by pro_name asc");
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

$a5=mysql_query("select * from  areawise_temp  where  our_id!='' AND pro_id='$pro_id' and  m_id16='$m_id16' and dist_id='$dist_id14'");
$count_a5=mysql_num_rows($a5);
$net_amount=$row_a4['net_amount'];
?>
<tr>
<td colspan="3"></td>
<td colspan="2"></td>
<td <?php if($our_id=='') {  ?> style="color:#FF0000;" <?php }?> align="center"><?php echo ucwords($product_name); ?></td>
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
<td colspan="3"></td>
<td colspan="10"><span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total/Pharmacy (<?php echo $cust_name; ?>) : <?php echo $tot_pharmacy; ?></span></td>
</tr>
<?php
}
$tot_area=$tot_pharmacy+$tot_area;
}
?>
<tr>
<td colspan="13" style="background-color:#CCCC99;"><span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total/Area (<?php echo $aa1; ?>) : <?php echo $tot_area; ?></span></td>
</tr>
<?php
}
}
?> 
<?php
}
else
{
}
?>   
<?php
}
$yt=mysql_query("select * from representative where rep_under='$rr_id'");
while($row_yt=mysql_fetch_array($yt))
{
$rr_id12=$row_yt['rep_id'];
?>











<?php
$z12=mysql_query("select * from  rep_area where rep_id='$rr_id12'");
$count_z12=mysql_num_rows($z12);
if($count_z12>0)
{
while($row_z12=mysql_fetch_array($z12))
{
$area_id12=$row_z12['area_id'];
$y12=mysql_query("select * from  pincode_list where id='$area_id12'");
$row_y12=mysql_fetch_array($y12);
$pincode12=$row_y12['pincode'];
?>

<?php
$a12=mysql_query("select DISTINCT pincode from  areawise_temp  where  bill_date>='$from_date' AND bill_date<='$to_date' and  m_id16='$m_id16' and pincode='$pincode12' and dist_id='$dist_id14' order by area_name asc");
$count_a12=mysql_num_rows($a12);
if($count_a12>0)
{
while($row_a12=mysql_fetch_array($a12))
{
$pincode_a12=$row_a12['pincode'];

$b12=mysql_query("select * from  pincode_list where pincode='$pincode_a12'");
$count_b12=mysql_num_rows($b12);
$row_b12=mysql_fetch_array($b12);
$b_id12=$row_b12['id'];

$b6512=mysql_query("select * from  representative where rep_id='$rr_id12'");
$row_b6512=mysql_fetch_array($b6512);
?>
<tr>
<td align="center"><?php echo $row_b6512['rep_name']; ?>(Executive)</td>
<td align="center"><?php echo $pincode_a12; ?></td>
<?php
if($count_b12=='0')
{
$b112=mysql_query("select * from  areawise_temp where pincode='$pincode_a12'  and  m_id16='$m_id16' and dist_id='$dist_id14'");
$row_b112=mysql_fetch_array($b112);
$aa112=$row_b112['area_name'];
?>
<td style="color:#FF0000;"><?php echo $row_b112['area_name']; ?></td>
<?php
}
else
{
$aa112=$row_b12['area_name'];
?>
<td align="center"><?php echo $row_b12['area_name']; ?></td>
<?php
}
?>


<td colspan="10"></td>
</tr>
<?php
$a112=mysql_query("select DISTINCT cust_id from  areawise_temp  where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a12' and dist_id='$dist_id14' order by cust_id asc");
$count_a112=mysql_num_rows($a112);
if($count_a112>0)
{
$tot_area12=0;
while($row_a112=mysql_fetch_array($a112))
{
$cust_id12=$row_a112['cust_id'];
$a612=mysql_query("select * from  customer  where  dc_id='$cust_id12'");
$count_a612=mysql_num_rows($a612);
$a212=mysql_query("select cust_name,dist_id  from  areawise_temp  where  cust_id='$cust_id12'  and  m_id16='$m_id16' and dist_id='$dist_id14'");
$row_a212=mysql_fetch_array($a212);
$cust_name12=$row_a212['cust_name'];
$dist_id12=$row_a212['dist_id'];
$a312=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id12'  and  m_id16='$m_id16'");
$row_a312=mysql_fetch_array($a312);
$dis_name12=$row_a312['dis_name'];
?>
<tr>
<td colspan="3"></td>
<td align="center" <?php if($count_a612=='0') {  ?> style="color:#FF0000;" <?php }?>><?php echo $cust_name12; ?></td>
<td align="center"><?php echo ucwords($dis_name12); ?></td>
<td colspan="8"></td>
</tr>
<?php
$a412=mysql_query("select * from  areawise_temp  where    bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pincode='$pincode_a12' and cust_id='$cust_id12' and dist_id='$dist_id14' order by pro_name asc");
$count_a412=mysql_num_rows($a412);
if($count_a412>0)
{
$tot_pharmacy12=0;
while($row_a412=mysql_fetch_array($a412))
{
$pro_id12=$row_a412['pro_id'];

$b12=mysql_query("select * from dist_prod where pro_id='$pro_id12'");
$row_b12=mysql_fetch_array($b12);
$our_id12=$row_b12['our_id'];
if($our_id12=='')

{
$d12=mysql_query("select * from areawise_temp where pro_id='$pro_id12'  and  m_id16='$m_id16' and  dist_id='$dist_id12'");
$row_d12=mysql_fetch_array($d12);
$product_name12=$row_d12['pro_name'];
}
else
{
$c12=mysql_query("select * from product where id='$our_id12'");
$row_c12=mysql_fetch_array($c12);
$product_name12=$row_c12['pro_name'];
}

$a512=mysql_query("select * from  areawise_temp  where  our_id!='' AND pro_id='$pro_id12' and  m_id16='$m_id16' and dist_id='$dist_id14'");
$count_a512=mysql_num_rows($a512);
$net_amount12=$row_a412['net_amount'];
?>
<tr>
<td colspan="3"></td>
<td colspan="2"></td>
<td align="center" <?php if($our_id12=='') {  ?> style="color:#FF0000;" <?php }?>><?php echo ucwords($product_name12); ?></td>
<td align="center"><?php echo  $row_a412['bill_no']; ?></td>
<td align="center"><?php echo $row_a412['bill_date']; ?></td>
<td align="center"><?php echo $row_a412['quantity']; ?></td>
<td align="center"><?php echo $row_a412['sale_value']; ?></td>
<td align="center"><?php echo $row_a412['replace_quantity']; ?></td>
<td align="center"><?php echo $row_a412['free_quantity']; ?></td>
<td align="center"><?php echo $row_a412['net_amount']; ?></td>
</tr>
<?php
$tot_pharmacy12=$net_amount12+$tot_pharmacy12;
}
?>
<tr>
<td colspan="3"></td>
<td colspan="10"><span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total/Pharmacy (<?php echo $cust_name12; ?>) : <?php echo $tot_pharmacy12; ?></span></td>
</tr>
<?php
}
$tot_area12=$tot_pharmacy12+$tot_area12;
}
?>
<tr>
<td colspan="13" style="background-color:#CCCC99;"><span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total/Area (<?php echo $aa112; ?>) : <?php echo $tot_area12; ?></span></td>
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








<?php
}
}
?>
</tbody>
</table>  

		
</body>
</html>

