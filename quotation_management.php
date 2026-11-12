<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id'])){
		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}else{	

	if(@$_REQUEST['submit']=='Submit'){
		$rep_id=@$_REQUEST['rep_id'];
		$doctor_id=@$_REQUEST['doctor_id'];
		$product=@$_REQUEST['product'];
		$ptr_val=@$_REQUEST['ptr_val'];
		$perval=@$_REQUEST['perval'];
		$negotiation=@$_REQUEST['negotiation'];

		if($perval=='percentage'){
			$value=($negotiation*$ptr_val)/100;
		}elseif($perval=='value'){
			$value=$negotiation;
		}

		mysql_query("INSERT INTO quotation_management(rep_id,doctor_id,product,original_rate,perval_type,comm_perval) VALUES('$rep_id','$doctor_id','$product','$ptr_val','$perval','$value')");
		header("location: quotation_management_verify.php");
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
  <link href="datepicker/calendar.css" type="text/css" rel="stylesheet" />
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

<script type="text/javascript" src="jquery.js"></script>
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

<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Quotation Management</h2>
<span style="padding-left:800px"><a href="quotation_management_verify.php" class="btn btn-primary">Back</a></span>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" name="frm">
<input type="hidden" name="rep_id" id="rep_id" value="<?php echo @$_SESSION["id"]; ?>" />
  <fieldset>
	<div class="control-group">
	    <label class="control-label" for="typeahead">Doctor:<span style="color:#FF0000;">*</span> </label>
	    <div class="controls">
	        <select name="doctor_id" id="doctor_id" data-rel="chosen" required> 
	            <option value="">---select Doctor---</option>
	            <?php
	            $SQL=mysql_query("SELECT * FROM doctors WHERE doctor_name!=''");
	            $co_mana=mysql_num_rows($SQL);
	            if($co_mana > 0){
	                while($row_ma=mysql_fetch_object($SQL)) { ?>
	               <option value="<?=@$row_ma->id;?>"><?=@$row_ma->doctor_name;?></option>                   
	     		<?php }}else{ ?>
	                <option value="">No Doctor Avaliable</option>            
	    		<?php } ?>
	        </select>
	    </div>
	</div>

	<div class="control-group">
	    <label class="control-label" for="typeahead">Product:<span style="color:#FF0000;">*</span> </label>
	    <div class="controls">
	        <select name="product" id="product" data-rel="chosen" required> 
	            <option value="">---select Product---</option>
	            <?php
	            $SQL=mysql_query("SELECT * FROM product WHERE pro_name!=''");
	            $co_mana=mysql_num_rows($SQL);
	            if($co_mana > 0){
	                while($row_ma=mysql_fetch_object($SQL)) { ?>
	               <option value="<?=@$row_ma->id;?>"><?=@$row_ma->pro_name;?></option>                   
	     		<?php }}else{ ?>
	                <option value="">No Product Avaliable</option>            
	    		<?php } ?>
	        </select>
	    </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="typeahead">PTR:</label>
	  <div class="controls">
	      <input type="text" name="ptr_val" id="ptr_val" readonly>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="typeahead">PTS:</label>
	  <div class="controls">
	      <input type="text" name="pts_val" id="pts_val" readonly>
	  </div>
	</div>

	<div class="control-group">
	    <label class="control-label" for="typeahead">Select Type:</label>
	    <div class="controls"> 
	       <label class="radio">
	           <input type="radio" name="perval" id="val" value="value" checked>
	           Value
	       </label>
	       <label class="radio">
	           <input type="radio" name="perval" id="per" value="percentage"> 
	           Percentage
	       </label>
	    </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="typeahead">Negotiation:</label>
	  <div class="controls">
	      <input type="text" name="negotiation" style="width: 130px;" required>
	      <span id="show_per" hidden> %</span>
	  </div>
	</div>

	<div class="form-actions">
		<input type="submit" class="btn btn-primary" name="submit" value="Submit" />
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
<?php include("include/footer.php"); ?>

</div>

<script src="js/jsl.js" type="text/javascript"></script>
<script src="js/common.js" type="text/javascript"></script>
<script src="datepicker/calendar.js" type="text/javascript"></script>
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
	$("#val").click(function(){
		$("#show_per").hide();
	});


	$("#per").click(function(){
		$("#show_per").show();
	});


	$("#product").change(function(){
		var id=$(this).val();
		$.ajax({
			url:"quotation_operations.php",
			data:{id:id,condition:'show_val'},
			success: function(result){
				var data = eval('(' + result + ')');
				$("#ptr_val").val(data[0].ptr);
				$("#pts_val").val(data[0].ptr);
			}
		});
	});
</script>

</body>
</html>
<?php
}

