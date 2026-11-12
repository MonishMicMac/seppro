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
$dist_id=$_SESSION['dist_id'];
$from_date=$_SESSION['from_date'];
$to_date=$_SESSION['to_date'];
$from_string=strtotime($from_date);
$to_string=strtotime($to_date);
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
		<!-- topbar starts -->   <table>
                    <tr><td>Result for:</td><td>Productwise report</td></tr>
                      <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                    </table>
	
						<table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
						<tbody>
                 
                         
                         
                         <tr>
<th style="width:200px;text-align:center;">Product Name</th>
<th style="width:50px;text-align:center;">Pincode</th>
<th style="width:90px;text-align:center;">Area Name</th>
<th style="width:130px;text-align:center;">Representative Name</th>
<th style="width:130px;text-align:center;">Distributor Name</th>
<th style="width:195px;text-align:center;">Pharmacy Name</th>
<th style="width:73px;text-align:center;">Bill No</th>
<th style="width:71px;text-align:center;">Bill Date</th>
<th style="width:55px;text-align:center;">Quantity</th>
<th style="width:60px;text-align:center;">Sale Value</th>
<th style="width:77px;text-align:center;">Net Amount</th>
<th style="width:60px;text-align:center;">Rpl qnty</th>
<th style="width:77px;text-align:center;">free qnty</th>

                         </tr>
                           <?php
					   /*  bill_string>='$from_string' AND bill_string<='$to_string'*/
					   //echo "select * from  areawise_temp where  bill_string>='$from_string' AND bill_string<='$to_string'";
					   $a=mysql_query("select DISTINCT pro_id from  areawise_temp where  bill_string>='$from_string' AND bill_string<='$to_string' order by id desc");
					   $count_a=mysql_num_rows($a);
					   if($count_a>0)
					   {
					  $total=0;
					   while($row_a=mysql_fetch_array($a))
					   {
					   $pro_id=$row_a['pro_id'];
					   $b=mysql_query("select * from dist_prod where pro_id='$pro_id'");
					   $row_b=mysql_fetch_array($b);
					   $our_id=$row_b['our_id'];
					   $c=mysql_query("select * from product where id='$our_id'");
					   $row_c=mysql_fetch_array($c);
					   
					   ?>
                       <tr>
                       <td style="width:200px;">
					   <div style="width:200px;text-align:center;"><?php echo $row_c['pro_name']; ?></div></td>
                        
                       <td colspan="12">
                       <?php
					   $tot1=0;
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
                        <td>
                        <div style="width:50px;text-align:center;"><?php echo $row_d['pincode']; ?></div></td>
                         <td>
                        <div style="width:90px;text-align:center;"><?php echo $row_e['area_name']; ?></div></td>
                        <td>
                        <div style="width:127px;text-align:center;">
                        
                        <?php
					   //echo "select * from  pincode_list where pincode='$pincode_d'";
                       $h=mysql_query("select * from  pincode_list where pincode='$pincode_d'");
						while($row_h=mysql_fetch_array($h))
						{
						$h_id=$row_h['id'];
						//echo "select * from rep_area where area_id='$h_id'";
						$i=mysql_query("select * from rep_area where area_id='$h_id'");	
						while($row_i=mysql_fetch_array($i))		
						{	 
						$rep_id_i=$row_i['rep_id'];
						$j=mysql_query("select * from representative where rep_id='$rep_id_i'");	
						$row_j=mysql_fetch_array($j);	
						echo $row_j['rep_name'];
						?><br>
						<?php
						}
						}
                        ?>
                        
                        </div>
                        </td>
                        <td>
                       <?php
					   $tot=0;
					  // echo "select * from areawise_temp where pincode='$pincode_d' and pro_id='$pro_id'";
					   $f=mysql_query("select * from areawise_temp where pincode='$pincode_d' and pro_id='$pro_id' and bill_string>='$from_string' AND bill_string<='$to_string'");
					   while($row_f=mysql_fetch_array($f))
                       {
					   $f_cus_id=$row_f['cust_id'];
					   $f_dist_id=$row_f['dist_id'];
					  // echo "select * from customer where dc_id='$f_cus_id'";
					   $g=mysql_query("select * from customer where dc_id='$f_cus_id'");
					   $row_g=mysql_fetch_array($g);
					    $x=mysql_query("select * from distributor where dis_id='$f_dist_id'");
					   $row_x=mysql_fetch_array($x);
					   ?>
					    <table style="margin-left:-13px; margin-top:-8px;  margin-bottom:-9px;">
                        <tr>
                        
                        <td><div style="width:130px;text-align:center;"><?php echo  $row_x['dis_name']; ?></div></td>
                        
                        <td><div style="width:188px;text-align:center;"><?php echo  $row_g['cust_name']; ?></div></td>
                        <td><div style="width:70px;text-align:center;"><?php echo  $row_f['bill_no']; ?></div></td>
                        <td><div style="width:70px;text-align:center;"><?php echo  $row_f['bill_date']; ?></div></td>
                        <td><div style="width:56px;text-align:center;"><?php echo  $row_f['quantity']; ?></div></td>
                        <td><div style="width:57px;text-align:center;"><?php echo  $row_f['sale_value']; ?></div></td>
                        <td><div style="width:74px;text-align:center;"><?php echo  $row_f['net_amount']; ?></div></td>
                        <td><div style="width:60px;text-align:center;"><?php echo  $row_f['replace_quantity']; ?></div></td>
                        <td><div style="width:60px;text-align:center;"><?php echo  $row_f['free_quantity']; ?></div></td>
                        </tr>
                        </table>
                       <?php
					   $tot=$tot+$row_f['net_amount'];
					   }
					   ?>
                        </td>
                        
                        
                        
                        
                        </tr></table>
                       
                       <?php
					   $tot1=$tot1+$tot;
					   }
					   ?>
                       </td>
                       
                       
                       </tr>
                       <tr><td colspan="14"><div  style="float:right;" ><span style="color:#0000FF; font-weight:bold;">Net Amount Total/Product:<?php echo $tot1; ?></span></div></td></tr>
                       <?php
					    $total=$total+$tot1;
					   }
					   ?>
                        <tr><td colspan="14"><div  style="float:right;" ><span style="color:#FF0000; font-size:16px; font-weight:bold;">Grand Total:<?php echo $total; ?></span></div></td></tr>
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
