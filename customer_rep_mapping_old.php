<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

if(@$_REQUEST['submit']=='Update'){
    //$hq_id=$_REQUEST['hq_id'];
    $rep_id=$_REQUEST['rep_id'];
    $pin_id=$_REQUEST['pin_id'];
    if(@$_REQUEST['sales_update']=='yes'){
        if(@$_REQUEST['status']=='use_all'){
            foreach ($pin_id as $pin) {
                mysql_query("UPDATE areawise_temp SET rep_id='$rep_id' WHERE pin_id='$pin'");
            }
        } elseif(@$_REQUEST['status']=='use_bs') {
            $bill_string=$_REQUEST['bill_string'];
            foreach ($bill_string as $bill) {
                $bill1[]="'".$bill."'";
            }
            $bill2=implode(",", $bill1);
            foreach ($pin_id as $pin) {
                mysql_query("UPDATE areawise_temp SET rep_id='$rep_id' WHERE pin_id='$pin' AND bill_string IN ($bill2)");
            }
        }
    }

    foreach ($pin_id as $pin) {
        mysql_query("UPDATE tbl_customer_master SET rep_id='$rep_id' WHERE pin_id='$pin'");
    }
    header('location:customer_rep_mapping_old.php');
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
<h2><i class="icon-edit"></i>Rep Mapping For Single & Shared Pincode</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">

<table style="width: 100%">
    <tr>
        <td>
            <form class="form-horizontal" action="javascript:void(0)" target="_blank" enctype="multipart/form-data" method="post" name="frm">
                <fieldset>
                    <div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                        <div class="controls">
                            <select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" required>
                            <option value="">--Select--</option>
                            <?php
                            $res=mysql_query("SELECT * FROM representative");
                            while($row_res=mysql_fetch_array($res)){ ?>
                            <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                            <?php } ?> 
                            </select><script>document.getElementById("rep_id").value="<?php echo @$_REQUEST["rep_id"]; ?>";</script>
                        </div>
                    </div>
                </fieldset>
            </form>
        </td>
    </tr>
</table>
<?php if(@$_REQUEST['rep_id']!=''){ ?>
<form method="post" action="">
    <table id="example" class="table table-striped table-bordered" width="100%">
    <thead>
    <tr>
        <th style="text-align:center">PINCODE</th>
        <th style="text-align:center">CUSTOMER COUNT</th>
        <th style="text-align:center"><input type="checkbox" id="select_all">SELECT ALL</th>
    </tr>
    </thead>   
    <tbody>
    <?php
        $pin_id='';
        $rep_id=$_REQUEST['rep_id'];
        $sql1=mysql_query("SELECT pin_id,count(*) as cnt FROM rep_area where pin_id!='' group by pin_id having cnt>1");
        while($row1=mysql_fetch_array($sql1)){
            $pin.=$row1['pin_id'].',';
        }
        $pin_id=rtrim($pin,",");
        //echo "SELECT pin_id,(select pincode from master_pincode where pin_id=rep_area.pin_id) as pincode,(select count(*) from tbl_customer_master where pin_id=rep_area.pin_id) as cust_cnt FROM rep_area WHERE rep_id='$rep_id' AND pin_id NOT IN ($pin_id)";
        $sql2=mysql_query("SELECT pin_id,(select pincode from master_pincode where pin_id=rep_area.pin_id) as pincode,(select count(*) from tbl_customer_master where pin_id=rep_area.pin_id) as cust_cnt FROM rep_area WHERE rep_id='$rep_id' AND pin_id NOT IN ($pin_id)");
        while($row2=mysql_fetch_object($sql2)){
            if($row2->cust_cnt!='0'){
            //$hq_id=$row2->hq_id; ?>
            <tr>
                <td style="text-align:center"><?php echo $row2->pincode; ?></td>
                <td style="text-align:center"><?php echo $row2->cust_cnt; ?></td>
                <td style="text-align:center"><input type="checkbox" name="pin_id[]" class="select_show" value="<?php echo $row2->pin_id; ?>"></td>
            </tr>
    <?php $p++;}} ?>
    </tbody>
    </table>

    <div style="width: 30%;">
        <!-- <input type="hidden" name="hq_id" value="<?php // echo $hq_id; ?>"> -->
        <label class="checkbox" style="width: 60%;"><input type="checkbox" name="sales_update" id="sales_update" value="yes">Update in Sales Statement</label>
        <div id="show_bs_all" style="margin-left: 20px;" hidden>
            <div class="controls"> 
                <label class="radio">
                   <div class="radio" id="uniform-use_all"><span class="checked"><input type="radio" name="status" id="use_all" value="use_all" checked style="opacity: 0;"></span></div>
                   All 
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label class="radio" style="margin-top: 5px;">
                   <div class="radio" id="uniform-use_bs"><span><input type="radio" name="status" id="use_bs" value="use_bs" style="opacity: 0;"></span></div> 
                   Months
                </label>       
            </div>

            <div class="controls" id="show_bs" hidden>
                <select class="form-control" data-rel="chosen" name="bill_string[]" multiple>
                <?php
                $res1=mysql_query("SELECT bill_string FROM areawise_temp GROUP BY bill_string ORDER BY id ASC");
                while($row_res1=mysql_fetch_array($res1)){ ?>
                <option value="<?php echo $row_res1['bill_string']; ?>"><?php echo $row_res1['bill_string']; ?></option>
                <?php } ?> 
                </select>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-primary" style="float: right;">
</form>


<br><br>
<h2>SHARED PINCODE</h2>
<table id="example" class="table table-striped table-bordered" width="100%">
<thead>
<tr>
    <th style="text-align:center">PINCODE</th>
    <th style="text-align:center">ACTION</th>
</tr>
</thead>   
<tbody>
<?php
    $pin_id='';
    $rep_id=$_REQUEST['rep_id'];
    $sql1=mysql_query("SELECT pin_id,count(*) as cnt FROM rep_area where pin_id!='' group by pin_id having cnt>1");
    while($row1=mysql_fetch_array($sql1)){
        $pin.=$row1['pin_id'].',';
    }
    $pin_id=rtrim($pin,",");
    $sql2=mysql_query("SELECT pin_id,(select pincode from master_pincode where pin_id=rep_area.pin_id) as pincode FROM rep_area WHERE rep_id='$rep_id' AND pin_id IN ($pin_id)");
    while($row2=mysql_fetch_object($sql2)){
        if($row2->cust_cnt!='0'){ ?>
        <tr>
            <td style="text-align:center"><?php echo $row2->pincode; ?></td>
            <td style="text-align:center"><a href="customer_rep_shared_mapping_old.php?rep_name=<?php echo $rep_id; ?>&pin_id=<?php echo $row2->pin_id; ?>" class="btn btn-primary">Show</a></td>
        </tr>
<?php $p++;}} ?>
</tbody>
</table>
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
        $("#rep_id").change(function(){
            if($(this).val()!=''){
                window.location.href="customer_rep_mapping_old.php?rep_id="+$(this).val();
            } else {
                window.location.href="customer_rep_mapping_old.php";
            }
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
