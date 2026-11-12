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
                        <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
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
                       <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                   <?php
				   }
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
<th style="text-align:center;">Representative Name</th>
<th style="width:200px;text-align:center;">Position</th>
<th style="width:57px;text-align:center;">Pincode</th>
<th style="width:84px;text-align:center;">Area Name</th>
<th style="width:193px;text-align:center;">Pharmacy Name</th>
<th style="width:87px;text-align:center;">Distributor Name</th>
<th style="width:186px;text-align:center;">Product Name</th>
<th style="width:73px;text-align:center;">Bill Number</th>
<th style="width:54px;text-align:center;">Bill Date</th>
<th style="width:53px;text-align:center;">Quantity</th>
<th style="width:60px;text-align:center;">Sale Value</th>
<th style="width:69px;text-align:center;">Net Amount</th>
<th style="width:60px;text-align:center;">Rpl qnty</th>
<th style="width:69px;text-align:center;">free qnty</th>
</tr>



<?php
$d=mysql_query("select * from representative where position='manager'");
$count_d=mysql_num_rows($d);
if($count_d>0)
{
$total=0;
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
$g=mysql_query("select * from areawise_temp where pincode='$pincode_f' and   bill_string>='$from_string' AND bill_string<='$to_string'");
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
<td><div style="width:78px;text-align:center;"><?php echo $row_g['bill_no']; ?></div></td>
<td><div style="width:57px;text-align:center;"><?php echo $row_g['bill_date']; ?></div></td>
<td><div style="width:57px;text-align:center;"><?php echo $row_g['quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_g['sale_value']; ?></div></td>
<td><div style="width:72px;text-align:center;"><?php echo $row_g['net_amount']; ?></div></td>
<td><div style="width:63px;text-align:center;"><?php echo $row_g['replace_quantity']; ?></div></td>
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
<tr><td colspan="14"><span style="color:#000000; font-weight:bold; font-size:20px;">Executive Under : <?php echo $row_d['rep_name']; ?></span></td></tr>

<?php 
$k=mysql_query("select * from representative where rep_under='$rep_id_d'");
$count_k=mysql_num_rows($k);
if($count_k>0)
{
$tot7=0;
while($row_k=mysql_fetch_array($k))
{
$rep_id_k=$row_k['rep_id'];
$rep_name_k=$row_k['rep_name'];
?>
<tr>

<td><div style="width:200px;text-align:center;"><?php echo $row_k['rep_name']; ?></div></td>
<td><div style="width:200px;text-align:center;"><?php echo $row_k['position']; ?></div></td>
<td colspan="12">


<?php
$l=mysql_query("select * from rep_area where rep_id='$rep_id_k'");
$count_l=mysql_num_rows($l);

if($count_l>0)
{
$tot6=0;
while($row_l=mysql_fetch_array($l))
{
$area_id_l=$row_l['area_id'];
$m=mysql_query("select * from pincode_list where id='$area_id_l'");
$row_m=mysql_fetch_array($m);
$pincode_m=$row_m['pincode'];
?>
<table style="margin-left:-9px; margin-top:-7px;"><tr>
<td><div style="width:60px;text-align:center;"><?php echo $row_m['pincode']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_m['area_name']; ?></div></td>
<td>
<?php
$tot5=0;
 //echo "select * from areawise_temp where pincode='$pincode_m'";
$n=mysql_query("select * from areawise_temp where pincode='$pincode_m' AND   bill_string>='$from_string' AND bill_string<='$to_string'");
while($row_n=mysql_fetch_array($n))
{
$dist_id_n=$row_n['dist_id'];
$dc_id_n=$row_n['pro_id']; 

$o=mysql_query("select * from distributor where dis_id='$dist_id_n'");
$row_o=mysql_fetch_array($o);
//echo "select * from dist_prod where pro_id='$dc_id'";
$p=mysql_query("select * from dist_prod where pro_id='$dc_id_n'");
$row_p=mysql_fetch_array($p);
$our_id_p=$row_p['our_id'];
$q=mysql_query("select * from product where id='$our_id_p'");
$row_q=mysql_fetch_array($q);
?>
<table style="margin-left:-9px; margin-top:-7px;">
<tr>
<td><div style="width:200px;text-align:center;"><?php echo $row_n['cust_name']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_o['dis_name']; ?></div></td>
<td><div style="width:200px;text-align:center;"><?php echo $row_q['pro_name']; ?></div></td>
<td><div style="width:80px;text-align:center;"><?php echo $row_n['bill_no']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['bill_date']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['sale_value']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['net_amount']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
</tr>
</tr>
</table>
<?php
$tot5=$tot5+$row_n['net_amount'];
//echo $tot5;
}
?>




</td></tr></table>
<?php
$tot6=$tot6+$tot5;
}
}
?>

</td>
</tr>
<tr><td colspan="14"><span style="color:#0000FF; font-weight:bold; font-size:14px; float:right;">Net Amount Total/Representative : <?php echo $tot6; ?></span></td></tr>
<?php
$tot7=$tot7+$tot6;
} 
$total=$tot7+$tot1;
 ?>
<tr><td colspan="14"><span style="color:#FF0000; font-weight:bold; font-size:16px; float:right;">Net Amount Total/Team : <?php echo $total; ?></span></td></tr>
<?php
}

else
{
?>

<tr><td colspan="14">No one under him</td></tr>
<?php
}
?>

<?php

}
?>

<?php
}
else
{
?>
<tr><td colspan="14">No Manager</td></tr>
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
<th style="text-align:center;">Representative Name</th>
<th style="width:200px;text-align:center;">Position</th>
<th style="width:57px;text-align:center;">Pincode</th>
<th style="width:84px;text-align:center;">Area Name</th>
<th style="width:193px;text-align:center;">Pharmacy Name</th>
<th style="width:87px;text-align:center;">Distributor Name</th>
<th style="width:186px;text-align:center;">Product Name</th>
<th style="width:73px;text-align:center;">Bill Number</th>
<th style="width:54px;text-align:center;">Bill Date</th>
<th style="width:53px;text-align:center;">Quantity</th>
<th style="width:60px;text-align:center;">Sale Value</th>
<th style="width:69px;text-align:center;">Net Amount</th>
<th style="width:60px;text-align:center;">Rpl qnty</th>
<th style="width:69px;text-align:center;">free qnty</th>
</tr>




<?php
$d=mysql_query("select * from representative where rep_id='$manager'");
$count_d=mysql_num_rows($d);
if($count_d>0)
{
$total=0;
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
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
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
<tr><td colspan="14"><span style="color:#000000; font-weight:bold; font-size:20px;">Executive Under : <?php echo $row_d['rep_name']; ?></span></td></tr>

<?php 
$k=mysql_query("select * from representative where rep_under='$rep_id_d'");
$count_k=mysql_num_rows($k);
if($count_k>0)
{
$tot7=0;
while($row_k=mysql_fetch_array($k))
{
$rep_id_k=$row_k['rep_id'];
$rep_name_k=$row_k['rep_name'];
?>
<tr>

<td><div style="width:200px;text-align:center;"><?php echo $row_k['rep_name']; ?></div></td>
<td><div style="width:200px;text-align:center;"><?php echo $row_k['position']; ?></div></td>
<td colspan="12">


<?php
$l=mysql_query("select * from rep_area where rep_id='$rep_id_k'");
$count_l=mysql_num_rows($l);

if($count_l>0)
{
$tot6=0;
while($row_l=mysql_fetch_array($l))
{
$area_id_l=$row_l['area_id'];
$m=mysql_query("select * from pincode_list where id='$area_id_l'");
$row_m=mysql_fetch_array($m);
$pincode_m=$row_m['pincode'];
?>
<table style="margin-left:-9px; margin-top:-7px;"><tr>
<td><div style="width:60px;text-align:center;"><?php echo $row_m['pincode']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_m['area_name']; ?></div></td>
<td>
<?php
$tot5=0;
 //echo "select * from areawise_temp where pincode='$pincode_m'";
$n=mysql_query("select * from areawise_temp where pincode='$pincode_m' and bill_string>='$from_string' AND bill_string<='$to_string'");
while($row_n=mysql_fetch_array($n))
{
$dist_id_n=$row_n['dist_id'];
$dc_id_n=$row_n['pro_id']; 

$o=mysql_query("select * from distributor where dis_id='$dist_id_n'");
$row_o=mysql_fetch_array($o);
//echo "select * from dist_prod where pro_id='$dc_id'";
$p=mysql_query("select * from dist_prod where pro_id='$dc_id_n'");
$row_p=mysql_fetch_array($p);
$our_id_p=$row_p['our_id'];
$q=mysql_query("select * from product where id='$our_id_p'");
$row_q=mysql_fetch_array($q);
?>
<table style="margin-left:-9px; margin-top:-7px;" >
<tr>
<td><div style="width:200px;text-align:center;"><?php echo $row_n['cust_name']; ?></div></td>
<td><div style="width:90px;text-align:center;"><?php echo $row_o['dis_name']; ?></div></td>
<td><div style="width:200px;text-align:center;"><?php echo $row_q['pro_name']; ?></div></td>
<td><div style="width:80px;text-align:center;"><?php echo $row_n['bill_no']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['bill_date']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['sale_value']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['net_amount']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
<td><div style="width:60px;text-align:center;"><?php echo $row_n['replace_quantity']; ?></div></td>
</tr>
</table>
<?php
$tot5=$tot5+$row_n['net_amount'];
//echo $tot5;
}
?>




</td></tr></table>
<?php
$tot6=$tot6+$tot5;
}
}
?>

</td>
</tr>
<tr><td colspan="14"><span style="color:#0000FF; font-weight:bold; font-size:14px; float:right;">Net Amount Total/Representative : <?php echo $tot6; ?></span></td></tr>
<?php
$tot7=$tot7+$tot6;
} 
$total=$tot7+$tot1;
 ?>
<tr><td colspan="14"><span style="color:#FF0000; font-weight:bold; font-size:16px; float:right;">Net Amount Total/Team : <?php echo $total; ?></span></td></tr>
<?php
}

else
{
?>

<tr><td colspan="14">No one under him</td></tr>
<?php
}
?>

<?php

}
?>

<?php
}
else
{
?>
<tr><td colspan="14">No Manager</td></tr>
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
