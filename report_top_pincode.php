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
yearRange: "2015:2025",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
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



<?php
/*

                    if(@$_REQUEST["division_id"]!=""){
                        $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
                    } else {
                        if($_SESSION["division_id"]!="ALL")
                            $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
                        else 
                            $division_default = "";
                    }

                

                    if(@$_REQUEST["state"]) {
                        $state_check = "and a.state_id='".(@$_REQUEST["state"])."'";
                        $state_url = "&state_id=".(@$_REQUEST["state"]);
                    } else {

                        if($_SESSION["state_id"]!="ALL") {
                            $state_check = " and a.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                        } else {
                            $state_check = "";
                        }

                        $state_url = "";
                    }
*/

?>



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
<h2><i class="icon-user"></i>Top Pincode Report <span style="color:#FF0000;float:right;"> 
</h2>


 <table style="width:7	0%" align="right"><tr>
 <td style="vertical-align: top"> 

          </td>
          </tr>
          </table>
          </div>

  

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        
            <tr>
             <td>Division</td>
                <td>:</td>
                <td>
                    <select name="division_id" id="division_id" data-rel="chosen" >
                        <option value="">---Select---</option>
                        <?php $P=mysql_query("SELECT * FROM mst_division".(($_SESSION["division_id"]!="ALL")?(" where division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')"):"")." ORDER BY division_id"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->division_id; ?>"><?=$I->division_name; ?></option>
                        <?php } ?>
                    </select><script>document.getElementById("division_id").value="<?=$_REQUEST["division_id"] ?>";</script>
                </td>
            
            
                <td style="margin-left: -10%;">State</td>
                <td>:</td>
                <td>
                <select name="state_id" id="state_id"   data-rel="chosen" >
                <option value=""><?php echo (($_SESSION["state_id"]=="ALL")?"PAN India":"All") ?></option>
            <?php $SQL = mysql_query("SELECT * FROM master_state".(($_SESSION["state_id"]!="ALL")?(" where state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')"):"")." order by state_name"); while($STATE=mysql_fetch_object($SQL)){ ?>              
                <option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
                <?php } ?>
            </select>
                <script>document.getElementById("state_id").value="<?php echo (@$_REQUEST["state_id"]); ?>";</script></td>
            </tr>            
       </table>
        <table style="width:100%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>" required /></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="Top Pincode" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
            <tr>
            	<td colspan="8" align="right" style="padding-right:89px">
                	<?php if(@$_REQUEST["submit"]=="Top Pincode"){ ?>
                        <a href="report_top_pincode_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&state_id=<?php echo $_REQUEST["state_id"] ?>&division_id=<?php echo $_REQUEST["division_id"] ?>" target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_top_pincode_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&state_id=<?php echo $_REQUEST["state_id"] ?>&division_id=<?php echo $_REQUEST["division_id"] ?>" target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
                        <?php } ?>
                </td>           
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
   	<tr><th align="center" style="text-align:center">Pincode</th><th align="center" style="text-align:center">PTR</th><th align="center" style="text-align:center">PTS</th><th align="center" style="text-align:center">Sales Product Qty</th>
    <?php
        if(@$_REQUEST["submit"]=="Top Pincode"){	
  

     

if(@$_REQUEST["division_id"]!=""){
        $division_default = "and areawise_temp.division_id='".$_REQUEST['division_id']."' ";
    } else {
        // if($_SESSION["division_id"]!="ALL")
        //     $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
        // else 
            $division_default = "";
    }
    if(@$_REQUEST["state_id"]!=""){
        $state_default = "and areawise_temp.state_id='".$_REQUEST['state_id']."' ";
    } else{
        $state_default="";
    }
    //echo "SELECT areawise_temp.pincode AS PIN, round(SUM(areawise_temp.quantity*areawise_temp.ptr)) AS TOTPTR, round(SUM(areawise_temp.quantity*areawise_temp.pts)) AS TOTPTS,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_qty FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.pincode ORDER BY TOTPTR DESC LIMIT 10" ;


 $sqltp=mysql_query("SELECT areawise_temp.pincode AS PIN, round(SUM(areawise_temp.quantity*areawise_temp.ptr)) AS TOTPTR, round(SUM(areawise_temp.quantity*areawise_temp.pts)) AS TOTPTS,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_qty FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.pincode ORDER BY TOTPTR DESC LIMIT 10");


            while ($row_sqltp=mysql_fetch_array($sqltp)) {
        
                
    ?> 
    <tr>
        <td><?php echo $row_sqltp['PIN']; ?></td>
    	<td><?php echo $row_sqltp['TOTPTR']; ?></td>
        <td style="text-align:center;" align="center"><?php echo $row_sqltp['TOTPTS']; ?></td>
        <td style="text-align:center;" align="center"><?php echo $row_sqltp['cust_qty']; ?></td>
       
    </tr>
    <?php
	}	
	?>
    
    
    <?php } ?>   
    
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

function state(state){
  if(state)
    document.location = "report_distributor_individual.php?state="+state;
  else
    document.location = "report_distributor_individual.php";
}

</script>

</body>
</html>
<?php
}
?>