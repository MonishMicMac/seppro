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
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">

</head>

<body>
		<!-- topbar starts -->
	<?php include("include/header.php"); ?>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
		<?php include("include/menu.php"); ?>
			
			<noscript>
				<div class="alert alert-block span10">
					<!--<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>-->
				</div>
			</noscript>
			
<div id="content" class="span10">
<div class="row-fluid sortable">		
				
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Overall Report Result</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
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
                   <table class="table table-striped table-bordered bootstrap-datatable datatable">
                   <tr>
                   <th style="width:200px;">Product Name</th>
                   <th style="width:60px;">Pincode</th>
                   <th style="width:90px;">Area Name</th>
                   <th style="width:130px;">Rep Name</th>
                   <th style="width:130px;">Position</th>
                   <th style="width:130px;">Distributor</th>
                   <th style="width:200px;">Customer Name</th>
                   <th style="width:70px;">Bill Date</th>
                   <th style="width:70px;">Bill No</th>
                   <th style="width:60px;">Qnty</th>
                   <th style="width:70px;">Sale Value</th>
                   <th style="width:70px;">Net Amount</th>
                   <th style="width:60px;">Replace Qnty</th>
                   <th style="width:76px;">Free Qnty</th>
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
                   <td><div><?php echo $pro_name_i; ?></div></td>
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
                   <td><div style="width:60px;"><?php echo $row_j['pincode'];  ?></div></td>
                   <td><div style="width:90px;"><?php echo $row_k['area_name'];  ?></div></td>
                   <td><div style="width:130px;"><?php echo $row_o['rep_name'];  ?></div></td>
                   <td><div style="width:130px;"><?php echo $row_o['position'];  ?></td>
                   
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
                   <td><div style="width:130px;"><?php echo  $row_p['dis_name']; ?></div></td>
                   <td><div style="width:200px;"><?php echo  $row_m['cust_name']; ?></div></td>
                  <td><div style="width:70px;"><?php echo  $row_l['bill_no']; ?></div></td>
                   <td><div style="width:70px;"><?php echo  $row_l['bill_date']; ?></div></td>
                   <td><div style="width:60px;"><?php echo  $row_l['quantity']; ?></div></td>
                   <td><div style="width:70px;"><?php echo  $row_l['sale_value']; ?></div></td>
                   <td><div style="width:70px;"><?php echo  $row_l['net_amount']; ?></div></td>
                   <td><div style="width:60px;"><?php echo  $row_l['replace_quantity']; ?></div></td>
                   <td><div style="width:60px;"><?php echo  $row_l['free_quantity']; ?></div></td>
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
               
</div>

</div>

</div>
</div>
				
	
<?php include("include/footer.php"); ?>
		
	</div>           
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-alert.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	<script src="js/bootstrap-button.js"></script>
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-carousel.js"></script>
	<script src="js/bootstrap-typeahead.js"></script>
	<script src="js/bootstrap-tour.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src='js/fullcalendar.min.js'></script>
	<script src='js/jquery.dataTables.min.js'></script>
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<script src="js/jquery.chosen.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/jquery.colorbox.min.js"></script>
	<script src="js/jquery.cleditor.min.js"></script>
	<script src="js/jquery.noty.js"></script>
	<script src="js/jquery.elfinder.min.js"></script>
	<script src="js/jquery.raty.min.js"></script>
	<script src="js/jquery.iphone.toggle.js"></script>
	<script src="js/jquery.autogrow-textarea.js"></script>
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<script src="js/jquery.history.js"></script>
	<script src="js/charisma.js"></script>	
</body>
</html>
<?php
}

