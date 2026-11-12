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
				   $d=mysql_query("select * from representative order by id desc");
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
				  }
				   
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
				  // echo "select * from representative where rep_id='$rep'";
				   $d=mysql_query("select * from representative where  rep_id='$rep'");
				   $count_d=mysql_num_rows($d);
				  // echo $count_d;
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
				  }
				   
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
