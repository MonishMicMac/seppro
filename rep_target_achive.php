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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {

    $('#from_date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
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
<style>
 .ui-datepicker-calendar {
   display: none;
 }
</style>

	
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
<h2><i class="icon-user"></i>Target Achievement</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">
    	<table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td>Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen" required>
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
				<?php } ?>
                <td><Label>Month &amp; Year</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly required/></td>
                </tr>
                <tr>
                	<td><Label>Amount</label></td>
                <td>:</td>
                <td><input type="text" name="amount" id="amount" required /></td>
              
                <td></td>
            </tr>
        </table>
    </form>
</div><br>
<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated1"></div> 
 <hr style="border:1px solid #317eac;height: 0px;">
<center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Approved" style="background-color: #2fb87a;border-color: #2fb87a;" /></a><input type="reset" class="btn" value="Cancel" /></div>
</center>




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
$('#rep_name').change(function(){  
    $.post("autosearch-y/rep_reporting_booking.php?custometlisttarget=yuvi&rep="+$('#rep_name').val()+"",function(data){
            // alert(data);
            $("#consolidated1").html(data);
        }); 
     
});
$('#qasave').click(function(){	
	  // alert('1');
               var numbers = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val());                
              }); 
              var repidname=$('#rep_name').val();              
              var fromdate=$('#from_date').val();              
              var amounttar=$('#amount').val();
              // alert(fromdate);
            // alert(repidname);
            // alert(fromdate);
            // alert(monthtar);
            // alert(amounttar);
            // $.post("autosearch-y/rep_reporting_booking.php?targetachieve=yuvi&clientid="+numbers+"&repidname="+repidname+"&yeartar="+yeartar+"
            //     &monthtar="+monthtar+"&amounttar="+amounttar+"",function(data){
            //         alert(data);
            // });
if(!repidname=="")
{
    if(fromdate)
{
    if(!amounttar=="")
{
    if(!numbers=="")
{
    // alert('3');
              	$.post("autosearch-y/rep_reporting_booking.php",{clientid:numbers,repidname:repidname,fromdate:fromdate,amounttar:amounttar}, function( data ) {
                    // alert(data);
 alert("Achievement Report Successfully");
        $.post("autosearch-y/rep_reporting_booking.php?custometlisttarget=yuvi&rep="+repidname+"",function(data){
            // alert(data);
            $("#consolidated1").html(data);
//alert("Achievement1 Report Successfully");
        });
    }); 
            
              }
              else
              {
                alert("Select checkbox"); 
              }
              }
              else
              {
                alert("Enter Amount");  
              }
              }
              else
              {
                alert("Select Date");
              }
}
else
{
    
        alert("Select Rep Name");

    

}
// window.location.href="rep_target_archive_excel.php?clientid="+numbers+"&repidname="+repidname+"&yeartar="+yeartar+"&monthtar="+monthtar+"&amounttar="+amounttar;	

});
	
</script>
</body>
</html>
<?php
}
?>
