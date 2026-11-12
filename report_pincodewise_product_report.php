<?php
include("include/connect.php");
session_start();
error_reporting(0);
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
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
	source: "autosearch-y/pincode_search.php",
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

<div class="row-fluid sortable">		
<div class="box span12">
<?php ?>
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Pincode wise Product Report</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>Representative</td>
                <td>:</td>
                <td>
                    <select name="rep" id="rep" data-rel="chosen" required>
                        <option value="">---Select---</option>
                        <?php $P=mysql_query("SELECT * FROM representative ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
                        <?php } ?>
                    </select><script>document.getElementById("rep").value="<?=$_REQUEST["rep"] ?>";</script>
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
                <td><input type="submit" name="submit" value="PINCODE REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
             <tr align="right">
            	<td align="right" colspan="8" style="padding-right:80px;">
                
                <?php if($_REQUEST["rep"]!=""){ ?>
                <a href="report_pincodewise_product_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["rep"]; ?> " target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                <?php } ?>
                
                </td>
             </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
    if(@$_REQUEST["submit"]=="PINCODE REPORT"){

        $sql1=mysql_query("SELECT pincode FROM areawise_temp WHERE rep_id='".$_REQUEST['rep']."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY pincode");
        echo "<tr><th>Product \ Pincode</th>";
        while($row1=mysql_fetch_array($sql1)){ echo "<th>".$row1['pincode']."</th>"; }
        echo "</tr>";

        $sql=mysql_query("SELECT id,pro_name FROM product WHERE pro_name!='' ORDER BY pro_name")or die(mysql_error());
        while($row=mysql_fetch_array($sql)){
            echo "<tr><td style='background:#FDEAE0;''>".$row['pro_name']."</td>";
            $sql2=mysql_query("SELECT pincode FROM areawise_temp WHERE rep_id='".$_REQUEST['rep']."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY pincode");
            while($row2=mysql_fetch_array($sql2)){
                $sql3=mysql_query("SELECT SUM(quantity) as qty FROM areawise_temp WHERE rep_id='".$_REQUEST['rep']."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_product_id='".$row['id']."' AND pincode='".$row2['pincode']."' GROUP BY pincode,our_product_id");
                $row3=mysql_fetch_array($sql3);
                if($row3['qty']==''){ $qty='0'; } else { $qty=$row3['qty']; }
                echo "<td>".$qty."</td>";
            }
            echo "</tr>";
        } 
    }
    ?>   
    
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
