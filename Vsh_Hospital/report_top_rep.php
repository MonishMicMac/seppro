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
<?php /*?><a href="report_productwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a><?php */?>
<div class="row-fluid sortable">        
<div class="box span12">
<div class="box-header well" data-original-title>
<h2>Top Rep Report </h2>
<div class="box-icon">

</div>
</div>


<div class="box-content">

<ul  class="list" style="list-style-type:none;">
<li>
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
        <td><Label>From Date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To Date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="submit" name="submit" value="Rep Report" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
    <tr>
            <td colspan="8" align="right" style="padding-right:89px">
                <?php if(@$_REQUEST["submit"]=="Rep Report"){ ?>
<a href="report_top_rep_pdf_2.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&state_id=<?php echo $_REQUEST["state_id"] ?>&division_id=<?php echo $_REQUEST["division_id"] ?>" target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_top_rep_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&state_id=<?php echo $_REQUEST["state_id"] ?>&division_id=<?php echo $_REQUEST["division_id"] ?>&product_name=<?php echo @$_REQUEST["product_name"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
<?php } ?>            
            </td>
            </tr>
</table>
</form>

    <?php   
    if(@$_REQUEST["submit"]=="Rep Report"){ 
        ?>

<?php 

        if(@$_REQUEST["state_id"]==''){ ?>
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
   <tr><th>Rank</th><th width="15%">REP NAME</th><th width="15%">State</th><th width="10%">No of covered Product</th><th width="20%">Covered Product</th></tr>
   <?php 
        $i=1;
		 
        //echo "SELECT rep_id,(SELECT rep_name FROM representative WHERE id=a.rep_id) as repname, state_id, COUNT(DISTINCT(`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,representative b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '2017/06/01' AND '2017/07/31') and a.rep_id!=0 GROUP BY rep_id ORDER BY PTS DESC";

if(@$_REQUEST["division_id"]!=""){
        $division_default = "and b.division_id='".$_REQUEST['division_id']."' ";
    } else {
      
            $division_default = "";
    }
    if(@$_REQUEST["state_id"]!=""){
        $state_default = "and b.state_id='".$_REQUEST['state_id']."' ";
    } else{
        $state_default="";
    }

 
        $a=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");                
        while($rep_report=mysql_fetch_array($a)){             
        ?>
         
            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $rep_report['repname']; ?></td>
            <td><?php 
            $state=mysql_query("SELECT * from master_state where state_id='".$rep_report['state_id']."'"); 
            $row_state=mysql_fetch_array($state);
            echo $row_state['state_name'];
            ?></td>
            <td><?php echo $rep_report['PROD']; ?></td>
       
                <td>                   
                     <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                   <th width="1%">Pro_Name</th><th width="1%">Qty</th><th width="1%">Pincode</th>
                    <?php 
                    $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$rep_report['rep_id']."' AND `our_product_id`!='' AND (`bill_date` BETWEEN '2017/06/01' AND '2017/07/31') GROUP BY `our_product_id`");
                    while ($pro_details=mysql_fetch_array($pro)) {
                       ?>

                        <tr>
                        <td><?php  echo $pro_details['proname'];?></td>
                        <td><?php  echo $pro_details['pro_qty'];?></td>
                        <td><?php  echo $pro_details['pro_pinid'];?></td>

                        </tr>
                        </td>  
                        </tr>
                      <?php } ?>
                    </table>
                   </td></tr>
             
        <?php  $i++; } ?>
        <?php 
    } 
    if(@$_REQUEST["state_id"]!='')
    { 
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">

<tr><th>Rank</th><th width="15%">REP NAME</th><th width="10%">No covered Product</th><th width="20%">covered Product</th></tr>
<?php 
        $i=1;  

if(@$_REQUEST["division_id"]!=""){
        $division_default = "and b.division_id='".$_REQUEST['division_id']."' ";
    } else {
      
            $division_default = "";
    }
    if(@$_REQUEST["state_id"]!=""){
        $state_default = "and a.state_id='".$_REQUEST['state_id']."' ";
    } else{
        $state_default="";
    }
        //echo "SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC";


        $a=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");                
        while($rep_report=mysql_fetch_array($a)){             
        ?>
         
            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $rep_report['repname']; ?></td>
            <td><?php echo $rep_report['PROD']; ?></td>
       
                <td>     <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                   <th width="1%">Pro_Name</th><th width="1%">Qty</th><th width="1%">Pincode</th>              
                     <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                   <th width="1%">Pro_Name</th><th width="1%">Qty</th><th width="1%">Pincode</th>
                    <?php 
                    $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$rep_report['rep_id']."' AND `our_product_id`!='' AND (`bill_date` BETWEEN '2017/06/01' AND '2017/07/31') GROUP BY `our_product_id`");
                    while ($pro_details=mysql_fetch_array($pro)) {
                       ?>

                        <tr>
                        <td><?php  echo $pro_details['proname'];?></td>
                        <td><?php  echo $pro_details['pro_qty'];?></td>
                        <td><?php  echo $pro_details['pro_pinid'];?></td>

                        </tr>
                        </td>  
                        </tr>
                      <?php } ?>
                    </table>
                   </td></tr>
             
        <?php  $i++; } ?>

<?php } ?>
</table>
</div>
</li>
</ul> 
</div>      
</div>
</div>
</div>
</div>

<hr>

<?php include("include/footer.php"); ?>

</div>
<!-- <script>
var options = {
    valueNames: [ 'name']
};

var hackerList = new List('hacker-list', options);
</script> -->
<script src="js/jsl.js" type="text/javascript"></script>
<script src="js/common.js" type="text/javascript"></script>
<script src="datepicker/calendar.js" type="text/javascript"></script>
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
}}
?>
