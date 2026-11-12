<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
include("include/select.php");
$fun = new select1;
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
		$(function() {		
		$("<?php $a=mysql_query("SELECT * FROM distributor_customer ORDER BY id")or die(mysql_error()); while($row_a=mysql_fetch_array($a)){echo $our_id = "#Y".$row_a['id'].",";} echo substr($our_id,0,-1);?>").autocomplete({
		
		source: "autosearch-y/global_search.php",
		minLength: 2,
		select: function(event, ui) {
		var getUrl = ui.item.id; // OUR CUSTOMER ID
	    var id = $(this).attr('id'); // AREAWISE TEMP - DISTRIBUTOER CUSTOMER ID
		$.post("autosearch-y/yuvaraj_great.php?our_cust_id="+getUrl+"&dist_cust_id="+id+"", {our_cust_id: getUrl}, function(data){
		alert(data);
		});
		//location.href = "autosearch-y/yuvaraj_great.php?our_cust_id="+getUrl+"&dist_cust_id="+id;	
		},
		
		html: true, 
		
		open: function(event, ui) {
		$(".ui-autocomplete").css("z-index", 1000);
		}
		});
		
		});
	</script>
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
</div>
</noscript>

<div id="content" class="span10">

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Distributor Product Mapping with Division Product</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">

	<?php
		//if(@$_REQUEST["submit"]=="CUSTOMER REPORT"){ (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND
		$a=mysql_query("SELECT areawise_temp.pincode, areawise_temp.net_amount,areawise_temp.bill_date, pincode_list.pincode, pincode_list.area_name, areawise_temp.our_cust_id, master_district.district_id,  master_district.district_name, pincode_list.dist_id FROM areawise_temp,pincode_list,master_district WHERE areawise_temp.pincode=pincode_list.pincode AND master_district.district_id= pincode_list.dist_id AND areawise_temp.our_cust_id 	!= '' GROUP BY areawise_temp.pincode ORDER BY areawise_temp.id ")or die(mysql_error());
		while($customer=mysql_fetch_object($a)){ 
	?> 
	<tr id="<?php echo "#Y".$customer->pincode;?>"><td style="background:#FDEAE0;"><?=$customer->pincode;?></td><td style="background:#FDEAE0;"><?=$customer->area_name." | ".$customer->district_name;?></td><td style="background:#FDEAE0;"><?php $c1=mysql_query("SELECT SUM(net_amount) AS NETAT  FROM areawise_temp WHERE  pincode='".$customer->pincode."'"); while($customers1=mysql_fetch_object($c1)){?>
                   <strong>Area Total Sales: <?php echo round($customers1->NETAT,2);?></strong>                                      
                    </td>                   
                    </tr>
					
					<?php } ?>
       
    <tr>
    	<td colspan="3">
		<table class="table table-striped table-bordered bootstrap-datatable datatable">
		<?php $b=mysql_query("SELECT DISTINCT(cust_name) AS CNAME, area_name AS ANAME   FROM areawise_temp WHERE  pincode=".$customer->pincode.""); while($customer1=mysql_fetch_object($b)){?>
       		<tr>
                <td style="background:#C6E2FF"><?=$customer1->CNAME;?></td>
                <td style="background:#C6E2FF"><?=$customer1->ANAME;?></td>
                <td style="background:#C6E2FF">                	
                	<?php $b2=mysql_query("SELECT SUM(net_amount) AS NETAMT  FROM areawise_temp WHERE  cust_name='".$customer1->CNAME."'"); while($customer2=mysql_fetch_object($b2)){?>
                   <strong>Total Sales: <?=round($customer2->NETAMT,2);?></strong>                   
                    <?php } ?>                   
                </td>                
            </tr>
            
            <tr>
            	<td colspan="3">
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<tr><td>Product Name</td></tr>
                    	<?php $b3=mysql_query("SELECT DISTINCT(pro_name) FROM areawise_temp WHERE  cust_name='".$customer1->CNAME."'"); while($customer3=mysql_fetch_object($b3)){?>
                    	<tr>
                        	<td style="color:#3399CC; background:#eaeaea"><?=$customer3->pro_name;?></td>
                            <td>
                            	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                            	<tr><td style="background:#FFE4B5">Distributor Name</td><td style="background:#FFE4B5">Doctor Type</td><td style="background:#FFE4B5">Quantity</td><td style="background:#FFE4B5">Free Quantity</td><td style="background:#FFE4B5">Replace Quantity</td><td style="background:#FFE4B5">Sale Value</td><td style="background:#FFE4B5">Net Amount</td></tr>
                                <?php $b4=mysql_query("SELECT dist_id, SUM(quantity) AS QTY,SUM(free_quantity) AS FQTY,SUM(replace_quantity) AS RQTY,SUM(sale_value) AS SV,SUM(net_amount) AS NAMT  FROM areawise_temp WHERE cust_name='".$customer1->CNAME."' AND  pro_name='".$customer3->pro_name."' GROUP BY '".$customer3->pro_name."'"); while($customer4=mysql_fetch_object($b4)){?>
                    	<tr><td><?php $sql1 = mysql_query("SELECT dis_name FROM distributor WHERE dis_id =".$customer4->dist_id.""); $r1=mysql_fetch_object($sql1); echo $r1->dis_name; ?></td><td><?php $sql11 = mysql_query("SELECT * FROM tbl_customer_master WHERE customer_name ='".$customer1->CNAME."'"); $r11=mysql_fetch_object($sql11); if($r11->customer_type==0){ echo "Floating";} if($r11->customer_type==1){ echo "Doctor Attached";} if($r11->customer_type==2){ echo "Multiple Doctor";} if($r11->customer_type==3){ echo "Clinic";}?></td><td><?=$customer4->QTY;?></td><td><?=$customer4->FQTY;?></td><td><?=$customer4->RQTY;?></td><td><?=round($customer4->SV,2);?></td><td><?=round($customer4->NAMT,2);?></td></tr>
                        <?php $subtotal = 0; $subtotal=$subtotal+$customer4->NAMT; ?>
                        <tr style="color:#000000; font-weight:bold"><td colspan="6" style="background:#BDFCC9;">Sub Total</td><td colspan="1" style="background:#BDFCC9;"><?=round($subtotal,2);?></td></tr>                         
                        <?php } ?>
                                </table>
                            </td>
                       </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>            
            
        <?php } ?>
        </table>
        </td>
    </tr>	
	<?php } //} ?>    
</table>             
</div>
</div>
</div>
</div>
</div>
<hr>

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
?>
