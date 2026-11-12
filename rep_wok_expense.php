<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
session_start();
//error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if($_SESSION['repid']!='')
{
$repmgrid = " AND id IN (".$_SESSION['repid'].")";
}
else
{
    $repmgrid="";
}
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
<h2><i class="icon-user"></i>Representative (INDIVIDUAL) Expenses<span style="color:#FF0000;margin-left:200px;"> 
<?php 
	if(@$_REQUEST["submit"]=="EXPENSE REPORT"){
			$rep = explode("-",$_REQUEST["rep"]);	
			$rep_sqls=mysql_query("SELECT id FROM representative WHERE mobile = '".$rep[1]."' AND rep_name= '".$rep[0]."'");
			$r=mysql_fetch_object($rep_sqls);
			
			
	}
?></span></h2>

<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
              	<td style="width:10%;">Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen">
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative WHERE 1 ".$repmgrid."");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
            	<?php /*?><td>Representative</td>
                <td>:</td>
                <td>
                	<input id="dd_user_input" type="text" name="rep" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["rep"]!=""){ ?>value="<?php echo @$_REQUEST["rep"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
                </td><?php */?>
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
                <td><input type="submit" name="submit" value="EXPENSE REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>

   <?php	
	if(@$_REQUEST["submit"]=="EXPENSE REPORT"){	

		
		?>
 <div style='float:right; width: 50px;'><a href="rep_wok_expense_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
 <div class="box-content">
 	<h2>EXPENSE REPORT</h2>
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">

	
        <tr>
        	<th style="text-align:center">#</th>
        	<th style="text-align:center">Date</th>
        	<th style="text-align:center">Day</th>
        	<th style="text-align:center">Calls</th>
        	<th style="text-align:center">ALLOWANCE</th>
        	<!-- <th style="text-align:center">ALLOWANCE</th> -->
        </tr>
        <?php
        $i=1;
        $allown1=0;
        $Daysperiod=mysql_query("select * from 
				(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
				 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
				 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
				 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
				 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
				 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
				where selected_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ");
while($D=mysql_fetch_object($Daysperiod)){ 
		// echo "SELECT count(*) AS totcall FROM tbl_work_plan WHERE wp_date = '".date("Y-m-d",strtotime($D->selected_date))."' AND wp_rep_id = '".$r->id."'  AND attendancestatus='1'  AND wp_dc='D'  ";
		$a = mysql_query("SELECT count(*) AS totcall FROM tbl_work_plan WHERE wp_date = '".date("Y-m-d",strtotime($D->selected_date))."' AND wp_rep_id = '".$_REQUEST["rep_name"]."'  AND attendancestatus='1'  AND wp_dc='D'  ");	
		// $CNT = mysql_num_rows($a);
		// echo mysql_error();	
		$row=mysql_fetch_object($a);
		// 	$kms=$kms+$row->kms;
		// 	$fare=$fare+$row->fare;
		// 	$amt=$amt+$row->amt;
		?>
        <tr>
        	<td align="center" style="text-align:center"><?=$i; ?></td>
        	<td align="center" style="text-align:center"><?=$D->selected_date; ?></td>
        	<td align="center" style="text-align:center"><?=date('l', strtotime($D->selected_date)); ?></td>
        	<td align="center" style="text-align:center"><?=$row->totcall; ?></td>
        	<td align="center" style="text-align:center"><?php if($row->totcall > 6) { echo $allown="150"; } if($row->totcall ==6) { echo $allown="150"; } if($row->totcall < 6) { echo $allown="0"; } ?></td>
        	<!-- <td align="center" style="text-align:center"><?=$row->amt; ?></td> -->
        </tr>
		<?php
			$i++;
			$allown1=$allown1+$allown;
			 // } 
			  } 
			 ?>
        <tr><td colspan="2" style="background:#99FFFF;"><?php echo "<strong>TOTAL</strong>"; ?></td><td style="background:#99FFFF;text-align:center"></td><td style="background:#99FFFF;text-align:center"></td><td style="background:#99FFFF;text-align:center"><?=$allown1; ?></td></tr>
        
        
        <?php
    }?>
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
