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


if ($_REQUEST['batch_submit'] == 'insert') {
    mysql_query("INSERT INTO mst_batchdetails(batch, product_id, batch_mrp, batch_pts, batch_ptr, batch_nrv, batch_mfrdate, batch_expdate, batch_datetime) VALUES ('".strtoupper($_REQUEST['batch_no'])."','".$_REQUEST['product_name']."','".$_REQUEST['mrp_price']."','".$_REQUEST['pts_price']."','".$_REQUEST['ptr_price']."','".$_REQUEST['nrv_price']."','".$_REQUEST['manufac_date']."','".$_REQUEST['expiry_date']."','".date('Y-m-d h:i:s')."')");
}

if($_REQUEST['batch_submit'] == 'update'){
    mysql_query("UPDATE mst_batchdetails SET batch_mrp='".$_REQUEST['mrp_price_edit']."',batch_pts='".$_REQUEST['pts_price_edit']."',batch_ptr='".$_REQUEST['ptr_price_edit']."',batch_nrv='".$_REQUEST['nrv_price_edit']."',batch_mfrdate='".$_REQUEST['manufac_date_edit']."',batch_expdate='".$_REQUEST['expiry_date_edit']."' WHERE batch_id = '".$_REQUEST['batch_id']."'");
}

if(isset($_REQUEST['productname']))
{   
  $sqty=mysql_query("SELECT * FROM product WHERE id = '".$_REQUEST["productname"]."'") or die(mysql_error());
  $sqty_R=mysql_fetch_array($sqty);
  echo $st=$sqty_R['id'];
  exit();
}

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
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript"> 
    $(function() {
    
    $("#dd_user_input").autocomplete({
    source: "autosearch-y/individual_product.php",
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

</head>

<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>

<noscript>
<div class="alert alert-block span10">
</div>
</noscript>

<div id="content" class="span10" >

<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>BATCH DETAILS <button type="button" style="margin-left:600px;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addModal">ADD BATCH</button></h2> 
</div>
<div class="row-fluid sortable">		
<div class="box span12">

<div class="box-content">
    <div>
        <form name="thisForm" action="" method="post">
            <table style="width:60%;">
                <tr>
                    <td>Product Name</td>
                    <td>:</td>
                    <td>
                        <input id="dd_user_input" type="text" name="product_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';"/>
                    </td>
                    <td>
                        <input type="submit" name="submit" value="Search" class="btn btn-primary" style="margin-top:-12px" >
                    </td>
                </tr>  
            </table>
        </form>
    </div>
</div>

<div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <?php	
            if(@$_REQUEST['product_name']!=''){
                $product="WHERE pro_name='".$_REQUEST["product_name"]."'";
            } else { $product=''; }

            $a=mysql_query("SELECT id,pro_name FROM product $product ORDER BY pro_name ASC")or die(mysql_error());
            while($customer=mysql_fetch_object($a)){ 
        ?> 
            <tr>
            	<td style="background:#FDEAE0;"><?=$customer->pro_name;?></td>
                <td>
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<tr>
                            <th style="background:#FFE4B5;text-align:center;">BATCH NO</th>
                            <th style="background:#FFE4B5;text-align:center;">PTR</th>
                            <th style="background:#FFE4B5;text-align:center;">PTS</th>
                            <th style="background:#FFE4B5;text-align:center;">NRV</th>
                            <th style="background:#FFE4B5;text-align:center;">MRP</th>
                            <th style="background:#FFE4B5;text-align:center;">MANUFACTURE DATE</th>
                            <th style="background:#FFE4B5;text-align:center;">EXPIRY DATE</th>
                            <th style="background:#FFE4B5;text-align:center;">ACTIONS</th>
                        </tr>
                        <?php
                            $b=mysql_query("SELECT * FROM  mst_batchdetails where product_id = '".$customer->id."'");
                            while($customer1=mysql_fetch_object($b)){ 
                        ?>
                        <tr>
                            <td><?php echo $customer1->batch; ?></td>
                            <td><?php echo $customer1->batch_ptr; ?></td>
                            <td><?php echo $customer1->batch_pts; ?></td>
                            <td><?php echo $customer1->batch_nrv; ?></td>
                            <td><?php echo $customer1->batch_mrp; ?></td>
                            <td><?php echo $customer1->batch_mfrdate; ?></td>
                            <td><?php echo $customer1->batch_expdate; ?></td>
                            <td>
                            <button type="button" class="btn btn-info btn-lg edit_batch" data-toggle="modal" data-target="#editModal" batch_id="<?php echo $customer1->batch_id; ?>"><i class="icon-edit icon-white"></i>Edit</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>        
</div>
</div>
</div>
</div>
</div>
<hr>




<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>ADD BATCH DETAILS</h3>
            </div>
            <div class="modal-body" style="height:510px;">  
                <form class="form-horizontal" enctype="multipart/form-data" method="post">
                    <fieldset> 
                        <div class="control-group">
                            <label class="control-label">Product Name<span style="color:#FF0000;">*</span> </label>
                            <div class="controls">
                                <select name="product_name" id="product_name" data-rel="chosen"> 
                                    <option value="">---Select Product---</option>
                                    <?php
                                    $SQL=mysql_query("SELECT id,pro_name FROM product where pro_name !='' ORDER BY pro_name ASC");
                                    while($row_ma=mysql_fetch_object($SQL)) { ?>
                                       <option value="<?=@$row_ma->id;?>"><?=@$row_ma->pro_name;?></option>            
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="control-group">
                            <label class="control-label">Batch No<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <table>
                                <tr>                                  
                                     <td><input class="input-xlarge" type="text" name="batch_no" id="batch_no" style="width: 105px;" /></td>
                                     <td><input class="input-xlarge" type="text" name="batch_no1" id="batch_no1" style="width: 100px;" readonly/></td>
                                     <label id='batch_error' style="color:red;"></label>
                                </tr>
                            </table>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">PTR Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="ptr_price" id="ptr_price" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">PTS Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="pts_price" id="pts_price" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">NRV Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="nrv_price" id="nrv_price" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">MRP Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="mrp_price" id="mrp_price" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Manufacture Date<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="manufac_date" id="manufac_date" style="width: 220px;" readonly />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Expiry Date<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="expiry_date" id="expiry_date" style="width: 220px;" readonly />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="batch_add">Add New Batch</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>EDIT BATCH DETAILS</h3>
            </div>
            <div class="modal-body" style="height:510px;">  
                <form class="form-horizontal" enctype="multipart/form-data" method="post">
                    <fieldset> 
                        <div class="control-group">
                            <label class="control-label">Product Name<span style="color:#FF0000;">*</span></label>
                            <div class="controls" style="margin-top: 6px;">
                                <input type="hidden" id="batch_id" />
                                <font id="batch_product_edit" style="font-size: 15px;font-weight: 600;"></font>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Batch No<span style="color:#FF0000;">*</span></label>
                            <div class="controls" style="margin-top: 6px;">
                                <font id="batch_no_edit" style="font-size: 15px;font-weight: 600;"></font>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">PTR Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="ptr_price_edit" id="ptr_price_edit" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">PTS Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="pts_price_edit" id="pts_price_edit" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">NRV Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="nrv_price_edit" id="nrv_price_edit" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">MRP Price<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="mrp_price_edit" id="mrp_price_edit" style="width: 220px;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Manufacture Date<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="manufac_date_edit" id="manufac_date_edit" style="width: 220px;" readonly />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Expiry Date<span style="color:#FF0000;">*</span></label>
                            <div class="controls">
                                <input class="input-xlarge" type="text" name="expiry_date_edit" id="expiry_date_edit" style="width: 220px;" readonly />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="batch_edit">Edit Batch</button>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php"); ?>


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

$("#batch_no").keyup(function(){
    var post_data={ batch_no:$(this).val(), condition:'check_duplicate' };
    $.ajax({
        type: 'post',
        url: "batch_data.php",
        data: post_data,
        success: function(data){
            var edits = eval('(' + data + ')');
            if(edits.status == "success") {
                $("#batch_error").html('');
            } else if(edits.status == "failed") {
                $("#batch_error").html('Already Entered');
            }
        }
    });
});

$("#batch_add").click(function(){
    var product_name=$("#product_name").val();
    var batch_no=$("#batch_no").val()+$("#batch_no1").val();
    var ptr_price=$("#ptr_price").val();
    var pts_price=$("#pts_price").val();
    var nrv_price=$("#nrv_price").val();
    var mrp_price=$("#mrp_price").val();
    var manufac_date=$("#manufac_date").val();
    var expiry_date=$("#expiry_date").val();

    if(product_name==''){ alert('Please Select Product'); } else if(batch_no==''){ alert('Please Enter Batch Number'); } else if(ptr_price==''){ alert('Please Enter PTR Price'); } else if(pts_price==''){ alert('Please Enter PTS Price'); } else if(nrv_price==''){ alert('Please Enter NRV Price'); } else if(mrp_price==''){ alert('Please Enter MRP Price'); } else if(manufac_date==''){ alert('Please Select Manufacture Date'); } else if(expiry_date==''){ alert('Please Select Expiry Date'); } else {
        
        var post_data={ product_name:product_name, batch_no:batch_no, ptr_price:ptr_price, pts_price:pts_price, nrv_price:nrv_price, mrp_price:mrp_price, manufac_date:manufac_date, expiry_date:expiry_date, batch_submit:'insert' };
        
        var post_data1={ batch_no:batch_no, condition:'check_duplicate' };



        $.ajax({
            type: 'post',
            url: "batch_data.php",
            data: post_data1,
            success: function(data){
                var edits = eval('(' + data + ')');
                if(edits.status == "success") {
                    $.ajax({
                        type: 'post',
                        url: "batch.php",
                        data: post_data,
                        success: function(data){
                            window.location.href="batch.php";
                        }
                    });
                } else if(edits.status == "failed") {
                    $("#batch_no").focus();
                    $("#batch_error").html('Already Entered');
                }
            }
        });



    }
});

$("#batch_edit").click(function(){
    var batch_id=$("#batch_id").val();
    var ptr_price=$("#ptr_price_edit").val();
    var pts_price=$("#pts_price_edit").val();
    var nrv_price=$("#nrv_price_edit").val();
    var mrp_price=$("#mrp_price_edit").val();
    var manufac_date=$("#manufac_date_edit").val();
    var expiry_date=$("#expiry_date_edit").val();

    if(ptr_price==''){ alert('Please Enter PTR Price'); } else if(pts_price==''){ alert('Please Enter PTS Price'); } else if(nrv_price==''){ alert('Please Enter NRV Price'); } else if(mrp_price==''){ alert('Please Enter MRP Price'); } else if(manufac_date==''){ alert('Please Select Manufacture Date'); } else if(expiry_date==''){ alert('Please Select Expiry Date'); } else {
        
        var post_data={ batch_id:batch_id, ptr_price_edit:ptr_price, pts_price_edit:pts_price, nrv_price_edit:nrv_price, mrp_price_edit:mrp_price, manufac_date_edit:manufac_date, expiry_date_edit:expiry_date, batch_submit:'update' };

        $.ajax({
            type: 'post',
            url: "batch.php",
            data: post_data,
            success: function(data){
                window.location.href="batch.php";
            }
        });
    }
});




$('.edit_batch').click(function(){
    var batch_id=$(this).attr('batch_id');
    var post_data={ batch_id:batch_id, condition:'fetch_data' };
    $.ajax({
        type: 'post',
        url: "batch_data.php",
        data: post_data,
        success: function(data){
            var edits = eval('(' + data + ')');

            $("#batch_id").val(batch_id);
            $("#batch_product_edit").html(edits.product);
            $("#batch_no_edit").html(edits.batch);
            $("#ptr_price_edit").val(edits.batch_ptr);
            $("#pts_price_edit").val(edits.batch_pts);
            $("#nrv_price_edit").val(edits.batch_nrv);
            $("#mrp_price_edit").val(edits.batch_mrp);
            $("#manufac_date_edit").val(edits.batch_mfrdate);
            $("#expiry_date_edit").val(edits.batch_expdate);
        }
    });
});

$('#manufac_date,#expiry_date,#manufac_date_edit,#expiry_date_edit').datepicker( {
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'mm-yy',
    yearRange: "2015:2025",
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


$('#ptr_price,#pts_price,#nrv_price,#mrp_price,#ptr_price_edit,#pts_price_edit,#nrv_price_edit,#mrp_price_edit').keypress(function(event) {
    if(event.which == 8 || event.which == 0){
        return true;
    }
    if(event.which < 46 || event.which > 59) {
        return false;
    }
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
    }
});


$('#batch_no,#batch_no_edit').keypress(function(){
    if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
    }
});

$("#product_name").change(function(){    
    // alert("hi");
    $.post("batch.php",{productname:$("#product_name").val()}, function( data ) { 
    // alert(data);
    $('#batch_no1').val(data);
    });
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
?>
