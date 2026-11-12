<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
     echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
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
    	function pin_chy(pin){
			window.location.href="rcpa.php?pin="+pin;
		}
    </script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/theraphy_search.php",
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
	$(document).ready(function(){
		$("#theraphy_add").click(function(){
			$.get("autosearch-y/rcpa.php?theraphy=add&theraphy_name="+$("#dd_user_input").val()+"",function(data,status){
					alert(data);
				});	
		});
	});
	
	$(function() {
	
	$("#dd_user_input1").autocomplete({
	source: "autosearch-y/composition_search.php",
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
	$(function() {
	
	$("#dd_user_input6").autocomplete({
	source: "autosearch-y/patient_type.php",
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
	
	$(function() {
	
	$("#dd_user_input7").autocomplete({
	source: "autosearch-y/distributor_search.php",
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
	
	$(function() {
	
	$("#dd_user_input2").autocomplete({
	source: "autosearch-y/company_search.php",
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
	$(document).ready(function(){
		$("#theraphy_add").click(function(){
			$.get("autosearch-y/rcpa.php?theraphy=add&theraphy_name="+$("#dd_user_input").val()+"",function(data,status){
					alert(data);
				});	
		});
		$("#composition_add").click(function(){
			$.get("autosearch-y/rcpa.php?composition=add&composition_name="+$("#dd_user_input1").val()+"",function(data,status){
					alert(data);
				});	
		});
		$("#company_add").click(function(){
			$.get("autosearch-y/rcpa.php?company=add&company_name="+$("#dd_user_input2").val()+"",function(data,status){
					alert(data);
				});	
		});
		$("#add_composition").click(function(){
			$.get("autosearch-y/rcpa.php?rcpa=add&pin_id="+$("#doc_pincode").val()+"&chemist_name="+$("#chemist_name").val()+"&avg_patient="+$("#avg_patient").val()+"&doc_stockist="+$("#doc_stockist").val()+"&doc_patient_type="+$("#doc_patient_type").val()+"&theraphy_name="+$("#dd_user_input").val()+"&composition_name="+$("#dd_user_input1").val()+"&brand_name="+$("#brand_name").val()+"&qty="+$("#qty").val()+"&company_name="+$("#dd_user_input2").val()+"",function(data,status){
					alert(data);
					document.getElementById("dd_user_input1").focus();
					document.getElementById("dd_user_input1").value="";
					document.getElementById("brand_name").value="";
					document.getElementById("qty").value="";
					document.getElementById("dd_user_input2").value="";
			});
		});
		
		$("#addtheraphy").click(function(){
			$.get("autosearch-y/rcpa.php?rcpa=add&pin_id="+$("#doc_pincode").val()+"&chemist_name="+$("#chemist_name").val()+"&avg_patient="+$("#avg_patient").val()+"&doc_stockist="+$("#doc_stockist").val()+"&doc_patient_type="+$("#doc_patient_type").val()+"&theraphy_name="+$("#dd_user_input").val()+"&composition_name="+$("#dd_user_input1").val()+"&brand_name="+$("#brand_name").val()+"&qty="+$("#qty").val()+"&company_name="+$("#dd_user_input2").val()+"",function(data,status){
					alert(data);
					document.getElementById("dd_user_input").focus();
					document.getElementById("dd_user_input").value="";
					document.getElementById("dd_user_input1").value="";
					document.getElementById("brand_name").value="";
					document.getElementById("qty").value="";
					document.getElementById("dd_user_input2").value="";
			});
		});
		
		$("#ptype_add").click(function(){
			$.get("autosearch-y/rcpa.php?pttype=add&dc_id="+$("#chemist_name").val()+"&pt_type="+$("#dd_user_input6").val()+"",function(data,status){
					$("#PT").load("rcpa_ptype.php?dc_id="+$("#chemist_name").val()+"");
				});	
		});
		$("#stockist_add").click(function(){
			$.get("autosearch-y/rcpa.php?stockist=add&dc_id="+$("#chemist_name").val()+"&stockist_name="+$("#dd_user_input7").val()+"",function(data,status){
					$("#PS").load("rcpa_stockist.php?dc_id="+$("#chemist_name").val()+"");
				});	
		});
	});
	function chemist(yuvi){
		window.location="rcpa.php?pin="+document.getElementById("doc_pincode").value+"&dc_id="+yuvi;
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
<h2><i class="icon-edit"></i>Retail Chemist Prescription Audit</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  id="rcpa" name="rcpa" >
<fieldset>
   
<div class="control-group">
    <label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <select  data-rel="chosen" name="doc_pincode" id="doc_pincode" required onChange="pin_chy(this.value);">
            <option value="">---Select---</option>
           	<?php $P=mysql_query("SELECT * FROM master_pincode"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
        <?php } ?>
    </select><script>document.getElementById("doc_pincode").value="<?=$_REQUEST["pin"] ?>";</script>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Chemist + Doctor Name<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <select  data-rel="chosen" name="chemist_name" id="chemist_name" required onChange="chemist(this.value);">
            <option value="">---Select---</option>
           <?php $SQL = mysql_query("SELECT doctors.doctor_name AS DNAME, tbl_customer_master.shop_name AS SNAME, tbl_doctor_chemist.chemist_id AS DCID FROM tbl_doctor_chemist,doctors,tbl_customer_master WHERE tbl_doctor_chemist.chemist_id IN (SELECT id FROM `tbl_customer_master` WHERE pin_id='".@$_REQUEST["pin"]."') AND tbl_doctor_chemist.doctor_id = doctors.id AND tbl_customer_master.id=tbl_doctor_chemist.chemist_id"); while($DC=mysql_fetch_object($SQL)){ ?>
                  <option value="<?=$DC->DCID; ?>"><?=$DC->SNAME." / ".$DC->DNAME; ?></option>  
       		<?php } ?>
        </select>
        <script>document.getElementById("chemist_name").value="<?=$_REQUEST["dc_id"] ?>";</script>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Patient Floating<br/>(No of Patient Avg per day)<span style="color:#FF0000;">*</span> </label>
    <div class="controls"><input class="input-xlarge disabled"  type="text" name="avg_patient" id="avg_patient"  maxlength="4" onKeyPress="return Alphabets(event);" required/></div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Preferable Chemist + Doctor Stockist<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
    <input id="dd_user_input7" type="text" name="doc_stockist" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["doc_stockist"]!=""){ ?>value="<?php echo @$_REQUEST["doc_stockist"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>    
    <input type="button"  class="btn btn-primary" name="ptype_add" id="stockist_add" value="Add"/></div></div>
<?php if(@$_REQUEST["dc_id"]!=""){ ?>
<div class="control-group">
<div class="controls" id="PS">
	<?php include("rcpa_stockist.php"); ?>
</div>
</div>
<?php } ?>

<div class="control-group"><label class="control-label" for="typeahead">Patient Type<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
    <input id="dd_user_input6" type="text" name="theraphy" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["ptype"]!=""){ ?>value="<?php echo @$_REQUEST["ptype"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>    
    <input type="button"  class="btn btn-primary" name="ptype_add" id="ptype_add" value="Add"/></div></div>


<?php if(@$_REQUEST["dc_id"]!=""){ ?>
<div class="control-group">
<div class="controls" id="PT">
	<?php include("rcpa_ptype.php"); ?>
</div>
</div>
<?php } ?>
<div class="control-group"><label class="control-label" for="typeahead">Theraphy<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
    <input id="dd_user_input" type="text" name="theraphy" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["theraphy"]!=""){ ?>value="<?php echo @$_REQUEST["theraphy"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>    
    <input type="button"  class="btn btn-primary" name="theraphy_add" id="theraphy_add" value="Add"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Composition Prescribing<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<input id="dd_user_input1" type="text" name="composition" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["composition"]!=""){ ?>value="<?php echo @$_REQUEST["composition"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
<input type="button"  class="btn btn-primary" name="composition_prescribing_add" id="composition_add" value="Add"/></div></div>

<div class="control-group">
	
    	<table width="95%" cellpadding="3" cellspacing="1">
        	<tr><td><strong>Brand Name</strong></td><td><strong>QTY</strong></td><td><strong>Company</strong></td></tr>
            <tr>
            	<td><input class="input-xlarge focused" name="brand_name" id="brand_name" required/></td>
                <td><input  type="text" name="qty" id="qty"  onKeyPress="return onlyNumbers(event)" maxlength="3" style="width:30px;" required/></td>
                <td>
                	<input id="dd_user_input2" type="text" name="company" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["company"]!=""){ ?>value="<?php echo @$_REQUEST["company"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
                    <input type="button"  class="btn btn-primary" name="composition_prescribing_add" id="company_add" value="Add"/>
                </td>
            </tr>
        </table>
    
</div>



<div class="form-actions"><input type="button" class="btn btn-primary" name="submit" id="add_composition" value="Add Compostion" />&nbsp;&nbsp;<input type="button" class="btn btn-primary" name="submit" id="addtheraphy" value="Next Theraphy" /></div>

</fieldset></form></div></div></div>

<?php
	$RCPA=mysql_query("SELECT * FROM  tbl_rcpa WHERE c_date='".date("Y-m-d")."'");
	$RCPAC = mysql_num_rows($RCPA);
	if($RCPAC>0){
?>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
	<tr>
    	<td>Chemist Seal / Signature</td>
        <td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
            <?php
			$CN=mysql_query("SELECT shop_name,mobile_no FROM tbl_customer_master WHERE id = (SELECT chemist_id FROM  tbl_doctor_chemist WHERE dc_id=".@$_REQUEST["dc_id"].")");
			$yuva=mysql_fetch_object($CN);
			?>
            	<tr><td>Chemist Name</td><td><?=strtoupper($yuva->shop_name); ?></td></tr>
                <tr><td>Phone Number</td><td><?=$yuva->mobile_no; ?></td></tr>
            <?php
				$ST=mysql_query("SELECT mst_rcpa_stockist.stockist_name AS SNAME FROM tbl_rcpa_stockist,mst_rcpa_stockist WHERE dc_id=".@$_REQUEST["dc_id"]." AND tbl_rcpa_stockist.stockist_id=mst_rcpa_stockist.stockist_id ORDER BY rcpa_stockist_id");
			?>
                <tr><td>Stockist</td><td><?php while($TS=mysql_fetch_object($ST)){ @$SNME.=$TS->SNAME.", ";} echo substr(@$SNME,0,-2); ?></td></tr>
            <?php
				$CN1=mysql_query("SELECT doctor_name FROM doctors WHERE id = (SELECT doctor_id FROM  tbl_doctor_chemist WHERE dc_id=".@$_REQUEST["dc_id"].")");
				$yuva1=mysql_fetch_object($CN1);
			?>
                <tr><td>Doctor Name</td><td><?=strtoupper($yuva1->doctor_name); ?></td></tr>
               
            </table>
        </td>
        <td style="text-align:right">Date : <?=date("d/m/Y"); ?></td>
    </tr>
    <tr>
    	<td colspan="3">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <tr>
                <tH colspan="2">Therapy</tH>
           </tr>
           <?php $T=mysql_query("SELECT theraphy FROM tbl_rcpa WHERE dc_id=".@$_REQUEST["dc_id"]." GROUP BY theraphy"); while($TM=mysql_fetch_object($T)){ ?>
           <tr>
           	<td><strong><?=strtoupper($TM->theraphy); ?></strong></td>           
            <td> 
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <tr><th>Molecule</th><th>Brand Name</th><th>Company Name</th><th>Quantity/w</th></tr>
			<?php 
				$T1=mysql_query("SELECT composition,qty,brand_name,company_name FROM tbl_rcpa WHERE theraphy='".$TM->theraphy."'"); while($TM1=mysql_fetch_object($T1)){
			?>           
                <tr>
                    <td><?=$TM1->composition; ?></td><td><?=$TM1->brand_name; ?></td><td><?=$TM1->company_name; ?></td><td style="text-align:center"><?=$TM1->qty; ?></td>
                </tr>             
            <?php } ?>
          </table> </td>
            
           </tr>
           <?php } ?>
        </table>
        </td>
    </tr>
</table>
<?php } ?>
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

</body>
</html>
