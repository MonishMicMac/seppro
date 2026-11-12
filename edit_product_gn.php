<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{

	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
	include("encrypt.php");
	if(isset($_REQUEST['d_id'])) 
	{
		$d_id=decrypt($_REQUEST['d_id']);
	}

	if(@$_REQUEST['command']=='edit_product'){

		mysql_query("UPDATE product SET category_id='".$_REQUEST['pro_category']."',pro_name='".$_REQUEST['pro_name']."',sku_id='".$_REQUEST['sku_id']."',cgst='".$_REQUEST['cgst']."',sgst='".$_REQUEST['sgst']."',igst='".$_REQUEST['igst']."',status='".$_REQUEST['status']."' WHERE id='".$_REQUEST['auto_id']."'");

		echo "<script type='text/javascript'>alert('Product Updated!'); window.location='view_product_gn.php'</script>";
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
		function valid()
		{
			var x=document.getElementById("mark_id").value;
			if(x=="null" || x=="")
			{
				alert("Please Enter Marketer Name");
				return false; 
			}
			var z=document.getElementById("pro_name").value;
			if(z=="null" || z=="")
			{
				alert("Please Enter Product Name");
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
							<h2><i class="icon-edit"></i>Edit Product</h2>
							<div class="box-icon">
							</div>
						</div>
						<div class="box-content">

							<?php
							$sql=mysql_query("SELECT * FROM product WHERE id='$d_id'");
							$row=mysql_fetch_array($sql);
							?>

							<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" onsubmit="return validate_form();">
								<input type="hidden" name="command" id="command" value="edit_product" />
								<input type="hidden" name="auto_id" id="auto_id" value="<?php echo $row['id']; ?>" />
								<fieldset>
									<div class="control-group">
										<div class="controls" style="float:right;">
											<a class="btn btn-info" href="view_product_gn.php">Back</a>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="pro_category">Product Category<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<select class="input-xlarge focused" name="pro_category" id="pro_category">
												<option value="">-- Select Category --</option>
												<?php
												$sql_category=mysql_query("SELECT id,product_category FROM product_category WHERE status='1'");
												while($row_category=mysql_fetch_array($sql_category)){
													?>
													<option value="<?php echo $row_category['id']; ?>" <?php echo ($row_category['id']==$row['category_id'])?'selected':''; ?>><?php echo $row_category['product_category']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="pro_name">Product Name<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<input class="input-xlarge focused"  type="text" name="pro_name" id="pro_name" value="<?php echo $row['pro_name']; ?>" />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="sku_id">SKU Name<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<select class="input-xlarge focused" name="sku_id" id="sku_id">
												<option value="">-- Select SKU --</option>
												<?php
												$sql_sku=mysql_query("SELECT id,sku_name FROM stock_keeping_unit WHERE status='1'");
												while($row_sku=mysql_fetch_array($sql_sku)){
													?>
													<option value="<?php echo $row_sku['id']; ?>" <?php echo ($row_sku['id']==$row['sku_id'])?'selected':''; ?>><?php echo $row_sku['sku_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="cgst">CGST %<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<input class="input-xlarge focused"  type="text" name="cgst" id="cgst" value="<?php echo $row['cgst']; ?>" onkeypress="return numbers();" />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="sgst">SGST %<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<input class="input-xlarge focused"  type="text" name="sgst" id="sgst" value="<?php echo $row['sgst']; ?>" onkeypress="return numbers();" />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="igst">IGST %<span style="color:#FF0000;">*</span> </label>
										<div class="controls">
											<input class="input-xlarge focused"  type="text" name="igst" id="igst" value="<?php echo $row['igst']; ?>" onkeypress="return numbers();" />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="status">Active </label>
										<div class="controls">
											<input class="input-xlarge focused" type="checkbox" name="status" id="status" value="1" <?php echo ($row['status']=='1')?'checked':''; ?> />
										</div>
									</div>

									<div class="form-actions">
										<input type="submit" class="btn btn-primary" name="submit" value="submit" /> 
										<input type="reset" class="btn" value="Cancel" />
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>
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
		function validateEmail(email)
		{
			var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			if (reg.test(email)){
				return true;
			}else{
				return false;
			}
		}
		function numbers() {
			if (event.keyCode < 47 || event.keyCode > 57) {
				event.returnValue = false;
			}
		}
		function numberswithdot() {
			if (event.keyCode < 45 || event.keyCode > 57  && event.keyCode!= 47 ) {
				event.returnValue = false;
			}

		}
		function alphabets(e)
		{
			var key = e.keyCode;
			if (key >= 48 && key <= 57) {
				e.preventDefault();
			}
		}
		function isNumber(evt, element)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (
				(charCode != 45 || $(element).val().indexOf('-') != -1) &&
				(charCode != 46 || $(element).val().indexOf('.') != -1) &&
				(charCode < 48 || charCode > 57))
				return false;

			return true;
		} 

		function validate_form()
		{
			if ($('#pro_category').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please Select the Product Category.');
				$('#pro_category').focus();
				return false;
			}
			if ($('#pro_name').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please enter the Product Name.');
				$('#pro_name').focus();
				return false;
			}
			if ($('#sku_id').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please Select the SKU Name.');
				$('#sku_id').focus();
				return false;
			}
			if ($('#cgst').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please enter the CGST.');
				$('#cgst').focus();
				return false;
			}
			if ($('#sgst').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please enter the SGST.');
				$('#sgst').focus();
				return false;
			}
			if ($('#igst').val().trim() == "")
			{
				$('.feedback').show();
				$('.feedback').html('Please enter the IGST.');
				$('#igst').focus();
				return false;
			}
			return true;
		}
	</script>
</body>
</html>
<?php
}
?>
