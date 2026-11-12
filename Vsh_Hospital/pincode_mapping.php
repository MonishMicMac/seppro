<?php
	include("include/connect.php");
	session_start();
	
	$id=$_SESSION['id'];
	//echo $m_id16;die();
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
$res1=$ad->view('dist_prod','','order by id desc');
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
    <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
    <style type="text/css">
 .tr_name {
  color: #337ab7;
 } 
  .tr_dist {
  color: #337ab7;
  background-color: #f1f1f1;
 } 
</style>
    <script type="text/javascript">
function valid()
{
var x=document.getElementById("dist_id").value;
if(x === "null" || x === "")
{
alert("Please Enter Distributor Name");
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
<h2><i class="icon-refresh"></i>&nbsp;&nbsp;Auto Mapping</h2>
<div class="controls" style="margin-left: 20%">
</div>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form action="pincode_mapping_auto.php" method="post" enctype="multipart/form-data">
<table style="width:100%;">
            <tbody><tr>
                <td><label>Select Pincode</label></td>
                <td>:</td>
                <td>
                  <select  data-rel="chosen" name="pincode_sel" id="pincode_sel">
                    <option value="">---Select---</option>
                        <?php $P=mysql_query("select TRIM(pincode) as pincode, count(id) as pin_count from distributor_customer where pincode in (select pincode from master_pincode) and our_cust_id='' and pincode !='0' and CHAR_LENGTH(TRIM(pincode))< 7 group by pincode"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->pincode; ?>" count="<?=$I->pin_count; ?>"><?=$I->pincode; ?></option>
                        <?php } ?> 
                  </select>
                </td>
                <td><label>Remaining Mapping &nbsp;&nbsp;&nbsp; : <span class="label label-warning remain" style="font-size: 14px;">0</span></label></td>
                <td><input type="submit" name="submit" value="Update" class="btn btn-info" style="margin-top:-6px"></td>
                <td></td>
            </tr>
             <tr align="right">
              <td align="right" colspan="8" style="padding-right:80px;">
                
                                
                </td>
             </tr>
        </tbody></table>
        <?php if(@($_SESSION["insert_count"])||@($_SESSION["update_count"])) : ?>
      <label align="middle" style="color:green"><?php echo $_SESSION["insert_count"]." Customer(s) created and ".$_SESSION["update_count"]." Customer(s) already exists for Pincode - ".$_REQUEST['pincode'] ?></label>
        <?php $_SESSION["insert_count"]=0; $_SESSION["update_count"]=0; endif; ?>
</form>
</div>
</div>
</div>

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>New Customers Mapping</h2>
<div class="controls" style="margin-left: 20%">
<a href="pincode_edit_mapping.php" style="margin-left:5%" class="btn btn-success">Customer Edit</a>
</div>
<div class="box-icon">
</div>
</div>
<div class="box-content">



  <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
    <th>#</th>
    <th>Pincode</th>
    <th></th>
    <th>Customer</th>
    <th></th>
    <th>Distributor</th>
    <!-- <th>Mapping</th> -->

</thead>

<tbody>
<?php 

$pin = array();
$sel = mysql_query("select distinct pincode from master_pincode");
while($sel_row = mysql_fetch_array($sel)){

$pin[] = $sel_row['pincode'];

}

$ad =0;
$d=1;
$sal = mysql_query("SELECT distinct distributor_customer.pincode as pincode,distributor_customer.customer_name,distributor_customer.area_name,distributor_customer.distributor_id,distributor_customer.id,distributor.dis_name  FROM `distributor_customer`,distributor where distributor_customer.pincode !='.' and distributor_customer.pincode !='0' and distributor_customer.pincode !=' ' and distributor_customer.pincode !='' and distributor.dis_id =distributor_customer.distributor_id  and distributor_customer.our_cust_id ='' ORDER BY distributor_customer.distributor_id,distributor_customer.customer_name,distributor_customer.pincode ASC");
while($sal_row = mysql_fetch_array($sal))
{
// $gn = mysql_query("select dis_name from distributor where dis_id ='".$sal_row['distributor_id']."' ");
// $gn_row = mysql_fetch_array($gn);
$pincode = $sal_row['pincode']; 
$encoding = mb_detect_encoding($pincode, 'utf-8, iso-8859-1, ascii', true);
    if (strcasecmp($encoding, 'UTF-8') !== 0) {
      $pincode = iconv($encoding, 'utf-8', $pincode);
    }

//$ad[] = array($pincode,'',$sal_row['customer_name'],'',$gn_row['dis_name'],$sal_row['id']);
?>
<tr class="tr_cust">
<td><?php echo $d; ?></td>
<td class="td_pincode" <?php echo (in_array($pincode, $pin)==0 ? 'style="color:red"' : ''); ?> areaname="<?php echo $sal_row['area_name'] ?>" ><?php echo $pincode; ?></td>
<td><input type='checkbox' name='merge_dist' class='form-control merge_dist' onclick="mergedist(this)" value="<?php echo $sal_row['id']; ?>"></td>
<td class="cust td_customer" style="width: 30%;"><?php echo $sal_row['customer_name']; ?></td>
<td><input type='radio' name='select_dist' class='select_dist' id="sel<?php echo $ad; ?>" onclick="selectdist(this)" data-toggle='modal' data-target='#myModal-mini' style="margin-left: 0px;" disabled></td>
<td class="td_dis"><?php echo $sal_row['dis_name']; ?></td>
<!-- <td class="td_mapp"><input type='textbox' name='mapp_dist' class='input-xlarge mapp_dist'></td> -->
</tr>
<?php
$ad++;
$d++;
}
?>    
</tbody>


      </table>





 <div id="myModal-mini" class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"> <i class='fa fa-times'></i> </button>
              <button class="close modalMinimize"> <i class='fa fa-minus'></i> </button>
              <p class="h2 text-center"><strong>Mapping Customer</strong></p>
            </div>
            <div class="modal-body" >
                <input  type="hidden" name="pincodes" id="pincodes" >        
                <input  type="hidden" name="areaname" id="areaname" >        
  
           <div class="control-group" style="margin-left: 20%;">
			<label class="control-label" for="typeahead"></label>
			<div class="controls"> 
			   <label class="radio">
					<input type="radio" class="type_cust" name="sex" value="new_cust" style="margin-left: 0px;">
			    New Customer Name
				<input type="radio" class="type_cust" name="sex" value="exists" style="margin-left: 0px;">
			       Exists Customer Name
			   </label>
    		</div>
		</div>

            <div class="control-group new" hidden>
            <div class="col-md-5">
            <label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
            </div>
            <div class="controls col-md-5">
                <input class="input-xlarge focused" type="text" name="cust_name" id="cust_name" required="" value="">        
            </div>
              <div class="controls col-md-2">
               <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
              </div>
            </div>

            <div class="control-group exists" hidden>
            <div class="col-md-5">
            <label class="control-label" for="typeahead">Exisit Customer Name<span style="color:#FF0000;">*</span> </label>
            </div>
            <div class="controls col-md-5">
                <input class="input-xlarge focused" type="text" name="cust_name" id="exists_cust_name" required="" value="">        
                <input  type="hidden" name="exists_id" id="exists_id" >        
                <span class="chk" style="color:red;"></span>
            </div>
                 <div class="controls col-md-2">
               <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
              </div>
            </div>

             

            <table class="table table-striped table-bordered" width="100%">
            	<thead>
            		<th>Pincode</th>
            		<th>Customer</th>
            		<th>Distributor</th>
            		<th>Mapping</th>
            	</thead>
            	<tbody class="app">
            			
            	</tbody>
            </table>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success mapp_ok" data-dismiss="modal" aria-hidden="true">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
          </div>
    </div>
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
<style type="text/css">
	.ui-autocomplete {
    overflow-x: hidden;
    overflow-y: scroll;
    position: fixed;
}
</style>

<script type="text/javascript">
function mergedist(d){
 if($(d).is(':checked')== true){
 $(d).closest('tr').find('.select_dist').attr('disabled',false);
 $(d).closest('tr').find('.radio').removeClass('disabled');
}
 if($(d).is(':checked')== false){
 $(d).closest('tr').find('.select_dist').attr('disabled',true);
 $(d).closest('tr').find('.radio').addClass('disabled');
}

}

function selectdist(s)
{
$(".chk").text('');  
var cname = $(s).closest('tr').find('.cust').text();
$('#cust_name').val(cname);
$(".app").html('');
$(".merge_dist:checked").each(function(){
var pin = $(this).closest('tr').find('.td_pincode').text();
var area = $(this).closest('tr').find('.td_pincode').attr('areaname');
var cust = $(this).closest('tr').find('.td_customer').text();
var dis = $(this).closest('tr').find('.td_dis').text();
// var mapp = $(this).closest('tr').find('.td_mapp').val();
var pini= pin.trim();
$("#pincodes").val(pini);
$("#areaname").val(area);
$('.app').append('<tr><td class="td_pop">'+pin+'</td><td>'+cust+'</td><td>'+dis+'</td><td class="final_mapp"></td></tr>');
});
}


// function pincode_sel(l){
// // var vl = l.value;
// alert(l.value)
// // var option = $('option:selected', l).attr('count');
// // alert(option);
// // $(".remain").text(option);
// }


$("#pincode_sel").change(function(){

var option = $('option:selected', this).attr('count');
 $(".remain").text(option);

});


$(".mapp_ok").click(function(){

var t = $('input[name="sex"]:checked').val();

if (t == 'new_cust') {
var comm = $("#cust_name").val();
}
if (t == 'exists') {
var comm = $("#exists_id").val();
}
var pinc = $("#pincodes").val();
var area = $("#areaname").val();

var cus = $('.merge_dist:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');

$.post("match_save.php",{custid : comm,autoid:cus,rtype:t,pincodes:pinc,area:area,command:"update_our_product"},function(){});

$(".merge_dist:checked").each(function(){
$(this).closest('tr').remove();
});


});


$("input[name='sex']").click(function(){

if($(this).val() == 'new_cust'){
$('.new').show();
$('.exists').hide();
}

if($(this).val() == 'exists'){
$('.new').hide();
$('.exists').show();
}

});


$("#exists_cust_name").autocomplete({
source: function(request, response) {
    $.getJSON("autosearch-y/customer_mapping.php", { pincode: $('#pincodes').val(), term: request.term }, 
              response);
  },
minLength: 2,
select: function(event, ui) {
var getUrl = ui.item.id;
// if(getUrl != '#') {
// location.href = getUrl;
// }

$("#exists_id").val(getUrl);
},

html: true, 

open: function(event, ui) {
$(".ui-autocomplete").css("z-index", 9999999999999999);
$(".ui-autocomplete").css("height", "auto");
}
});


$(".mapp_inside_ok").click(function(){

var t = $('input[name="sex"]:checked').val();

if (t == 'new_cust') {
var vc = $("#cust_name").val();
$(".final_mapp").text(vc);
}

if (t == 'exists') {
var vc = $("#exists_cust_name").val().trim();
var newpin=$("#pincodes").val().trim();

$.post("match_save.php",{exists_name : vc,pincode:newpin,command:"check_already"},function(data){ 
    // alert(data);
if (data == 0) {
    $(".chk").text("Chemist Not Exisit");
    $("#exists_id").val('');
}
if (data == 1) {
    $(".chk").text("");
  $(".final_mapp").text($("#exists_cust_name").val());
}

});

}

});	



</script>




</body>
</html>
<?php
}
