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
	mysql_query("INSERT INTO tbl_dc_appiontment(pin_id,appiontment_for,dc_id,appiontment_time,sample_request,type_of_work,manager_type,report,type_of_call,comments,c_date,c_time) VALUES('".$_REQUEST["doc_pincode"]."','".$_REQUEST["appiontment_for"]."','".$_REQUEST["doctor"]."','".$_REQUEST["appiontment_time"]."','".$_REQUEST["sample_request"]."','".$_REQUEST["type_of_work"]."','".$_REQUEST["manager_type"]."','".$_REQUEST["report"]."','".$_REQUEST["type_of_call"]."','".$_REQUEST["comments"]."','".date("Y/m/d")."','".date("H:i:s")."')");
	$last_Id=mysql_insert_id();
	mysql_query("UPDATE tbl_product_proposed SET appointment_id=".$last_Id." WHERE appointment_id=0");
	header("location:doctor_appointment.php");
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
<h2><i class="icon-edit"></i>DOCTOR / CHEMIST / STOCKIST SCHEDULE</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
  <div class="control-group"> 
    <label class="control-label" for="typeahead">Schedule Date<span style="color:#FF0000;">*</span></label>
    <div class="controls"> 
    	<input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/>
    </div></div> 

<div class="control-group"> 
    <label class="control-label" for="typeahead">Schedule for<span style="color:#FF0000;">*</span></label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="appiontment_for" id="add" value="D" class="dc"> Doctor
       </label>
       <label class="radio">
           <input type="radio" name="appiontment_for" id="add2" class="dc" value="C"> Chemist
       </label> 
       <label class="radio">
           <input type="radio" name="appiontment_for" id="add3" class="dc" value="S"> Stockist
       </label>       
    </div>
</div>  

<div class="control-group" id="Doctor" style="display:none"> 
    <label class="control-label" for="typeahead">DOCTOR LIST<span style="color:#FF0000;">*</span></label>
    <div class="controls">
    	<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Select</th>
<th>S.NO</th>
<th>Doctor Name</th>
<?php if($_SESSION['repid']==""){ ?><th>Rep</th> <?php } ?>
<th>Address</th>
<th>Pincode</th>
<?php if($_SESSION['repid']==""){ ?>
<th>Edit</th>
<th>Delete</th>
<th>Location</th>
<?php } ?>
</tr>
</thead>   
<tbody>
<?php
if($_SESSION['repid']==""){
	$a=mysql_query("SELECT doctors.id as id,doctors.doc_pin_id as doc_pin_id,doctors.doctor_name as doctor_name,doctors.doc_qualification as doc_qualification,doctors.doc_specilist_id as doc_specilist_id,doctors.doctor_addrs as doctor_addrs,master_pincode.pincode as pincode,representative.rep_name as rep_name FROM doctors,master_pincode,representative WHERE doctors.doc_pin_id=master_pincode.pin_id AND doctors.rep_id=representative.id ORDER BY doctors.id");
}if($_SESSION['repid']!=""){	
	$a=mysql_query("SELECT doctors.id as id,doctors.doc_pin_id as doc_pin_id,doctors.doctor_name as doctor_name,doctors.doc_qualification as doc_qualification,doctors.doc_specilist_id as doc_specilist_id,doctors.doctor_addrs as doctor_addrs,master_pincode.pincode as pincode,representative.rep_name as rep_name FROM doctors,master_pincode,representative WHERE doctors.doc_pin_id=master_pincode.pin_id AND doctors.rep_id=representative.id AND representative.id='".$_SESSION['repid']."' ORDER BY doctors.id");
}	
$count_a=mysql_num_rows($a);
$x=1;
if($count_a > 0)
{
while($row_a=mysql_fetch_array($a))
     { 
        
        ?> 
        <tr>
        	<td><input type="checkbox" name="y[]" value="<?php echo "D ".$row_a["id"]; ?>"></td>
            <td><?=$x;?></td>
            <td><?=$row_a['doctor_name'];?></td>
            <?php if($_SESSION['repid']==""){ ?><td><?=$row_a['rep_name'];?></td><?php } ?> 
            <td><?=$row_a['doctor_addrs'];?></td>     
            <td><?=$row_a['pincode'];?></td>
            <?php if($_SESSION['repid']==""){ ?>
            <td><a href="edit_doctor.php?DID=<?=$row_a['id'];?>"><img src="img/edition2.png" width="32" height="32" alt="Doctor Edit"></a></td>            
            <td><a href="#"><img src="img/delete119.png" width="32" height="32" onClick="yuvaraj(<?=$row_a['id'];?>,<?=$row_a['doc_pin_id'];?>);" alt="Doctor Delete"></a></td>
            <td><img src="img/show_map.png" width="32" height="32" alt="Doctor Location"></td>
            <?php } ?>
        </tr>
<?php
     $x++;
     }
}
else
{ 
?>
        <tr><td colspan="9" align="center">No Data Found</td></tr>    
<?php 
} 
?>
</tbody>
</table>
		
	</div>
</div>

<div class="control-group" id="Chemist" style="display:none"> 
    <label class="control-label" for="typeahead">CHEMIST LIST<span style="color:#FF0000;">*</span></label>
    <div class="controls">
    	<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Select</th>
<th>S.NO</th>
<th>Chemist Name</th>
<th>Pincode</th>
<th>Doctor / Floating</th>
</tr>
</thead>   
<tbody>
<?php
if($_SESSION['repid']==""){
$a=mysql_query("select * from tbl_customer_master order by id desc")or die(mysql_error());
}if($_SESSION['repid']!=""){$a=mysql_query("select * from tbl_customer_master where rep_id='".$_SESSION["repid"]."' order by id desc")or die(mysql_error());}
$count_a=mysql_num_rows($a);
$x=1;
if($count_a > 0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<tr>
<td><input type="checkbox" name="y[]" value="<?php echo "C ".$row_a["id"]; ?>"></td>
<td><?=$x;?></td>
<td><?php echo $row_a["shop_name"]; ?></td>
<td><?php echo $row_a["pincode"]; ?></td>
<td><?php 
        if($row_a['doctor_id'] =='')
            { 
               echo "Floating"; 
            } 
            else  
            {
               $DR=mysql_query("SELECT doctor_name,doc_pincode FROM doctors WHERE id IN (".$row_a['doctor_id'].")"); while($D=mysql_fetch_object($DR)){ @$DOCTOR.=$D->doctor_name." - ".$D->doc_pincode.", ";}
			   echo substr(@$DOCTOR,1,-2);
            }?>
        </td>
<?php $x++;} ?>
</tr>
<?php
}
?>

</tbody>
</table>
	</div>
</div>


<div class="control-group" id="Stockist" style="display:none"> 
    <label class="control-label" for="typeahead">STOCKIST LIST<span style="color:#FF0000;">*</span></label>
    <div class="controls">
    	<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Select</th>
<th>S.No</th>
<th>Distributor Name</th>
<th>Distributor Id</th>
<th>Distributor Abbrevation</th>
<th>Contact Person</th>
<th>Contact Person Number</th>
<?php if($_SESSION['repid']==""){ ?><th>Action</th><?php } ?>
</tr>
</thead>   
<tbody>
<?php
if($_SESSION['repid']==""){
$a=mysql_query("select * from distributor")or die(mysql_error());
}if($_SESSION['repid']!=""){$a=mysql_query("select * from distributor where 1")or die(mysql_error());}
$x=1;
while($row_res=mysql_fetch_array($a))
{
$d_id=$row_res['id'];
$dis_name=$row_res['dis_name'];
$dis_id=$row_res['dis_id'];
$dis_abb=$row_res['dis_abb'];
$cp_name=$row_res['cp_name'];
$cp_no=$row_res['cp_no'];

?>
<tr>

<td><input type="checkbox" name="y[]" value="<?php echo "S ".$d_id; ?>"></td><td><?=$x;?></td>
<td><?php echo $dis_name; ?></td>
<td><?php echo $dis_id; ?></td>
<td><?php echo $dis_abb; ?></td>
<td><?php echo $cp_name; ?></td>
<td><?php echo $cp_no; ?></td>
<?php if($_SESSION['repid']==""){ ?>
<td class="center" style="width:17%;">
    <a class="btn btn-info" href="edit_distributor.php?d_id=<?php echo encrypt($d_id); ?>)"><i class="icon-edit icon-white"></i>Edit
    </a>
    <a class="btn btn-danger" href="delete.php?d_id=<?php echo $d_id; ?>&comm=distributor" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-white"></i> Delete</a>
</td>
<?php } ?>
</tr>
<?php
$x++;}
?>

</tbody>
</table>
	</div>
</div>

<!--<div class="control-group"><label class="control-label" for="typeahead">Appiontment Time<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<input type="text" value="" name="appiontment_time" id="mysqldate" />
</div></div>-->

<div class="control-group"> 
    <label class="control-label" for="typeahead">Type of Work<span style="color:#FF0000;">*</span></label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="type_of_work" id="Individual" value="0" checked> Individual
       </label>
       <label class="radio">
           <input type="radio" name="type_of_work" id="Joint" value="1" > Joint
       </label>       
    </div>
</div>



<div class="form-actions"><input type="button" class="btn btn-primary" name="submit" id="submit" value="submit" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>

</fieldset>
</form>
</div>
</div>
</div>

</div>



<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>DOCTOR / CHEMIST / STOCKIST REPORT</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
  <div class="control-group"> 
    <label class="control-label" for="typeahead">Schedule Date<span style="color:#FF0000;">*</span></label>
    <div class="controls"> 
    	<input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/>
    </div></div> 


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>
<?php if(@$_REQUEST["submit"]=="Report"){ ?>
	<table class="table table-bordered">
    	<?php						
			$Report = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$_SESSION["repid"]."' and wp_date='".$_REQUEST["to_date"]."' ");
			$RCNT = mysql_num_rows($Report);
			$Type="";
			if($RCNT==0){
				echo "<div>No Schedule Available</div>";
			}
			if($RCNT>0){
				$i=1;
				while($R=mysql_fetch_object($Report)){
					if($R->wp_dc=="D"){@$Type="DOCTOR";}if($R->wp_dc=="C"){@$Type="CHYMIST";}if($R->wp_dc=="S"){@$Type="STOCKIST";}
					$DR=mysql_query("SELECT doctor_name FROM doctors,tbl_work_plan WHERE id=".$R->wp_dc_id." and wp_rep_id='".$_SESSION["repid"]."' and wp_date='".$_REQUEST["to_date"]."' and wp_dc='D' and tbl_work_plan.wp_dc_id=doctors.id;");
					$D=mysql_fetch_object($DR);if($R->wp_dc=="D"){$DCS=$D->doctor_name;}
					$ST=mysql_query("SELECT dis_name FROM distributor,tbl_work_plan WHERE id=".$R->wp_dc_id." and wp_rep_id='".$_SESSION["repid"]."' and wp_date='".$_REQUEST["to_date"]."' and wp_dc='S' and tbl_work_plan.wp_dc_id=distributor.id;");
					$S=mysql_fetch_object($ST);if($R->wp_dc=="S"){$DCS=$S->dis_name;}
					if($R->drunavailablereason==""){
					echo "<tr><td>$i</td><td hidden>".$R->wp_id."</td><td>".$Type."</td><td>".$DCS."</td><td><a href=\"appointment_report.php?wp_id=$R->wp_id&wp_dc=$R->wp_dc\" class=\"btn btn-primary Report\" target=\"_blank\">Report Submit</a></td></tr>";
					}if($R->drunavailablereason!=""){
					echo "<tr><td>$i</td><td hidden>".$R->wp_id."</td><td>".$Type."</td><td>".$DCS."</td><td>".$R->drunavailablereason."</td></tr>";
					}
				$i++;}
			}
		?>    
    </table>
<?php		
	}
?>
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
