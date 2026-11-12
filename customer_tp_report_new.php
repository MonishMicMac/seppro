<?php
include("include/connect.php");
session_start();

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

if($_REQUEST['condition']=="chk_session"){
    if($_SESSION['success_msg']="Success"){
        echo "Success";
        $_SESSION['success_msg']="";
    } else {
        echo "Failed";
    }
    exit;
}
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
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Download & Upload Customer Report</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">

<br>
<div style="margin-left: 8%;background-color: rgba(255, 0, 0, 0.32);width: 70%;height: 37px;border-radius: 9px;" id="status_bar1" hidden>
    <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/loading_animate.gif" width="25" height="25"> &nbsp;Loading....</div>
</div>

<div style="margin-left: 8%;background-color: rgba(148, 222, 135, 0.79);width: 70%;height: 37px;border-radius: 9px;" id="status_bar2" hidden>
    <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/success-icon.png" width="25" height="25"> &nbsp;Mail has been sent successfully...</div>
</div>
<br>

<table style="width: 100%">
    <tr>
        <td>
            <form class="form-horizontal" action="javascript:void(0)" enctype="multipart/form-data" method="post" name="frm">
                <fieldset>
                    <div class="control-group"><label class="control-label" for="typeahead">Manager Name<span style="color:#FF0000;">*</span> </label>
                        <div class="controls">
                            <select id="mgr_id" name="mgr_id" data-rel="chosen" style="color:#0066FF" required>
                            <option value="">--Select--</option>
                            <?php
                            $res=mysql_query("SELECT * FROM representative WHERE rep_id>0");
                            while($row_res=mysql_fetch_array($res)){ ?>
                            <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                            <?php } ?> 
                            </select>
                        </div>
                    </div>

                    <div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
                    <div class="controls"><input type="text" name="from_date" id="from_date" readonly required></div></div>
                    <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report"></div>
                </fieldset>
            </form>
        </td>
    </tr>
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
    <script>
        $(function() {
            $('#from_date').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                // yearRange: '1980:' + new Date().getFullYear(),
                yearRange: '2015:2025',
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
        });

        $("#submit").click(function(){
            var date=$("#from_date").val();
            var mgr_id=$("#mgr_id").val();
            if(mgr_id==''){ alert("Please Select Manager") }
            if(date==''){ alert("Please Select Date"); }
            if(date!='' && mgr_id!=''){
                $.ajax({
                    url:"customer_tp_report_excel_att_new.php",
                    type:"post",
                    data:{ from_date:date,mgr_id:mgr_id,condition:"attendance" },
                    success: function(result){
                        if(result=="Loading"){
                            $("#status_bar1").show();
                            $("#status_bar2").hide();
                            myFunction();
                        }
                    }
                });
            }
        });

        function myFunction() {
            window.globalVar = setInterval(function(){
                $.ajax({
                    url:"customer_tp_report_new.php",
                    type:"post",
                    data:{ condition:"chk_session" },
                    success: function(result){
                        if(result=="Success"){
                            $("#status_bar1").hide();
                            $("#status_bar2").show();
                            myStopFunction();
                        }
                    }
                });
            }, 3000);
        }

        function myStopFunction() {
            clearInterval(globalVar);
        }
    </script>
    <style>
     .ui-datepicker-calendar {
       display: none;
     }
    </style>
</body>
</html>
<?php
}
?>
