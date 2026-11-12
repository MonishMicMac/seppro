<?php
include("include/connect.php");
// session_start();
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
function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
	$theta = $longitude1 - $longitude2;
	$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
   /* echo 'Miles ='.$miles;
	echo '<br>Nautical Miles : '.$nautical_miles = $miles * 0.868976;
	echo '<br>Kilometers : '.$kilometers = $miles * 1.609344;*/
	//return round($miles * 1609.34);
	return round($miles * 1.609344,2);
	/*echo '<br>Yards : '.$yards = number_format(($miles * 1760),4);
	echo '<br>Feet : '.$feet = number_format(($miles * 5280),4);
	echo '<br>inches : '.$inches = number_format(($miles * 63360),4);*/
}
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
	source: "autosearch-y/doctor_search.php",
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
dateFormat:"yy-mm-dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy-mm-dd"
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
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>MANAGER JOINT WORK REPORT</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        
        <table style="width:100%;">
            <tr>
            	<td><Label>Manager</label></td>
                <td>:</td>
                <td>
                	<div class="control-group">                    
                    <div class="controls">
                        <select name="mgr" id="mgr" data-rel="chosen"> 
                            <option value="">---select Manager---</option>
                            <?php
                            $SQL=mysql_query("SELECT * FROM representative WHERE rep_id>0 ORDER BY rep_name");
                            $co_mana=mysql_num_rows($SQL);
                            if($co_mana > 0)
                            {
                                while($row_ma=mysql_fetch_object($SQL))
                                { ?>
                               <option value="<?=$row_ma->id;?>"><?=$row_ma->rep_name;?></option>                   
                     <?php      }
                            }else
                            { ?>
                                <option value="">No Manager Avaliable</option>            
                    <?php   }
                            ?>
                        </select>
                        <script>document.getElementById("mgr").value="<?php echo @$_REQUEST["mgr"]; ?>";</script>
                    </div>
                </div>                
                </td>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="JOINT REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
             
        </table>
    </form>
</div>

<div class="box-content">
<?php if(@$_REQUEST["submit"]=="JOINT REPORT"){ ?>

<div style='float:right; width: 50px;'><a href="report_manager_jointwork_service_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&mgr=<?php echo @$_REQUEST["mgr"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<br/>
<br/>

   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    
    <?php	    
    
        $a=mysql_query("SELECT reporteddate,count(DISTINCT(repid)) as REP, count(clientid) as DR FROM reorting WHERE (reporteddate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND attendance = 1  GROUP BY reporteddate")or die(mysql_error());
    
        while($customer=mysql_fetch_object($a)){
		$i=1;		
    ?> 
    
    <?php
    
        $SQL=mysql_query("SELECT name as name,clinetcreation.latts as latitude,clinetcreation.longgs as longtitude,rep_name,reorting.reporteddate,reorting.reportedtime,reorting.drunavailablereason  FROM reorting,representative,clinetcreation WHERE reorting.reporteddate='".$customer->reporteddate."' AND reorting.attendance = 1 AND reorting.repid=representative.id AND reorting.clientid=clinetcreation.id "); 
   
        $CNT=mysql_num_rows($SQL); if($CNT>0){ ?>
    <tr>   
        <td colspan="11" style="background:#006535;color:#FFFFFF;text-align:center"><strong><?=date("d-m-Y",strtotime($customer->reporteddate)); ?></strong><span style="float:right;text-align:right"><?=" <span style=\"background:#FFFFFF;color:#006535;padding:3.5px;border:1px solid #FFFFFF;border-radius:3px\">REP : <strong>".$customer->REP."</strong></span> <span style=\"background:#FFFFFF;color:#006535;padding:3.5px;border:1px solid #FFFFFF;border-radius:3px\">DR : <strong>".$customer->DR."</strong></span>"; ?></span></td>    
    </tr>
    <tr><th>Sl.No</th><th>REP</th><th><?php echo $_SESSION["LABEL"]; ?> Name</th><th>Feedback</th><th>Reported Time</th></tr>
    
	<?php
    while($RS=mysql_fetch_object($SQL)){ ?>
    <tr>    	
    	<td align="center" style="text-align:center"><?php echo $i; ?></td><td><?=strtoupper($RS->rep_name); ?></td><td><?=strtoupper($RS->name); ?></td><td><?=$RS->drunavailablereason; ?></td><td><?=$RS->reportedtime; ?></td>
    </tr>               
       
    <?php $i++;}}}} ?>   
    
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
