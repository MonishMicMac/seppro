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
if(@$_REQUEST["mode"]=="save"){	
	mysql_query("UPDATE tbl_work_plan SET reporteddate='".date("Y-m-d")."',reportedtime='".date("H:i:s")."',drunavailablereason='".$_REQUEST["report"]."' WHERE wp_id=".$_REQUEST["wp_id"]."");	
	$_SESSION["_msg"]="Report Successfully Updated";
	header("location:appointment_report.php?wp_id=".$_REQUEST["wp_id"]."&wp_dc=".$_REQUEST["wp_dc"]."");
	die();
}
require_once("include/select.php");
$ad=new select1();
$res2=mysql_query("SELECT DISTINCT(dist_id) FROM pincode_list")or die(mysql_error());
$abc=mysql_query("SELECT * FROM tbl_customer_master order by id desc limit 1")or die(mysql_error());
$row_abc=mysql_fetch_array($abc);
$co_abc=mysql_num_rows($abc);
if($co_abc > 0)
{
    $cust_id=$row_abc['id']+1;
}
else 
{
    $cust_id="10001";
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>

    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript">
<!-- email Validation-->
$(function() {
	
$("#dd_user_input,#dd_user_input1").autocomplete({
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
<script type="text/javascript">
function pin_chy(pin){  	
	window.location.href="doctor_appointment.php?pin="+pin;
  }
function doctors(pin,d_id){
	window.location.href="doctor_appointment.php?pin="+pin+"&d_id="+d_id+"";
}
function yuvaraj(baba){	
	window.location.href="doctor_appointment.php?reporting_to="+baba;	
}
</script>
 
    </head>

<body onLoad="initialize();">
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>


<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>DOCTOR / CHEMIST / STOCKIST REPORT</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="wp_id" value="<?=$_REQUEST["wp_id"]; ?>" />
<input type="hidden" name="wp_dc" value="<?=$_REQUEST["wp_dc"]; ?>" />
 <fieldset> 
 	<div>
    <?php if(@$_SESSION["_msg"]!=""){ echo "<strong>".$_SESSION["_msg"]."</strong>";$_SESSION["_msg"]="";} ?>
    
    </div> 
	<table class="table table-bordered">
    	<?php		
					if(@$_REQUEST["wp_dc"]=="D"){@$Type="DOCTOR";}if(@$_REQUEST["wp_dc"]=="C"){@$Type="CHEMIST";}if(@$_REQUEST["wp_dc"]=="S"){@$Type="STOCKIST";}
					$DR=mysql_query("SELECT doctor_name FROM doctors,tbl_work_plan WHERE wp_id=".$_REQUEST["wp_id"]." and wp_rep_id='".$_SESSION["repid"]."' and wp_dc='D' and tbl_work_plan.wp_dc_id=doctors.id");
					$D=mysql_fetch_object($DR);if(@$_REQUEST["wp_dc"]=="D"){ $DCS=$D->doctor_name;}

					$CH=mysql_query("SELECT shop_name FROM tbl_customer_master,tbl_work_plan WHERE wp_id=".$_REQUEST["wp_id"]." and wp_rep_id='".$_SESSION["repid"]."' and wp_dc='C' and tbl_work_plan.wp_dc_id=tbl_customer_master.id");
					$C=mysql_fetch_object($CH);if(@$_REQUEST["wp_dc"]=="C"){$DCS=$C->shop_name;}	

					$ST=mysql_query("SELECT dis_name FROM distributor,tbl_work_plan WHERE wp_id=".$_REQUEST["wp_id"]." and wp_rep_id='".$_SESSION["repid"]."' and wp_dc='S' and tbl_work_plan.wp_dc_id=distributor.id");
					$S=mysql_fetch_object($ST);if(@$_REQUEST["wp_dc"]=="S"){$DCS=$S->dis_name;}	

					echo "<tr><td><strong>".$Type."</strong> - <strong>".$DCS."</strong></td></tr>";
		?> 
        <tr><td><textarea name="report"></textarea></td></tr>  
        <tr><td><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" /> </td></tr> 
    </table>

</fieldset>
</form>
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
            $(document).ready(function(){
				$("#sample").click(function(){
					$("#sample_product").toggle();
				});
				$("#baba").click(function(){
					$("#sample_product").hide();
				});	
				$("#product_proposed_for").click(function(){
					$.get("autosearch-y/appointment.php?appointment=add&sample_product="+$("#dd_user_input").val()+"&dc="+$(".dc").val()+"&dc_id="+$("#doctor").val()+"",function(data,status){
							$("#show_dis").html(data);
					});
				});
				$("#show_dis").click(function(){
					$.get("district_show.php?d_id="+d_id+"&&pin="+pin+"&&command=district_show",function(data,status){
						$("#show_dis").html(data); 
					});
					
				 });	
				 $("#Joint").click(function(){
						$("#managerType").show();
						$("#joint_to").show();						
					});
					
					$("#Individual").click(function(){
						$("#managerType").hide();
						$("#joint_to").hide();
					}); 
				
			$("#sample_add").click(function(){
					$.get("autosearch-y/appointment.php?sample=add&sample_product="+$("#dd_user_input1").val()+"&prodcut_qty="+$("#prodcut_qty1").val()+"&dc="+$(".dc").val()+"&dc_id="+$("#doctor").val()+"",function(data,status){
							$("#show_sample").html(data);
					});
				});
				
				$("#show_sample").click(function(){
					$.get("district_show.php?d_id="+d_id+"&&pin="+pin+"&&command=district_show",function(data,status){
						$("#show_sample").html(data); 
					});
					
				 });
				 $("#manager_type").change(function(){					
					$.get("autosearch-y/appointment.php?manager=add&reporting_to="+$(this).val()+"",function(data,status){
						$("#show_manager").html(data); 
					});
				});	
				
			});	
			function deleteMe(id){	
				$.get("autosearch-y/appointment.php?proposed_del=delete&product_proposed_id="+id+"",function(data,status){
					$("#show_dis").html(data); 
				});				
			}
			function delMe(id){	
				$.get("autosearch-y/appointment.php?sample_del=delete&product_proposed_id="+id+"",function(data,status){
					$("#show_sample").html(data); 
				});				
			}
			</script>
            
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <link rel="stylesheet" href="slick_dtp.css">
            <script src="slick_dtp.js"></script>            
            <script>
            $(function() {
                var slickDTP = new SlickDTP();
                
                $( "#mysqldate" ).click(function() {
                    slickDTP.pickDate('#mysqldate','#prettydate');
                });
					
            });//end ready
			
			
			
			$('#add').click(function() {
				$("#Chemist,#Stockist").hide();
				if($('#add').attr('checked')) {
					$("#Doctor").show();
				} else {
					$("#Chemist,#Stockist").hide();
				}
			});	
			$('#add2').click(function() {
				$("#Doctor,#Stockist").hide();
				if($('#add2').attr('checked')) {
					$("#Chemist").show();
				} else {
					$("#Doctor,#Stockist").hide();
				}
			});
			$('#add3').click(function() {
				$("#Doctor,#Chemist").hide();
				if($('#add3').attr('checked')) {
					$("#Stockist").show();
				} else {
					$("#Doctor,#Chemist").hide();
				}
			});	
			$("#submit").click(function(){
				var favorite = [];
				$.each($("input[name='y[]']:checked"), function(){            
				favorite.push($(this).val());
				});
				var pin =favorite;
				$.get("autosearch-y/appointment.php?yuvaraj=rdy&pin="+pin+"&s_date="+$("#from_date").val()+"&worktype="+$("input[name='type_of_work']:checked").val()+"&rep_id="+<?php echo $_SESSION["repid"]; ?>+"",function(data,status){
						alert(data);
						window.location.href="doctor_appointment.php";
						
					});
				});
            </script>
            <script>
			$(function() {
			$( "#from_date,#to_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1990:2020",
			dateFormat:"yy-mm-dd"
			});
			
			//ajax Ends
			});
			/*$(".Report").click(function(data){
				alert($(this).closest('tr').find('textarea').val());
			});*/
			</script>
            
</body>
</html>
<?php
}
?>
