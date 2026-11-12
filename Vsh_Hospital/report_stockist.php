<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
session_start();
//error_reporting(0);
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
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/rep_search.php",
	minLength: 2,
	select: function(event, ui) {
	var getUrl = ui.item.id;
	if(getUrl != '#') {
	location.href = getUrl;
	}
	},
	
	html: true, 
	
	open: function(event, ui) {
	$(".ui-autocomplete").css("z-index", 1000);
	}
	});
	
	});
	</script>	
    
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
//ajax Starts
$("#search_box").keypress(function(){
    var from_date =$("#from_date").val();
    var to_date    =$("#to_date").val();
    var content =$("#search_box").val();
    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
    $.get(url,function(data,status){
        $("#search").html(data);
    });
});
//ajax Ends
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

<div class="row-fluid">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Stockist Report<span style="color:#FF0000;margin-left:200px;"> 

</span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>Stockist</td>
                <td>:</td>
                <td>
                	<select name="stockist" id="stockist" data-rel="chosen" required>
                        <option value="">---Select---</option>
                        <?php $P=mysql_query("SELECT dis_id, dis_name FROM distributor ORDER BY dis_name"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->dis_id ?>"><?=$I->dis_name ?></option>
                        <?php } ?>
                    </select><script>document.getElementById("stockist").value="<?=$_REQUEST["stockist"] ?>";</script>
                </td>
            </tr>            
           
        </table>
        
        <table style="width:100%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="STOCKIST REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
        </table>
        
        <table style="width:100%;">
            <tr>
                <!-- <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td></td> -->
            </tr>
            <tr>
            <td colspan="8" align="right" style="padding-right:89px">
            	<?php if(@$_REQUEST["submit"]=="STOCKIST REPORT"){ ?>
<a href="report_repwise_individual_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&stockist=<?php echo @$_REQUEST["stockist"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_stockist_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&stockist=<?php echo @$_REQUEST["stockist"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
<?php } ?>            
			</td>
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable">
<thead>
    <th>Pincode</th>
    <th>Chemist Name</th>
    <th>Representative</th>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Free</th>
    <th>Replace</th>
    <th>PTR Value</th>
</thead>
<tbody>
    <?php			
if(@$_REQUEST["submit"]=="STOCKIST REPORT") :
		
    $cust_mst = mysql_query("SELECT b.pincode as pincode, a.pin_id as pin_id FROM `areawise_temp` a left join pincode_list b on a.pin_id=b.pin_id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id !=0 and a.pin_id !='' GROUP BY a.pin_id");
    while($cust_row = mysql_fetch_array($cust_mst)) :
 
        $pin_code = $cust_row['pincode'];
        $pin_id = $cust_row['pin_id'];
        $count_pin = 0;
        $count_shop = array();
        $shop_array = array();
        $rep_array = array();
        $product_array = array();
        $quantity_array = array();
        $free_array = array();
        $replace_array = array();
        $ptr_array = array();
        $did_array = array();
        $j = 0;
        
        $cust_mst1 = mysql_query("SELECT b.shop_name as shop_name, a.our_cust_id as cust_id, case when a.rep_id =0 then 'VACANT' else c.rep_name end as rep_name FROM `areawise_temp` a left join tbl_customer_master b on a.our_cust_id=b.id left join representative c on a.rep_id=c.id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id ='".$pin_id."' GROUP BY a.our_cust_id");
        if(mysql_num_rows($cust_mst1)>0) :
          while($cust_row1 = mysql_fetch_array($cust_mst1)) :
            $shop_array[] =$cust_row1['shop_name'];
            $rep_array[] =$cust_row1['rep_name'];

            
            $dist_cust2 = mysql_query("SELECT b.pro_name as product_name, sum(a.quantity) as quantity, sum(a.free_quantity) as free, sum(a.replace_quantity) as `replace`, a.ptr FROM `areawise_temp` a left join product b on a.our_product_id=b.id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id ='".$pin_id."' and a.our_cust_id='".$cust_row1['cust_id']."' GROUP BY a.our_product_id");
            $count_shop[$j] = 0;
            if(mysql_num_rows($dist_cust2)>0) :
              while($distrow=mysql_fetch_array($dist_cust2)) :
                $product_array[$j][] = $distrow['product_name'];
                $quantity_array[$j][] = $distrow['quantity'];
                $free_array[$j][] = $distrow['free'];
                $replace_array[$j][] = $distrow['replace'];
                $ptr_array[$j][] = (double)$distrow['ptr']*(int)$distrow['quantity'];

                $count_pin++;
                $count_shop[$j]++;
              endwhile;
            else :
              $product_array[$j][] = '';
              $quantity_array[$j][] = '';
              $free_array[$j][] = '';
              $replace_array[$j][] = '';
              $ptr_array[$j][] = '';

              $count_pin++;
              $count_shop[$j]++;
            endif;
            $j++;
          endwhile;
        else :
          $shop_array[] ='';
          $rep_array[] ='';
          $product_array[$j][] = '';
          $quantity_array[$j][] = '';
          $free_array[$j][] = '';
          $replace_array[$j][] = '';
          $ptr_array[$j][] = '';

          $count_pin++;
          $count_shop[$j]++;
          $j++;

        endif;

        echo "<tr><td rowspan='".(($count_pin=='0')?1:$count_pin)."'>".$pin_code."</td>";
        for ($i=0; $i < count($shop_array); $i++) :
          if($rep_array[$i] == "VACANT") :
            $vacant = "style='background:rgba(255, 0, 0, 0.39);'";
          else :
            $vacant = '';
          endif;
          if($i == 0) :
            echo "<td ".$vacant." rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td><td ".$vacant." rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$rep_array[$i]."</td>";
          else :
            echo "<tr><td ".$vacant." rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td><td ".$vacant." rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$rep_array[$i]."</td>";
          endif;

          for ($o=0; $o < $count_shop[$i]; $o++) :
            if($o == 0) :
              echo "<td ".$vacant." >".$product_array[$i][$o]."</td><td ".$vacant." >".$quantity_array[$i][$o]."</td><td ".$vacant." >".$free_array[$i][$o]."</td><td ".$vacant." >".$replace_array[$i][$o]."</td><td ".$vacant." >".$ptr_array[$i][$o]."</td></tr>";
            else :
              echo "<tr><td ".$vacant." >".$product_array[$i][$o]."</td><td ".$vacant." >".$quantity_array[$i][$o]."</td><td ".$vacant." >".$free_array[$i][$o]."</td><td ".$vacant." >".$replace_array[$i][$o]."</td><td ".$vacant." >".$ptr_array[$i][$o]."</td></tr>";
            endif;

          endfor;
        endfor;
    endwhile;
endif; ?>   
    
</tbody>
</table>
</div>        
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
<script type="text/javascript">
$(document).ready(function() {
$('#example').dataTable();
});
</script>
</body>
</html>
<?php
}
?>
