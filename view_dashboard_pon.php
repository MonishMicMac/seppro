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
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('representative','where 	mark_id='.$m_id16,'order by id desc');
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
.table{
	margin-top: 18px;
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
	<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <link href='css/bootstrap-clockpicker.min.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">

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
						<h2><i class="icon-user"></i> Task List</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable ">
						  <thead>
							  <tr style="background-color: #48b148;">
								  <th style="width:10%;">Employee Name</th>
								  <th style="width:10%;">Category</th>		
								  <th style="width:10%;">Sub Category</th>					
								  <th style="width:10%;">task </th>
								  <th style="width:10%;">date</th>
								  <th style="width:10;">time</th>
								  <th style="width:10;">Action</th>
                                  </tr>
						  </thead>   
						  <tbody>
                          <?php
                     
						  $res=mysql_query("select *,(select catname from category where category.catid=representative.cat_id) AS catname,(select s_c_name from sub_category where sub_category.s_id=representative.s_cat_id) AS subcatname from representative ");
						$jj=0;
						  while($row_res=mysql_fetch_array($res)) {
						  $d_id=$row_res['id'];
						  unset($taskname);
						  unset($taskdate);
						  unset($tasktime);
						  unset($task_status);
						  $ressh=mysql_query("select * from mst_task_scheduling WHERE taskowner='".$row_res['id']."' ");
                              while($row_ressh=mysql_fetch_array($ressh)) {
                              	$taskname[]=$row_ressh['taskname'];
                              	$taskdate[]=$row_ressh['taskdate'];
                              	$tasktime[]=$row_ressh['tasktime'];
                              	$task_status[]=$row_ressh['task_status'];
                              }
                              // print_r($taskdate);
						  ?>
							<tr>
								<td style="width:10%;"><?php echo $row_res['rep_name']; ?><br/><?php echo '('.$row_res['designation'].')'; ?><input type="hidden" class="form-control" id="repnamenew<?php echo $jj;?>" name="repnamenew"  value="<?php echo $row_res['rep_name']; ?>" /></td>
                                <td style="width:10%;"><?php echo $row_res['catname']; ?></td>
                                <td style="width:10%;"><?php echo $row_res['subcatname']; ?></td>
                                <td style="width:10%;">
                                <table class="table table-striped table-bordered bootstrap-datatable ">
                                <?php foreach($taskname AS $taskname1) {
                              	?>
                              	<tr>
                              	<td><?php echo $taskname1;  ?></td>
                              	</tr>

                              	<?php
                              }
                                ?></table><textarea type="text" name="task" id="task<?php echo $jj;?>" ></textarea></td>
                                <td style="width:10%;"><table class="table table-striped table-bordered bootstrap-datatable ">
                                <?php foreach($taskdate AS $taskdate1) {
                              	?>
                              	<tr>
                              	<td><?php echo $taskdate1;  ?></td>
                              	</tr>
                              	
                              	<?php
                              }
                                ?></table><input class="form-control" name="scheduledate1" class="scheduledate1" id="scheduledate1<?php echo $jj;?>" placeholder="Select Schedule Date" type="date" /></td>
                                <td style="width:10%;"><table class="table table-striped table-bordered bootstrap-datatable ">
                                <?php foreach($tasktime AS $tasktime1) {
                              	?>
                              	<tr>
                              	<td><?php echo $tasktime1;  ?></td>
                              	</tr>
                              	
                              	<?php
                              }
                                ?></table><input class="form-control" name="scheduletime" class="scheduletime" id="scheduletime<?php echo $jj;?>" placeholder="Select Schedule Time" type="text" /></td>
                                
                                <td style="width:10%;" class="center"><table class="table table-striped table-bordered bootstrap-datatable ">
                                <?php foreach($task_status AS $task_status1) {
                              	?>
                              	<tr>
                              	<td ><?php  if(($task_status1)=='1')
                                      {
                                        
                                        echo "completed";
                                         
                                       }
                                       if(($task_status1)=='0')
                                       {
                                        
                                        echo "pending";
                                         
                                       }  ?></td>
                              	</tr>
                              	
                              	<?php
                              }
                                ?></table><button type="submit" name="qasave" id="qasave<?php echo $jj;?>"  class="qasave btn btn-primary" value="<?php echo $jj;?>" style="background-color: #2fb87a;border-color: #2fb87a;" />Assign</button>
								</td>
							</tr>
							<?php
							$jj++;
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
	<script src="js/jquery-ui-timepicker-addon.js"></script>

      <script src="js/jquery.repeater.js"></script>
   <script src="js/bootstrap-clockpicker.min.js"></script>
   <?php
   $res=mysql_query("select * from representative ");
						$jj=0;
						  while($row_res=mysql_fetch_array($res)) {
						  	?>
	<script type="text/javascript">
	 $(document).ready(function () {
	 
		 $(function(){ $( "#scheduledate1<?php echo $jj;?>").datepicker({ dateFormat: 'yy-mm-dd' }); });

  $('#scheduletime<?php echo $jj;?>').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    // 'default': 'now'
});

   $("#qasave<?php echo $jj;?>").click(function () { 
	 	// alert($("#scheduledate1<?php echo $jj;?>").val());
	 	// alert($(this).closest('tr').find('td:eq(0)').text());
	 	// var repname=$(this).closest('tr').find('td:eq(0)').text();
	 	var repcategory=$(this).closest('tr').find('td:eq(1)').text();
	 	var task=$("#task<?php echo $jj;?>").val();
	 	var repnamenew=$("#repnamenew<?php echo $jj;?>").val();
	 	var scheduledate=$("#scheduledate1<?php echo $jj;?>").val();
	 	var scheduletime=$("#scheduletime<?php echo $jj;?>").val();
	 	  $.post("view_dashboard_save_pon.php",{repname:repnamenew,repcategory:repcategory,task:task,scheduledate:scheduledate,scheduletime:scheduletime}, function( data ) {
	 	  	// alert(data);
          alert("Assigned Successfully");
          window.location.reload();
        }); 
});
});
	</script>
	<?php 
	$jj++;
}
?>

		
</body>
</html>
<?php
}
?>
