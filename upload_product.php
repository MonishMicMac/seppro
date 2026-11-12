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
	if(isset($_POST['command']))
{
$command=$_POST['command'];
if($command=='add_product')
{
$dist_id1=$_POST['dist_id1'];
$_SESSION['dist_id1']=$dist_id1;
echo "<script type='text/javascript'>window.location='match_product.php'</script>";
}
}
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
$res1=$ad->view('dist_prod','where mark_id='.$m_id16,'order by id desc');
$res4=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
   <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
function valid()
{
var x=document.getElementById("dist_id").value;
if(x==="null" || x==="")
{
alert("Please Select Distributor Name");
return false; 
}


return true;
}
</script>
<script type="text/javascript">
function valid112()
{
var y=document.getElementById("dist_id1").value;
if(y==="null" || y==="")
{
alert("Please Select Distributor Name");
return false; 
}


return true;
}
</script>

    <script type="text/javascript">
$(document).ready(function()
	 {
    $('#submit').click(function()
	 {
	  if($("#userfile").val()==="")
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
		
		    if(ext ==="csv")
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
<h2><i class="icon-edit"></i>Add Products with code from Distributors  in Excel Format</h2>
<div class="box-icon">
</div>
</div><div style="float:right; margin-right:15px;"> <a href="excelformat/dist_product.csv">Download Product with Code From Distributors</a></div>
<div class="box-content">
<form class="form-horizontal" action="product_upload.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_product" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset>
<div class="control-group"><label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($row_res=mysql_fetch_array($res))
{
$dis_name=$row_res['dis_name'];
$dist_id=$row_res['dis_id'];
?>
<option value="<?php echo $dist_id; ?>"><?php echo $dis_name; ?></option>
<?php } ?> 
</select></div></div>

<div style="background:#CCCCCC; border-radius:5px;">

<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000; font-size:16px; font-weight:bold;">Match Column Names :</span></label>
<div class="controls">
<!--<ul class="thumbnails gallery"><li id="image-1" class="thumbnail" style="height:10px; width:10px;">
<a title="How to Match Column Name" href="img/district.png"><img class="grayscale" src="img/help.gif" alt="How to Match Column Name" style="height:10px; width:10px;">Help</a>
</li></ul>-->
</div></div>
<div class="control-group"><label class="control-label" for="typeahead">Product Code<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="pro_code123" id="pro_code123" /></div></div>
<div class="control-group"><label class="control-label" for="typeahead">Product Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="pro_name123" id="pro_name123" /></div></div>
<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"></div></div>

</div>

<div class="control-group"><label class="control-label" for="typeahead">Import Product<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="file" name="userfile" id="userfile" /></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"   onClick="return valid();"  /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>



<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Search by Distributor</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="upload_product.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_product" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<div class="control-group"><label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id1" name="dist_id1" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($row_res4=mysql_fetch_array($res4))
{
$dis_name4=$row_res4['dis_name'];
$dist_id4=$row_res4['dis_id'];
?>
<option value="<?php echo $dist_id4; ?>"><?php echo $dis_name4; ?></option>
<?php } ?> 
</select></div></div>





<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Search"  onClick="return valid112();"  /> </div>

</fieldset></form></div></div></div>


<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Product List from distributors</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
                                                                  <th>S.No</th>
								  <th>Product Name</th>
								  <th>Product Id</th>
								  <th>Distributor Name</th>
                                                                  <th>Matched product</th>
								  <th>Status</th>
								  <th>Action</th>
                                  </tr>
						  </thead>   
						  <tbody>
                          <?php
						  $i=1;
						  while($row_res1=mysql_fetch_array($res1))
						  {
						  $d_id=$row_res1['id'];
						  $dist_id=$row_res1['dist_id'];
						  $dis=$ad->view('distributor','where dis_id='.$dist_id,'');
						  $row_dis=mysql_fetch_array($dis);
						   $dis_name=$row_dis['dis_name'];
						   $status=$row_res1['status'];
						  						
						  ?>
							<tr>
                                <td><?php echo $i; ?></td>
			        <td><?php echo $row_res1['pro_name']; ?></td>
                                <td><?php echo $row_res1['pro_id']; ?></td>
                                <td><?php echo $dis_name; ?></td>
                                <td><?php echo $ad->select_our_product_name($row_res1['our_id']); ?></td>
                                <td><?php if($status=='1')  { ?> <span style="color:#FF0000;">Not Matched</span> <?php  }  if($status=='2') { ?> <span style="color:#006600;">Matched </span><?php } ?></td>
                                <td class="center">
				
<a class="btn btn-danger" href="delete.php?d_id=<?php echo $d_id; ?>&comm=dist" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-white"></i> Delete</a>

								</td>
							</tr>
							<?php
							$i++;
							}
							?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div>
          
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
