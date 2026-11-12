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
    <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/bootstrap.icon-large.css' rel='stylesheet'>
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
<h2><i class="icon-edit"></i>MONTHWISE CONSOLIDATED REPORT

</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">

<div class="control-group" style="margin-left: 40%">
<div class="controls">
<label class="control-label" for="typeahead">Headquarters Name<span style="color:#FF0000;">*</span> </label>
</div>
<div class="col-md-5">
<div class="controls"><select id="hq_name" name="hq_name" class="head_quater" data-rel="chosen" style="color:#0066FF" required>
<option value="">--Select--</option>
<?php
$res=mysql_query("SELECT * FROM mst_headquarters");
while($row_res=mysql_fetch_array($res)){ ?>
<option value="<?php echo $row_res['headquarters_id']; ?>" <?php if($row_res['headquarters_id']==$_REQUEST['hq_name']) { echo "selected"; } ?> ><?php echo $row_res['headquarters_name']; ?></option>
<?php } ?> 
</select></div>
</div>
</div>

<?php if ($_REQUEST['hq_name']!='') { ?>


<div class="controls">
<a href="headquator_export.php?hq_name=<?php echo $_REQUEST['hq_name'] ?>" style="float: right;" class="btn btn-success">Export</a>
</div>
<br>
<br>
  <table  class="table table-striped table-bordered" width="100%">
<thead>
    <th>Pincode</th>
    <th>Division Customer</th>
    <th>Distributor</th>
    <th>Customer</th>
    <th colspan="2">Actions</th>
</thead>

<tbody>
<?php 
$heq=$_REQUEST['hq_name'];
$repa = mysql_query("SELECT GROUP_CONCAT(`id`) as sid FROM `representative` WHERE `headquarter_id` = $heq");
$rep_rows = mysql_fetch_array($repa);
$repID = $rep_rows['sid'];
$cust_mst = mysql_query("SELECT `pincode`,GROUP_CONCAT(id) as id  FROM `tbl_customer_master` WHERE `rep_id` IN ($repID) and pincode !=0 and pincode !='' GROUP BY `pincode`");
while($cust_row = mysql_fetch_array($cust_mst)) :

	$fd = $cust_row['id'];
	$cid = explode(",", $fd);  
	$pin_code = $cust_row['pincode'];
	$count_pin = 0;
	$count_shop = array();
	$shop_array = array();
	$distname_array = array();
	$custname_array = array();
	$did_array = array();
	$j = 0;
	foreach($cid as $sid) :
	  $cust_ch = mysql_query("SELECT shop_name  FROM `tbl_customer_master` where id = $sid");
	  $cust_ch_row = mysql_fetch_array($cust_ch);
	  $shop_array[] =$cust_ch_row['shop_name'];
	  $dist_cust = mysql_query("SELECT b.dis_name as dis_name,a.`customer_name` as customer_name,a.id as id FROM `distributor_customer` a LEFT JOIN distributor b ON a.distributor_id=b.dis_id WHERE `our_cust_id`=$sid");
	  $count_shop[$j] = 0;
	  if(mysql_num_rows($dist_cust)>0) :
	    while($distrow=mysql_fetch_array($dist_cust)) :
	      $distname_array[$j][] = $distrow['dis_name'];
	      $custname_array[$j][] = $distrow['customer_name'];
	      $did_array[$j][] = $distrow['id'];

	      $count_pin++;
	      $count_shop[$j]++;
	    endwhile;
	  else :
	    $distname_array[$j][] = '';
	    $custname_array[$j][] = '';
	    $did_array[$j][] = '';

	    $count_pin++;
	    $count_shop[$j]++;
	  endif;
	  $j++;
	endforeach;


	echo "<tr><td rowspan='".(($count_pin=='0')?1:$count_pin)."'>".$pin_code."</td>";
	for ($i=0; $i < count($shop_array); $i++) :
	  if($i == 0) :
	    echo "<td rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td>";
	  else :
	    echo "<tr><td rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td>";
	  endif;

	  for ($o=0; $o < $count_shop[$i]; $o++) :
	    if($o == 0) :
	      if($i == 0) :
	        echo "<td>".$distname_array[$i][$o]."</td><td>".$custname_array[$i][$o]."</td><td rowspan='".$count_pin."' pin='".$pin_code."' data-toggle='modal' data-target='#myModal-first' onclick='firstpopup(this)'  ><i class='icon-pencil' style='cursor:pointer;'></i></td><td><i class='icon-trash' dis='".$did_array[$i][$o]."' style='cursor:pointer;' onclick='rmvid(this)'></i></td></tr>";
	      else :
	        echo "<td>".$distname_array[$i][$o]."</td><td>".$custname_array[$i][$o]."</td><td><i class='icon-trash' dis='".$did_array[$i][$o]."' onclick='rmvid(this)' style='cursor:pointer;' style='cursor:pointer;' onclick='rmvid(this)'></i></td></tr>";
	      endif;
	    else :
	      echo "<tr><td>".$distname_array[$i][$o]."</td><td>".$custname_array[$i][$o]."</td><td><i class='icon-trash' dis='".$did_array[$i][$o]."' style='cursor:pointer;' style='cursor:pointer;' onclick='rmvid(this)'></i></td></tr>";
	    endif;

	  endfor;
	endfor;
endwhile;
?> 
</tbody>

      </table>
<?php } ?>


 <div id="myModal-first" class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 60%;">
        <div class="modal-dialog  modal-lg">
          <!-- Modal content-->
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"> <i class='fa fa-times'></i> </button>
              <button class="close modalMinimize"> <i class='fa fa-minus'></i> </button>
              <p class="h2 text-center"><strong>Mapping Customer</strong></p>
            </div>
            <div class="modal-body first_app" >
            

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success mapp_ok" data-dismiss="modal" aria-hidden="true">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
          </div>
    </div>
</div>




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
    $(document).ready( function () {
     $('#example').DataTable({
     	 paging:   false
     });


$(".head_quater").change(function(){
var r = $(this).val();
window.location.href = "pincode_edit_mapping.php?hq_name="+r;
});


    });


function firstpopup(s){

var pin = $(s).attr('pin');
var hq = $("#hq_name option:selected").val();

$(".first_app").load("pincode_load.php?edit_hq_name="+hq+"&edit_pincode="+pin);

}

function rmvid(f){
var distID = $(f).attr('dis');
var hq = $("#hq_name option:selected").val();
var con= confirm("Are you Sure You want remove this");
if (con == true) {
$.post("match_save.php",{command : "remove",dist:distID},function(){
window.location.href="pincode_edit_mapping.php?hq_name="+hq;
});
}
}





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
var cname = $(s).closest('tr').find('.cust').text();
$('#cust_name').val(cname);
$(".app").html('');
$(".merge_dist:checked").each(function(){
// var pin = $(this).closest('tr').find('.td_pincode').text();
var pin = $(s).attr('pin');
var cust = $(this).closest('tr').find('.td_customer').text();
var dis = $(this).closest('tr').find('.td_dis').text();
// var mapp = $(this).closest('tr').find('.td_mapp').val();
$("#pincodes").val(pin);
$('.app').append('<tr><td class="td_pop">'+pin+'</td><td>'+dis+'</td><td>'+cust+'</td><td class="final_mapp"></td></tr>');
});
}

$(".mapp_ok").click(function(){

var t = $('input[name="sex"]:checked').val();

if (t == 'new_cust') {
var comm = $("#cust_name").val();
}
if (t == 'exists') {
var comm = $("#exists_id").val();
}
var pinc = $("#pincodes").val();
var cus = $('.merge_dist:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');

$.post("match_save.php",{custid : comm,autoid:cus,pincodes:pinc,rtype:t,command:"update_our_product"},function(){});

$(".merge_dist:checked").each(function(){
// $(this).closest('tr').css('display','none');
 $(this).attr('disabled',true);
 $(this).closest('tr').find('.select_dist').attr('disabled',true);
 $(this).closest('tr').find('.radio').addClass('disabled');
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
source: "autosearch-y/customer_mapping.php",
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
$(".ui-autocomplete").css("height", "300");
}
});


// $(".mapp_inside_ok").click(function(){

// var t = $('input[name="sex"]:checked').val();

// if (t == 'new_cust') {
// var vc = $("#cust_name").val();
// }

// if (t == 'exists') {
// var vc = $("#exists_cust_name").val();
// }

// $(".final_mapp").text(vc);

// });	


$(".mapp_inside_ok").click(function(){

var t = $('input[name="sex"]:checked').val();
if (t == 'new_cust') {
var vc = $("#cust_name").val();
$(".final_mapp").text(vc);
}
if (t == 'exists') {
var vc = $("#exists_cust_name").val();
var pin = $(".td_pop").text();

$.post("match_save.php",{exists_name : vc,pincode:pin,command:"check_already"},function(data){ 
if (data == 0) {
    $(".chk").text("Chemist Not Exisit");
    $("#exists_id").val('');
}
if (data == 1) {
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
