<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

if(@$_REQUEST['submit']=='Update'){
    $rep_id=$_REQUEST['rep_id'];
    $doc_id=$_REQUEST['doc_id'];

    foreach ($doc_id as $doc) {
        mysql_query("UPDATE doctors SET rep_assign='$rep_id',rep_id='$rep_id' WHERE id='$doc'");
    }
    header('location:doctor_rep_shared_mapping.php?rep_name='.$_REQUEST['rep_name'].'&pin_id='.$_REQUEST['pin_id']);
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
    
<script type="text/javascript">
    function valid1()
    {
    var x=document.getElementById("rep_id").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Representative Name");
    return false; 
    }
    return true;
    }

    function valid2()
    {
    var x=document.getElementById("rep_id1").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Representative Name");
    return false; 
    }
    return true;
    }
</script>

    
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
<h2><i class="icon-edit"></i>Rep & HQ Mapping For Shared Pincode <a href="doctor_rep_mapping.php?rep_id=<?php echo @$_REQUEST["rep_name"]; ?>" style="margin-left:700px;" class="btn btn-primary">Back</a></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<?php if(@$_REQUEST['pin_id']!=''){ ?>
<form method="post" action="">
    <table style="width: 40%">
        <tr>
            <td><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label></td>
            <td>
                <div class="control-group">
                    <div class="controls">
                        <select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" required>
                        <option value="">--Select--</option>
                        <?php
                        $pin_id=$_REQUEST['pin_id'];
                        $res=mysql_query("SELECT * FROM representative WHERE id IN (select rep_id from rep_area where pin_id='$pin_id')");
                        while($row_res=mysql_fetch_array($res)){ ?>
                        <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                        <?php } ?> 
                        </select>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <br>

    <input type="hidden" name="pin_id" value="<?php echo @$_REQUEST["pin_id"]; ?>">
    <input type="hidden" name="rep_name" value="<?php echo @$_REQUEST["rep_name"]; ?>">

    <table id="example" class="table table-striped table-bordered" width="100%">
    <thead>
    <tr>
        <th style="text-align:center"><input type="checkbox" id="select_all">SELECT ALL</th>
        <th style="text-align:center">DOCTOR</th>
        <th style="text-align:center">REPRESENTATIVE</th>
    </tr>
    </thead>   
    <tbody>
    <?php
        $sql2=mysql_query("SELECT id,doctor_name,rep_assign,(select rep_name from representative where id=doctors.rep_assign) as rep_name FROM doctors WHERE doc_pin_id='$pin_id'");
        while($row2=mysql_fetch_object($sql2)){ ?>
            <tr>
                <td style="text-align:center"><input type="checkbox" name="doc_id[]" class="select_show" value="<?php echo $row2->id; ?>"></td>
                <td style="text-align:center"><?php echo $row2->doctor_name; ?></td>
                <td style="text-align:center"><?php echo $row2->rep_name; ?></td>
            </tr>
    <?php $p++;} ?>
    </tbody>
    </table>

    <input type="submit" name="submit" value="Update" class="btn btn-primary" style="float: right;">
</form>

<br><br>
<?php } ?>
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
            $('#from_date,#from_date1').datepicker({
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
        });
        $("#sales_update").click(function(){
            if($(this).prop('checked')==true){
                $("#show_bs_all").removeAttr("hidden");
            } else {
                $("#show_bs_all").attr("hidden",true);
            }
        });

        $("#use_all").click(function(){
            $("#show_bs").attr("hidden",true);
        });

        $("#use_bs").click(function(){
            $("#show_bs").attr("hidden",false);
        });

        $("#select_all").click(function(){
            if($(this).prop('checked')==true){
                $(".select_show").attr("checked",true);
                $(".select_show").parent().attr("class","checked");
            } else {
                $(".select_show").attr("checked",false);
                $(".select_show").parent().attr("class","");
            }
        });
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
$_SESSION['upload_msg']='';
?>
