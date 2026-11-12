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
            ini_set('upload_max_filesize', '20M');
            ini_set('post_max_size', '10M');
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 900);
                if(isset($_SESSION['wise']))
                {
                $wise=$_SESSION['wise'];
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
<?php include("include/header.php"); ?>
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
        <a href="overall_report.php"><img src="img/back.jpg" height="50" width="150" /></a>  
        <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i>Overall Report Result</h2>
        <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
        </div>
        <div class="box-content">
        <a  href="print.php" target="_blank"> <img src="img/print.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>
        <a href="#"> <img src="img/export.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
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
        $a=mysql_query("select DISTINCT pincode from  areawise_temp  where  bill_date>='$from_date' AND bill_date<='$to_date' and  m_id16='$m_id16' order by id desc");
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
        <td><?php echo $pincode_a; ?></td>
        <?php
        if($count_b=='0')
        {
        $b1=mysql_query("select * from  areawise_temp where pincode='$pincode_a'  and  m_id16='$m_id16'");
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
        <td><?php echo $row_b['area_name']; ?></td>
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
        <td <?php if($count_a6=='0') {  ?> style="color:#FF0000;" <?php }?>><?php echo $cust_name; ?></td>
        <td><?php echo ucwords($dis_name); ?></td>
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
        <td colspan="4"></td>
        <td <?php if($our_id=='') {  ?> style="color:#FF0000;" <?php }?>><?php echo ucwords($product_name); ?></td>
        <td><?php echo  $row_a4['bill_no']; ?></td>
        <td><?php echo $row_a4['bill_date']; ?></td>
        <td><?php echo $row_a4['quantity']; ?></td>
        <td><?php echo $row_a4['sale_value']; ?></td>
        <td><?php echo $row_a4['replace_quantity']; ?></td>
        <td><?php echo $row_a4['free_quantity']; ?></td>
        <td><?php echo $row_a4['net_amount']; ?></td>
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
        {
        ?>
        <tr><td colspan="12">No Records Found</td></tr>
        <?php
        }
        ?>   
        </tbody>
        </table>   
        <a href="overall_report.php"><img src="img/back.jpg" height="50" width="150" /></a>           
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
	<script src="js/fullcalendar.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
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