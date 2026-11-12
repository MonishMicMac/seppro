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
                    
                    </table>
						<table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:1px solid;width:800px;">
						<tbody>
                        <tr>
<th style="text-align:center;">Pincode</th>
<th style="text-align:center;">Area Name</th>
<th style="width:197px;text-align:center;">Representative Name</th>
<th style="width:192px;text-align:center;">Pharmacy Name</th>
<th style="width:125px;text-align:center;">Distributor Name</th>
<th style="width:192px;text-align:center;">Product Name</th>
<th style="width:86px;text-align:center;">Bill Number</th>
<th style="width:57px;text-align:center;">Bill Date</th>
<th style="width:58px;text-align:center;">Qnty</th>
<th style="width:52px;text-align:center;">Sale Value</th>
<th style="width:68px;text-align:center;">Net Amount</th>
<th style="width:68px;text-align:center;">Rpl qnty</th>
<th style="width:68px;text-align:center;">free qnty</th>
</tr>
                       <?php
					   $total1=0;
					   /*  bill_string>='$from_string' AND bill_string<='$to_string'*/
					   //echo "select * from  areawise_temp where  bill_string>='$from_string' AND bill_string<='$to_string'";
					   $z=mysql_query("select * from  rep_area where rep_id='$rep_id'");
					   while($row_z=mysql_fetch_array($z))
					   {
					   $area_id=$row_z['area_id'];
					   $y=mysql_query("select * from  pincode_list where id='$area_id'");
					   $row_y=mysql_fetch_array($y);
					   $pincode=$row_y['pincode'];
					   $a=mysql_query("select DISTINCT pincode from  areawise_temp where pincode='$pincode'  order by id desc");
					   $total=0;
					   $count_a=mysql_num_rows($a);
					   if($count_a>0)
					   {
					  // echo $count_a;
					   while($row_a=mysql_fetch_array($a))
					   {
					   $pincode_a=$row_a['pincode'];
					    $b=mysql_query("select * from  pincode_list where pincode='$pincode_a'");
						$row_b=mysql_fetch_array($b);
						$b_id=$row_b['id'];
						//echo "select * from  rep_area where area_id='$b_id'";
						
					   ?>
                       <tr>
                       <td  style="width:200px;text-align:center;"><?php echo $pincode_a; ?></td>
                       <td  style="width:200px;text-align:center;"><?php echo $row_b['area_name']; ?></td>
                       <td  style="width:200px;text-align:center;">
                       <?php
					   //echo "select * from  rep_area where area_id='$b_id'";
                       $g=mysql_query("select * from  rep_area where area_id='$b_id'");
						while($row_g=mysql_fetch_array($g))
						{
						$rep_id_g=$row_g['rep_id'];
						$h=mysql_query("select * from representative where rep_id='$rep_id_g'");	
						$row_h=mysql_fetch_array($h);			 
						echo $row_h['rep_name'];
						?><br>

                        <?php
						}
                        ?>
                        </td>
                       <td colspan="11"  style="width:800px;text-align:center;">
					   <?php
					   $tot1=0;
					    $c=mysql_query("select DISTINCT cust_id  from  areawise_temp where pincode='$pincode_a' and bill_string>='$from_string' AND bill_string<='$to_string'");
					  while($row_c=mysql_fetch_array($c))
					   {
					   $cud_id=$row_c['cust_id'];
						 $d=mysql_query("select * from  customer where dc_id='$cud_id'");
						$row_d=mysql_fetch_array($d);
					   ?>
					   <table style="margin-left:-9px;"><tr><td style="width:135px;text-align:center;">
					   <div style="width:200px;"><?php echo $row_d['cust_name']; ?></div>
                       </td>
                       <td>
                       <table style="margin-left:-9px; margin-top:-16px; width:600px;">
                     <?php
					 $tot=0;
					  $e=mysql_query("select  *  from  areawise_temp where cust_id='$cud_id' and bill_string>='$from_string' AND bill_string<='$to_string'");
					  while($row_e=mysql_fetch_array($e))
					   {
					   $dist_id__e=$row_e['dist_id'];
					   $r=mysql_query("select  *  from  distributor where dis_id='$dist_id__e'");
					  $row_r=mysql_fetch_array($r);
					   ?>
                       <tr>
                       
                       <td style="width:83px;"><div style="width:130px;text-align:center;"><?php echo $row_r['dis_name']; ?></div></td>
                       
                       <td style="width:83px;"><div style="width:200px;text-align:center;"><?php echo $row_e['pro_name']; ?></div></td>
                       <td style="width:150px;"><div style="width:90px;text-align:center;"><?php echo $row_e['bill_no']; ?></div></td>
                       <td style="width:150px;"><div style="width:60px;text-align:center;"><?php echo $row_e['bill_date']; ?></div></td>
                       <td style="width:150px;"><div style="width:60px;text-align:center;"><?php echo $row_e['quantity']; ?></div></td>
                       <td style="width:150px;"><div style="width:55px;text-align:center;"><?php echo $row_e['sale_value']; ?></div></td>
                       <td style="width:150px;"><div style="width:73px;text-align:center;"><?php echo $row_e['net_amount']; ?></div></td>
                        <td style="width:150px;"><div style="width:71px;text-align:center;"><?php echo $row_e['replace_quantity']; ?></div></td>
                         <td style="width:150px;"><div style="width:55px;text-align:center;"><?php echo $row_e['free_quantity']; ?></div></td>
                      <?php
					   $tot=$tot+$row_e['net_amount'];
                      ?>
					   </tr>
                       <?php
					   }
					   ?>
                        <tr><td colspan="11"><div style="float:right;"><span style="color:#0000FF; font-weight:bold; font-size:14px;">Net Amount Total/Pharmacy:<?php echo $tot; ?></span></div></td></tr> 
                       </table></td>
                      
                       
                       </tr>
                     <?php
					   $tot1=$tot1+$tot;
                      ?>
                       </table>
					   <?php
					   }
					    ?>
                       </td>
                       </tr>
                       <tr><td></td><td colspan="12"><div style="float:right;"><span style="color:#0000FF; font-weight:bold; font-size:14px;">Net Amount Total/Area: <?php echo $tot1; ?></span></div></td></tr>
                        <?php
					   $total=$total+$tot1;
                      ?>
                       <?php
					   }
					  ?> 
					    
					   <?php
					   }
					   
					   $total1=$total1+$total;
					   }
					   ?><tr><td></td><td colspan="13"><div style="float:right;"><span style="color:#FF0000; font-weight:bold; font-size:16px;">Grand Total: <?php echo $total1; ?></span></div></td></tr>
					      
                          
						  
                          
                          </tbody>
					  </table>            
					
</body>
</html>
<?php
}
?>
