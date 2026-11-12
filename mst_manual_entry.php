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
		$(function() {

			$("#dd_user_input,#dd_user_input2").autocomplete({
				source: "autosearch-y/customer_search.php",
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

			$("#dd_user_input1").autocomplete({
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

			$("#dd_user_input4").autocomplete({
				source: "autosearch-y/pincode_search.php",
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
		function manual_master(date,dist){
			window.location.href="mst_manual_entry.php?ldate="+date+"&distributor="+dist;
		}
		function manual_distributor(dist){
			window.location.href="mst_manual_entry.php?distributor="+dist;
		}
		function c_p(){		
			if(document.getElementById('b_no').checked==true){
				document.getElementById('bill_no').readOnly = true;
			}
			if(document.getElementById('b_no').checked==false){
				document.getElementById('bill_no').readOnly = false;
			}
			if(document.getElementById('b_date').checked==true){
				document.getElementById('bill_date').readOnly = true;
			}
			if(document.getElementById('b_date').checked==false){
				document.getElementById('bill_date').readOnly = false;
			}
		}
		function master(v){		
			var str=$("#dd_user_input1").val();
			var product=str.replace("+",'/');
			var batch=$("#batch_id").val();

			$.post("autosearch-y/manual_entry.php?bill_no="+$("#bill_no").val()+"&bill_date="+$("#bill_date").val()+"&dd_user_input="+$("#dd_user_input").val()+"&dd_user_input1="+product+"&batch="+batch+"&qty="+$("#qty").val()+"&rqty="+$("#rqty").val()+"&fqty="+$("#fqty").val()+"&dist="+$("#dist_id").val()+"&billdate="+$("#month").val(),function(data,status){});
		//$("#display").load("mst_manual_entry_view.php");		
		

		if(v=="product"){
			document.getElementById('dd_user_input1').value="";		
			document.getElementById('dd_user_input1').focus();
		}
		if(v=="customer"){
			document.getElementById('dd_user_input').value="";		
			document.getElementById('dd_user_input').focus();
		}
		
		$("#display").load('mst_manual_entry_view.php');
		
	}
	function Customer_master(){
		$.post("autosearch-y/our_division_customer.php?customer="+$("#dd_user_input2").val()+"&pincode="+$("#dd_user_input4").val(),function(data,status){
			alert(data);});
	}
	function del(delId){
		
		$.post("autosearch-y/mst_manual_entry_del.php?delId="+delId,function(data,status){});
		
		$("#display").load('mst_manual_entry_view.php');

	}
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
<script type="text/javascript" src="jquery.js"></script>
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
							<h2><i class="icon-edit"></i>MONTH WISE MANUAL SALE ENTRY</h2>
							<div class="box-icon">
							</div>
						</div>
						<div class="box-content">
							<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
								<input type="hidden" name="command" id="command" value="add_csv" />

								<input type="hidden" name="sess_id" id="sess_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="syst_id" id="syst_id" value="<?php echo $m_id16; ?>" />

								<fieldset>
									<div class="control-group">
										<label class="control-label" for="typeahead"><span>Distributor's Name</span><span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<select  id="dist_id" name="dist_id" data-rel="chosen" required onChange="manual_distributor(this.value);">
												<option value="">--Select--</option>
												<?php
												while($row_res=mysql_fetch_array($res))
												{
													$dis_name=$row_res['dis_name'];
													$dist_id=$row_res['dis_id'];
													?>
													<option value="<?php echo $dist_id; ?>"><?php echo $dis_name; ?></option>
													<?php
												}
												?> 
											</select>
											<script>document.getElementById('dist_id').value="<?php echo $_REQUEST["distributor"]; ?>";</script>

											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="vertical-align:top;padding-left:117px">Month &amp; Year</span>&nbsp;&nbsp;<span style="color:#FF0000; vertical-align:top;">*</span>&nbsp;&nbsp;&nbsp;&nbsp;
											<select  id="month" name="month" data-rel="chosen" required onChange="manual_master(this.value, document.getElementById('dist_id').value);">
												<option value="">--Select--</option>
												<?php
												for($i=12;$i>=1;$i--){	
													$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");	
													while($RS=mysql_fetch_object($SQL)){
														?>
														<option value="<?php echo date("Y/m/d",strtotime($RS->LastDay)).','.date("F Y",strtotime($RS->FirstDay)); ?>"><?php echo date("F Y",strtotime($RS->FirstDay)); ?></option>
														<?php
													}
												}
												?> 
											</select>
											<script>document.getElementById('month').value="<?php echo $_REQUEST["ldate"]; ?>";</script>
										</div>
									</div>

									<div class="control-group" id="bill"><label class="control-label" for="typeahead">BILL DETAILS<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<input type="checkbox" name="" id="b_no" onClick="c_p();" value="BILL NO NOT AVAILABLE">BILL NO NOT AVAILABLE&nbsp;&nbsp;&nbsp;<input type="checkbox" name="checkbox" id="b_date" onClick="c_p();" value="BILL DATE NOT AVAILABLE">BILL DATE NOT AVAILABLE
										</div>
									</div>
									<table width="100%" cellpadding="5" cellspacing="7">
										<tr>
											<th colspan="4" align="left">ADD OUR CUSTOMER<span style="color:#FF0000;">*</span></th>
										</tr>
										<tr>
											<td>CUSTOMER</td>
											<td colspan="3"><input id="dd_user_input2" type="text" name="cust_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["cust_name"]!=""){ ?>value="<?php echo @$_REQUEST["cust_name"]; ?>"<?php }else{ ?>value="" <?php } ?> tabindex="1" required /></td>
										</tr>
										<tr>
											<td>PINCODE</td>
											<td colspan="3"><input id="dd_user_input4" type="text" name="pincode" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["pincode"]!=""){ ?>value="<?php echo @$_REQUEST["pincode"]; ?>"<?php }else{ ?>value="" <?php } ?>  tabindex="2"  required />&nbsp;&nbsp;<img src="img/new_customer.png" width="60" height="60" onClick="Customer_master();"></td>
										</tr>	
									</table>
									<table width="100%" cellpadding="5" cellspacing="7">
										<tr>
											<th colspan="4" align="left">SALE ENTRY <span style="color:#FF0000;">*</span></th>
										</tr>	
										<tr>
											<td>CUSTOMER</td>
											<td colspan="3"><input id="dd_user_input" type="text" name="cust_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["cust_name"]!=""){ ?>value="<?php echo @$_REQUEST["cust_name"]; ?>"<?php }else{ ?>value="" <?php } ?> tabindex="3" required/></td>
										</tr>
										<tr>
											<td>PRODUCT</td>
											<td colspan="3"><input id="dd_user_input1" type="text" name="product_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["product_name"]!=""){ ?>value="<?php echo @$_REQUEST["product_name"]; ?>"<?php }else{ ?>value="" <?php } ?> tabindex="4" required/></td>
										</tr>
										<tr>
											<td>BATCH NO</td>
											<td colspan="3" style="padding-left:15px;">
												<select  id="batch_id" name="batch_id">
													<option value="">--Select--</option>
												</select>
												<div id="show_batch_price"></div>
											</td>
										</tr>
										<tr>
											<td>BILL NO</td>
											<td style="padding-left:15px;"><input type="text" name="bill_no" id="bill_no" tabindex="5"></td>
											<td>BILL DATE</td><td><input type="text" name="bill_date" id="bill_date" tabindex="6"></td>
										</tr>
										<tr>
											<td>QUANTITY</td>
											<td style="padding-left:15px;"><input type="text" name="bill_no" id="qty" value="1" tabindex="7"></td>
											<td>FREE QUANTITY</td><td><input type="text" name="bill_date" id="fqty" value="0" tabindex="8"></td>
										</tr>    
										<tr>
											<td>REPLACE QUANTITY</td>
											<td colspan="1" style="padding-left:15px;"><input type="text" name="bill_no" id="rqty" value="0" tabindex="9"></td>
											<td colspan="2"><img src="img/add_product48X48.png" width="55" height="55" onClick="master('product');">&nbsp;&nbsp;<img src="img/add_customer48X48.png" width="55" height="55" onClick="master('customer');"></td>
										</tr>
									</table>

									<div id="display"></div>

								</fieldset>
							</form>
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#dd_user_input1").blur(function(){
			$.ajax({
				url:"mst_manual_entry_view_new.php",
				type:"post",
				data:"pro_name="+$("#dd_user_input1").val()+"&condition=get_batchs",
				success:function(data){
					$("#batch_id").html(data);
				}
			});
		});

		$("#batch_id").change(function(){
			$.ajax({
				url:"mst_manual_entry_view_new.php",
				type:"post",
				data:"batch_id="+$("#batch_id").val()+"&condition=get_batch_price",
				success:function(data){
					$("#show_batch_price").html(data);
				}
			});
		});

		$('#submit').click(function(){
			if($("#excel_file").val()===""){
				alert("Please Upload xls File");
				return false; 
			}
			else{
				var fup = document.getElementById('excel_file');
				var fileName = fup.value;
				var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
				if(ext === "xls" || ext === "xlsx"){
					return true;
				}else
				{
					alert("Upload xls File only");
					$("#excel_file").val('');
					return false;
				}
			}
		});
		return true;
	});
</script>	
</body>
</html>
<?php
}
