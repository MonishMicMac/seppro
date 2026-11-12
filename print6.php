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
$rep=$_SESSION['rep'];
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
		<!-- topbar starts -->
	
             <?php
if($rep=='1')
{
?>
                  
<table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
<tr>
<th style="text-align:center;">Representative Name</th>
<th style="width:200px;text-align:center;">Position</th>
<th style="width:57px;text-align:center;">Pincode</th>
<th style="width:85px;text-align:center;">Area Name</th>
<th style="width:193px;text-align:center;">Pharmacy Name</th>
<th style="width:87px;text-align:center;">Distributor Name</th>
<th style="width:185px;text-align:center;">Product Name</th>
<th style="width:77px;text-align:center;">Bill Number</th>
<th style="width:59px;text-align:center;">Bill Date</th>
<th style="width:53px;text-align:center;">Quantity</th>
<th style="width:60px;text-align:center;">Sale Value</th>
<th style="width:71px;text-align:center;">Net Amount</th>
<th style="width:60px;text-align:center;">Rpl Qnty</th>
<th style="width:71px;text-align:center;">Free Qnty</th>
</tr>



<?php
$d=mysql_query("select * from representative order by id desc");
$count_d=mysql_num_rows($d);
if($count_d>0)
{
while($row_d=mysql_fetch_array($d))
{
$rep_id_d=$row_d['rep_id'];
?>
<tr>
<td><div style="width:200px;text-align:center;"><?php echo $row_d['rep_name']; ?></div></td><td><div style="width:200px;text-align:center;"><?php echo $row_d['position']; ?></div></td>
<td colspan="12">
<?php
$tot1=0;
$e=mysql_query("select * from rep_area where rep_id='$rep_id_d'");
$count_e=mysql_num_rows($e);
if($count_e>0)
{
while($row_e=mysql_fetch_array($e))
{
$area_id_e=$row_e['area_id'];
$f=mysql_query("select * from pincode_list where id='$area_id_e'");
$row_f=mysql_fetch_array($f);
$pincode_f=$row_f['pincode'];
?>
<table style="margin-left:-9px; margin-top:-7px;"><tr>
<td><div style="width:60px;text-align:center;"><?php echo $row_f['pincode']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_f['area_name']; ?></div></td>
<td>
<?php
$tot=0;
//echo "select * from areawise_temp where pincode='$pincode_f'";
$g=mysql_query("select * from areawise_temp where pincode='$pincode_f' and bill_string>='$from_string' AND bill_string<='$to_string'");
while($row_g=mysql_fetch_array($g))
{
$dist_id_g=$row_g['dist_id'];
$dc_id=$row_g['pro_id']; 
$h=mysql_query("select * from distributor where dis_id='$dist_id_g'");
$row_h=mysql_fetch_array($h);
//echo "select * from dist_prod where pro_id='$dc_id'";
$i=mysql_query("select * from dist_prod where pro_id='$dc_id'");
$row_i=mysql_fetch_array($i);
$our_id=$row_i['our_id'];
$j=mysql_query("select * from product where id='$our_id'");
$row_j=mysql_fetch_array($j);
?>
<table style="margin-left:-9px; margin-top:-7px;">
<tr>
<td><div style="width:200px;text-align:center;"><?php echo $row_g['cust_name']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_h['dis_name']; ?></div></td>
<td><div style="width:200px;text-align:center;"><?php echo $row_j['pro_name']; ?></div></td>
<td><div style="width:80px;text-align:center;"><?php echo $row_g['bill_no']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['bill_date']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['sale_value']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['net_amount']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['replace_quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['free_quantity']; ?></div></td>
</tr>
</table>
<?php
$tot=$tot+$row_g['net_amount'];
}
?>

</td>
</tr></table>
<?php
$tot1=$tot1+$tot;
}
?>

<?php
}
?>

</td></tr>
<tr><td colspan="14"><span style="color:#0000FF; font-weight:bold; font-size:14px; float:right;">Net Amount Total/Representative : <?php echo $tot1; ?></span></td></tr>


<?php

}
?>

<?php
}
else
{
?>
<tr><td colspan="14">No Representative</td></tr>
<?php
}
?>                  
</table>
                        
  <?php
  }
  else
  {
  ?>
  <table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
<tr>
<th style="text-align:center;">Representative Name</th>
<th style="width:200px;text-align:center;">Position</th>
<th style="width:57px;text-align:center;">Pincode</th>
<th style="width:85px;text-align:center;">Area Name</th>
<th style="width:193px;text-align:center;">Pharmacy Name</th>
<th style="width:87px;text-align:center;">Distributor Name</th>
<th style="width:185px;text-align:center;">Product Name</th>
<th style="width:77px;text-align:center;">Bill Number</th>
<th style="width:59px;text-align:center;">Bill Date</th>
<th style="width:53px;text-align:center;">Quantity</th>
<th style="width:60px;text-align:center;">Sale Value</th>
<th style="width:71px;text-align:center;">Net Amount</th>
<th style="width:60px;text-align:center;">Rpl qnty</th>
<th style="width:71px;text-align:center;">free qnty</th>
</tr>



<?php
$d=mysql_query("select * from representative where rep_id='$rep'");
$count_d=mysql_num_rows($d);
if($count_d>0)
{
while($row_d=mysql_fetch_array($d))
{
$rep_id_d=$row_d['rep_id'];
?>
<tr>
<td><div style="width:200px;"><?php echo $row_d['rep_name']; ?></div></td><td><div style="width:200px;text-align:center;"><?php echo $row_d['position']; ?></div></td>
<td colspan="12">
<?php
$tot1=0;
$e=mysql_query("select * from rep_area where rep_id='$rep_id_d'");
$count_e=mysql_num_rows($e);
if($count_e>0)
{
while($row_e=mysql_fetch_array($e))
{
$area_id_e=$row_e['area_id'];
$f=mysql_query("select * from pincode_list where id='$area_id_e'");
$row_f=mysql_fetch_array($f);
$pincode_f=$row_f['pincode'];
?>
<table style="margin-left:-9px; margin-top:-7px;"><tr>
<td><div style="width:60px;text-align:center;"><?php echo $row_f['pincode']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_f['area_name']; ?></div></td>
<td>
<?php
$tot=0;
//echo "select * from areawise_temp where pincode='$pincode_f'";
$g=mysql_query("select * from areawise_temp where pincode='$pincode_f' and bill_string>='$from_string' AND bill_string<='$to_string'");
while($row_g=mysql_fetch_array($g))
{
$dist_id_g=$row_g['dist_id'];
$dc_id=$row_g['pro_id']; 
$h=mysql_query("select * from distributor where dis_id='$dist_id_g'");
$row_h=mysql_fetch_array($h);
//echo "select * from dist_prod where pro_id='$dc_id'";
$i=mysql_query("select * from dist_prod where pro_id='$dc_id'");
$row_i=mysql_fetch_array($i);
$our_id=$row_i['our_id'];
$j=mysql_query("select * from product where id='$our_id'");
$row_j=mysql_fetch_array($j);
?>
<table style="margin-left:-9px; margin-top:-7px;">
<tr>
<td><div style="width:200px;text-align:center;"><?php echo $row_g['cust_name']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_h['dis_name']; ?></div></td>
<td><div style="width:195px;text-align:center;"><?php echo $row_j['pro_name']; ?></div></td>
<td><div style="width:80px;text-align:center;"><?php echo $row_g['bill_no']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['bill_date']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['sale_value']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['net_amount']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['replace_quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['free_quantity']; ?></div></td>
</tr>
</table>
<?php
$tot=$tot+$row_g['net_amount'];
}
?>

</td>
</tr></table>
<?php
$tot1=$tot1+$tot;
}
?>

<?php
}
?>

</td></tr>
<tr><td colspan="14"><span style="color:#0000FF; font-weight:bold; font-size:14px; float:right;">Net Amount Total/Representative : <?php echo $tot1; ?></span></td></tr>


<?php

}
?>

<?php
}
else
{
?>
<tr><td colspan="14">No Representative</td></tr>
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
