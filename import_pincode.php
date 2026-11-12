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
require_once("include/select.php");
$ad=new select1();
$dist=$ad->view('district','','');
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
    <script type = "text/javascript">
function showMessage(which) {
if (which == 1) {
document.getElementById("fine").style.display = "block";
document.getElementById("fill").style.display = "none";
}
else {
document.getElementById("fine").style.display = "none";
document.getElementById("fill").style.display = "block";
}
}
</script>
     <script type="text/javascript">
function valid()
{
var x=document.getElementById("state_name").value;
if(x=="null" || x=="")
{
alert("Please Enter State Name");
return false; 
}
return true;
}
</script>
<script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
$(document).ready(function()
	 {
    $('#submit').click(function()
	 {
	  if($("#userfile").val()=="")
		{
		alert("Please Upload Csv File");
		return false; 
		}
		else
		{
		var fup = document.getElementById('userfile');
        var fileName = fup.value;
		//alert(fileName);
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
		
		    if(ext =="csv")
    {
        return true;
    }
    else
    {
        alert("Upload Csv File only");
	 return false;
    }
		}
		
	});
	return true;
});
</script>
<!--************************Image Script Start***************************-->

    
<!--<script type="text/javascript">
// Load this script once the document is ready
	$(document).ready(function () {
		alert('122');
		// Get all the thumbnail
		$('div.thumbnail-item').mouseenter(function(e) {
		
	alert('122');
			// Calculate the position of the image tooltip
			x = e.pageX - $(this).offset().left;
			y = e.pageY - $(this).offset().top;

			// Set the z-index of the current item, 
			// make sure it's greater than the rest of thumbnail items
			// Set the position and display the image tooltip
			$(this).css('z-index','15')
			.children("div.tooltip")
			.css({'top': y + 10,'left': x + 20,'display':'block'});
			
		}).mousemove(function(e) {
			
			// Calculate the position of the image tooltip			
			x = e.pageX - $(this).offset().left;
			y = e.pageY - $(this).offset().top;
			
			// This line causes the tooltip will follow the mouse pointer
			$(this).children("div.tooltip").css({'top': y + 10,'left': x + 20});
			
		}).mouseleave(function() {
			
			// Reset the z-index and hide the image tooltip 
			$(this).css('z-index','1')
			.children("div.tooltip")
			.animate({"opacity": "hide"}, "fast");
		});

	});
</script>-->
<!--<style>

.thumbnail-item { 
	/* position relative so that we can use position absolute for the tooltip */
	position: relative; 
	float: left;  
	margin: 0px 5px; 
}

.thumbnail-item a { 
	display: block; 
}

.thumbnail-item img.thumbnail {
	border:3px solid #ccc;	
}
		
.tooltip { 
	/* by default, hide it */
	display: none; 
	/* allow us to move the tooltip */
	position: absolute; 
	/* align the image properly */
	padding: 8px 0 0 8px; 
}

	.tooltip span.overlay { 
		/* the png image, need ie6 hack though */
		background: url(img/overlay.png) no-repeat; 
		/* put this overlay on the top of the tooltip image */
		position: absolute; 
		top: 0px; 
		left: 0px; 
		display: block; 
		width: 350px; 
		height: 200px;
	}
	</style>-->
<!--************************Image Script End***************************-->
</head>

<body>
		<!-- topbar starts -->
	<?php include("include/header.php"); ?>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
		<?php include("include/menu.php"); ?>
			
			<noscript>
				<div class="alert alert-block span10">
					<!--<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>-->
				</div>
			</noscript>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Import Pincode or district in Excel Format</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="pincode_import.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_pincode" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->


<div class="control-group"><label class="control-label" for="typeahead">State Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="state_name" name="state_name" data-rel="chosen">
<option value="">--Select--</option>
<option value="tamilnadu">Tamilnadu</option>
<option value="andhrapradesh">Andhra pradesh</option>
<option value="kerala">Kerala</option>
<option value="karnataka">Karnataka</option>
</select></div></div>



<div class="control-group"><label class="control-label">Select Category<span style="color:#FF0000;">*</span> </label><div class="controls">
<label class="radio"><input type="radio" name="add" id="add" value="1"  onclick ="showMessage(1)" >Add District </label>
<label class="radio"><input type="radio" name="add" id="add" value="2" onclick ="showMessage(2)"> Add Area Pincode </label></div></div>



 <div id="fine" style="display:none">
 
<!-- <div class="control-group"><label class="control-label" for="typeahead">Add District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="dist_name" id="dist_name" /></div></div>-->

<div style="background:#CCCCCC; border-radius:5px;">

<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000; font-size:16px; font-weight:bold;">Match Column Names :</span></label>
<div class="controls">
<ul class="thumbnails gallery"><li id="image-1" class="thumbnail" style="height:10px; width:10px;">
<a title="How to Match Column Name" href="img/district.png"><img class="grayscale" src="img/help.gif" alt="How to Match Column Name" style="height:10px; width:10px;">Help</a>
</li></ul>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="dist_name123" id="dist_name123" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"></div></div>

</div>
 
 </div>
 

    <div id="fill" style="display:none">
    
     <div class="control-group"><label class="control-label" for="typeahead">District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($dist_res=mysql_fetch_array($dist))
{
$dist_name=$dist_res['dist_name'];
$dist_id=$dist_res['id'];
?>
<option value="<?php echo $dist_id; ?>"><?php echo $dist_name; ?></option>
<?php } ?> 
</select></div></div>

<div style="background:#CCCCCC; border-radius:5px;">
<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000; font-size:16px; font-weight:bold;">Match Column Names :</span></label>
<div class="controls">

<ul class="thumbnails gallery"><li id="image-1" class="thumbnail" style="height:10px; width:10px;">
<a title="How to Match Column Name" href="img/clear.png"><img class="grayscale" src="img/help.gif" alt="How to Match Column Name" style="height:10px; width:10px;">Help</a>
</li></ul>

</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="area_name123" id="area_name123" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="pincode123" id="pincode123" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"></div></div>
</div>





</div>

<div class="control-group"><label class="control-label" for="typeahead">Import File<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="file" name="userfile" id="userfile" /></div></div>


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();"  /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
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
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
		
</body>
</html>
<?php
}
?>
