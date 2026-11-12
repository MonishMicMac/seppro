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
$rep_id=$_SESSION['rep_id'];
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

                         <table>
                    <tr><td>Result For :</td><td>Area wise Product Report</td></tr>
                    <?php 
					$rs=mysql_query("select * from representative where rep_id='$rep_id'");
					$row_rs=mysql_fetch_array($rs);
					?>
                    <tr><td></td><td>Representative Name :</td><td><?php echo $row_rs['rep_name']; ?></td></tr>
                     <tr><td></td><td>From Date :</td><td><?php echo $from_date; ?></td></tr>
                     <tr><td></td><td>To Date :</td><td><?php echo $to_date; ?></td></tr>
                    </table>
						<table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
						<tbody>
                 
                         
                         
                         <tr>
<th>Product Name</th>
<th>Pincode</th>
<th>Area Name</th>
<th>
<div style="width:69px;text-align:center;">Distributor Name</div>
</th>
<th>
<div style="width:149px;text-align:center;">Pharmacy Name</div>
</th>
<th>
<div style="width:71px;text-align:center;">Bill No</div>
</th>
<th>
<div style="width:54px;text-align:center;">Bill Date</div>
</th>
<th>
<div style="width:41px;text-align:center;">Quantity</div>
</th>
<th>
<div style="width:46px;text-align:center;">Sale Value</div>
</th>
<th>
<div style="width:48px;text-align:center;">Net Amount</div>
</th>
<th>
<div style="width:46px;text-align:center;">Rpl qnty</div>
</th>
<th>
<div style="width:48px;text-align:center;">free qnty</div>
</th>
                         </tr>
                           <?php
					   /*  bill_string>='$from_string' AND bill_string<='$to_string'*/
					   //echo "select * from  areawise_temp where  bill_string>='$from_string' AND bill_string<='$to_string'";
					  // echo "select * from rep_area where rep_id='$rep_id'";
					   $x=mysql_query("select * from rep_area where rep_id='$rep_id'");
					   $count_x=mysql_num_rows($x);
					   if($count_x>0)
					   {
					  // $total1=0;
					   while($row_x=mysql_fetch_array($x))
					   {
					   $area_id=$row_x['area_id'];
					 //  echo "select * from pincode_list where id='$area_id'";
					   $y=mysql_query("select * from pincode_list where id='$area_id'");
					   $row_y=mysql_fetch_array($y);
					   $pin=$row_y['pincode'];
					  // echo "select DISTINCT pro_id from  areawise_temp where pincode='$pin' and bill_string>='$from_string' AND bill_string<='$to_string'";
					   $a=mysql_query("select DISTINCT pro_id from  areawise_temp where pincode='$pin' and bill_string>='$from_string' AND bill_string<='$to_string'");
					   $count_a=mysql_num_rows($a);
					   if($count_a>0)
					   {
					  //  $total=0;
					   while($row_a=mysql_fetch_array($a))
					   {
					   $pro_id=$row_a['pro_id'];
					    $b=mysql_query("select * from dist_prod where pro_id='$pro_id'");
					   $row_b=mysql_fetch_array($b);
					   $our_id=$row_b['our_id'];
					   $c=mysql_query("select * from product where id='$our_id'");
					   $row_c=mysql_fetch_array($c);
					   
					    ?>
					   <tr><td style="width:200px;">
					   <div style="width:150px;text-align:center;"><?php echo $row_c['pro_name']; ?></div></td>
                       <td colspan="11">
                       <?php
					   $tot1=0;
					   //echo "select DISTINCT pincode from areawise_temp where pro_id='$pro_id' and bill_string>='$from_string' AND bill_string<='$to_string'";
					   $d=mysql_query("select DISTINCT pincode from areawise_temp where pro_id='$pro_id' and bill_string>='$from_string' AND bill_string<='$to_string'");
					   while($row_d=mysql_fetch_array($d))
					   {
						$pincode_d=$row_d['pincode'];
						$e=mysql_query("select * from  pincode_list where pincode='$pincode_d'");
						$row_e=mysql_fetch_array($e);
						$e_id=$row_e['id'];
						?>
						<table style="margin-left:-9px; margin-top:-8px;  margin-bottom:-9px;">
                        <tr>
                        <td><div style="width:85px;text-align:center;"><?php echo $row_d['pincode']; ?></div></td>
                          <td><div style="width:110px;text-align:center;"><?php echo $row_e['area_name']; ?></div></td>
                        <td>
                        <?php
						$tot=0;
						//echo "select * from areawise_temp where pincode='$pincode_d' and pro_id='$pro_id'";
						 $f=mysql_query("select * from areawise_temp where pincode='$pincode_d' and pro_id='$pro_id' and bill_string>='$from_string' AND bill_string<='$to_string'");
					   while($row_f=mysql_fetch_array($f))
                       {
					   $f_cus_id=$row_f['cust_id'];
					   $f_dist_id=$row_f['dist_id'];
					   $g=mysql_query("select * from customer where dc_id='$f_cus_id'");
					   $row_g=mysql_fetch_array($g);
					    $u=mysql_query("select * from distributor where dis_id='$f_dist_id'");
					   $row_u=mysql_fetch_array($u);
						?>
                        <table style="margin-left:-9px; margin-top:-8px;  margin-bottom:-9px;"><tr>
                        <td><div style="width:106px;text-align:center;"><?php echo $row_u['dis_name']; ?></div></td>
                        <td><div style="width:220px;text-align:center;"><?php echo $row_g['cust_name']; ?></div></td>
                        <td><div style="width:110px;text-align:center;"><?php echo  $row_f['bill_no']; ?></div></td>
                        <td><div style="width:84px;text-align:center;"><?php echo  $row_f['bill_date']; ?></div></td>
                        <td><div style="width:65px;text-align:center;"><?php echo  $row_f['quantity']; ?></div></td>
                        <td><div style="width:75px;text-align:center;"><?php echo  $row_f['sale_value']; ?></div></td>
                        <td><div style="width:77px;text-align:center;"><?php echo  $row_f['net_amount']; ?></div></td>
                        <td><div style="width:75px;text-align:center;"><?php echo  $row_f['replace_quantity']; ?></div></td>
                        <td><div style="width:54px;text-align:center;"><?php echo  $row_f['free_quantity']; ?></div></td>
                        </tr></table>
                        <?php
						 $tot=$tot+$row_f['net_amount'];
						}
						?>
                        </td></tr></table>
                        
					  <?php
					  $tot1=$tot1+$tot;
					   }
						?>
                       </td>
                       </tr>
                        <tr><td colspan="12"><div  style="float:right;" ><span style="color:#0000FF; font-weight:bold; font-size:14px;">Total Net Amount/Product:<?php echo $tot1; ?></span></div></td></tr>
                       <?php
					   //$total=$total+$tot1;
					   }
					   ?>
					    
					   <?php
					   }
					   	 // $total1=$total1+$tot1;			   
					   }
					   ?>
                    <!--   <tr><td colspan="10"><div  style="float:right;" >Grand Total:<?php echo $total1; ?></div></td></tr>-->
                       <?php
					   }
					    else
					   {
					   ?>
                       <tr><td colspan="12">No Area Assigned For this Rep</td></tr>
                       <?php
					   }
					   ?>
                          
                          </tbody>
					  </table>            
					
		
</body>
</html>
<?php
}
?>
