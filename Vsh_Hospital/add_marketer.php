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
	if(@$_REQUEST["mode"]=="save"){
		
		$division_id=implode(',', $_REQUEST["division_id"]);
		$state_id=implode(',', $_REQUEST["state_id"]);
		$password=md5($_REQUEST["password"]);

		mysql_query("insert into marketer (mark_name,mark_uid,mark_pwd,user_level,user_group_id,division_id,email,cp_no,reg_addr,status,state_id,session_limit)values ('".$_REQUEST["name"]."','".$_REQUEST["name"]."','$password','1','".$_REQUEST["user_group_id"]."','$division_id','".$_REQUEST["email"]."','".$_REQUEST["mobile"]."','".$_REQUEST["address"]."','".$_REQUEST["status"]."','$state_id','".$_REQUEST['user_limit']."')"); 
		$last_ins = mysql_insert_id();

		header("location:view_marketer.php");
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
				var x=document.getElementById("name").value;
				if(x=="null" || x=="")
				{
					alert("Please Enter Name");
					return false; 
				}


				return true;
			}

			function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true; }

function validate_Email(email) {
	var x=document.getElementById("email").value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		alert("Not a valid e-mail address");
		document.getElementById("email").value="";
		return false;
	}
	return true;
}
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
							<h2><i class="icon-edit"></i>Add Admin</h2>
							<div class="box-icon">
							</div>
						</div>
						<div class="box-content">


							<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
								<input type="hidden" name="command" id="command" value="add_marketer" />
								<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
								<fieldset>
									<!--onKeyUp="AllowAlphabet()"-->
									<div class="control-group"><label class="control-label" for="typeahead">Company Code<span style="color:#FF0000;">*</span> </label>
										<div class="controls"><input class="input-xlarge focused"  type="text" name="company_code" id="company_code"  value="<?php echo $_SESSION["CID"];?>" disabled="true" /></div></div>

										<div class="control-group"><label class="control-label" for="typeahead">User Name<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="name" id="name"  value="" required="true" /></div></div>

											<div class="control-group"><label class="control-label" for="typeahead">Password<span style="color:#FF0000;">*</span> </label>
												<div class="controls"><input class="input-xlarge focused"  type="password" name="password" id="password"  value="" required="true" /></div></div>

												<div class="control-group"><label class="control-label" for="typeahead">Mobile Number<span style="color:#FF0000;">*</span> </label>
													<div class="controls"><input class="input-xlarge focused"  type="text" name="mobile" id="mobile" onKeyPress="return onlyNumbers(event)" maxlength="15" value="" required="true" /></div></div>

													<div class="control-group"><label class="control-label" for="typeahead">Email Id<span style="color:#FF0000;">*</span></label>
														<div class="controls"><input class="input-xlarge focused"  type="email" name="email" id="email"  value=""  required="true" /></div></div>


														<div class="control-group"><label class="control-label" for="typeahead">Address</label>
															<div class="controls"><input class="input-xlarge focused"  type="text" name="address" id="address" style="width:371px; height:160px;"  value="" /></div></div>

															<div class="control-group" id="division">
																<label class="control-label" >Select Division<span style="color:#FF0000;">*</span></label>

																<div class="controls">
																	<select  multiple class="form-control" data-rel="chosen" name="division_id[]" required="true">
																		<?php
																		$SQLD=mysql_query("SELECT * FROM mst_division");
																		$co_manad=mysql_num_rows($SQLD);
																		if($co_manad > 0)
																		{
																			while($row_mad=mysql_fetch_object($SQLD))
																				{ ?>
																			<option value="<?=@$row_mad->division_id;?>"><?=@$row_mad->division_name;?></option>                   
																			<?php      }}?>
																		</select>
																	</div>
																</div>

																<div class="control-group" id="state">
																	<label class="control-label" for="selectError2">Select State</label>

																	<div class="controls">
																		<select id="selectError2" multiple class="form-control" data-rel="chosen" name="state_id[]">
																			<?php
																			$SQLS=mysql_query("SELECT * FROM master_state");
																			$co_manas=mysql_num_rows($SQLS);
																			if($co_manas > 0)
																			{
																				while($row_mas=mysql_fetch_object($SQLS))
																					{ ?>
																				<option value="<?=@$row_mas->state_id;?>"><?=@$row_mas->state_name;?></option>                   
																				<?php      }}?>
																			</select>
																		</div>
																	</div>

																	<div class="control-group">
																		<label class="control-label" for="typeahead">User Group<span style="color:#FF0000;">*</span></label>
																		<div class="controls">
																			<select name="user_group_id" id="user_group_id" data-rel="chosen" required="true"> 
																				<option value="">---Select User Group---</option>
																				<?php
																				$SQL=mysql_query("SELECT * FROM user_group");

																				while($row_ma=mysql_fetch_object($SQL))
																					{ ?>
																				<option value="<?=@$row_ma->id;?>"><?=@$row_ma->name;?></option>                   
																				<?php    
																			}?>
																		</select><script>document.getElementById("user_group_id").value="<?=@$RS->user_group_id; ?>"</script>
																	</div>
																</div>

 <!--           <div class="control-group">
    <label class="control-label" for="typeahead">User Level</label>
  <div class="controls">
   <select name="user_level" id="user_level" data-rel="chosen"> 
            <option value="">---Select User Level---</option>
            <option value="0">Admin</option>
            <option value="1">Sub Admin</option>                   
 
            </select><script>document.getElementById("user_level").value="<?=@$RS->user_level; ?>"</script>
  </div>
</div> -->

<div class="control-group">
	<label class="control-label" for="typeahead">Active</label>
	<div class="controls">
		<label class="radio"><input type="radio" name="status" id="status" value="0">Yes</label>
		<label class="radio"><input type="radio" name="status" id="status" value="1">No</label>
	</div>
</div>

  <div class="control-group"><label class="control-label" for="typeahead">User Limit<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="user_limit" id="user_limit" required="true" placeholder="Enter Numbers Only"/></div></div>

<!-- <div class="control-group">
<div class="controls">
<label class="radio">Active:
                               <input type="radio" name="status" id="status" value="yes">Yes
                            </label>
                            <label class="radio">
                              <input type="radio" name="status" id="status" value="no">No
                             </label>
                         </div></div> -->

                         <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>

                     </fieldset></form>




                 </div></div></div>
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
