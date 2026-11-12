<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
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
include("encrypt.php");
include("include/select.php");
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');


if(isset($_REQUEST['bh_name'])){
	mysql_query("insert into mst_business_hierarchy (business_hierarchy) values ('".$_REQUEST['bh_name']."')");
	echo "<script type='text/javascript'> alert('Hierarchy Added Successfully'); window.location='business_hierarchy.php'</script>";
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
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/chemist_search.php",
	minLength: 2,
	select: function(event, ui) {
	var getUrl = ui.item.id;
	
	var cid = ui.item.param;
	$('.cid').val(cid);
	
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
</head>

<body id="mm">
<!-- topbar starts -->
<?php include("include/header.php"); ?>
<!-- topbar ends -->
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
<h2><i class="icon-user"></i>Business Hierarchy<a href="#" data-toggle='modal' data-target='#myModal' style="margin-left:600px;" class="btn btn-primary">MANAGE HIERARCHY</a></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
<div id="yuvi">
    <form method="post" action="business_hierarchy.php">
        <table style="width:100%;">
        	<tr>
            	<td>
            		Add Business Hierarchy : <input type="text" name="bh_name" placeholder="Enter New Hierarchy" required/>
	                <input type="submit" name="submit" value="ADD" class="btn btn-primary" style="margin-top:-12px">
	            </td>
            </tr>   
             
        </table>
    </form>


</div>
<form method="post" action="assign_hierarchy.php" id="assign">
Business Hierarchy Name : <select name="business_hierarchy" id="business_hierarchy" required>
    <option value=''>- Select -</option>
    <?php
	$sql=mysql_query("select id,business_hierarchy from mst_business_hierarchy");
	while($row=mysql_fetch_array($sql)){
    ?>
	<option value="<?php echo $row['id']; ?>"><?php echo $row['business_hierarchy']; ?></option>
    <?php } ?>
</select>
 
<?php
$query=mysql_query("select id,rep_name,rep_grade from representative");
$i=0;
$j=5;
?>
<table border='1' class="table table-striped table-bordered" style="border-collapse:collapse !important;">
<?php 
while($row=mysql_fetch_array($query)){
	if($i == $j) { $j=$j+5; echo '<tr>'; }
?>
	<td><input type='checkbox' class='bh_checkbox' name='rep_id[]' id='<?php echo $row['id']; ?>' value='<?php echo $row['id']; ?>'><?php echo $row['rep_name']; ?></td>
<?php	
	if($i == $j) { echo '</tr>'; }
	$i++;
}
?>
</table>
<input type="submit" name="submit" value="ASSIGN" class="btn btn-primary" style="margin-top:-12px">
</form>

</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>

		<div class="modal hide fade" id="myModal">
			<form method='post' action='assign_hierarchy.php'>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3 class="modal-title">Manage Hierarchy</h3>
			</div>
			<div class="modal-body" id="pro_list">
			<table border='1' class="table table-striped table-bordered">
			<thead><th>ID</th><th>Business Hierarchy</th><th>Priority</th><th>Reporting To</th></thead>
				<?php
					$j=1;
					$hierarchy=mysql_query("SELECT * from mst_business_hierarchy where id!='' order by priority asc");
					$num=mysql_num_rows($hierarchy);
					while ($row_hierarchy=mysql_fetch_array($hierarchy)) {
						$id=$row_hierarchy['id'];
				?>
					<tr>
					<td><?php echo $j; ?><input type="hidden" name="hierarchy_name[]" value="<?php echo $row_hierarchy['id']; ?>"></td>
					<td><?php echo $row_hierarchy['business_hierarchy']; ?></td>
					<td>
						<select class="arrange" name="priority_name[]" style="width: 115px;" required>
							<option value=''>- Select -</option>
							<?php for ($i=1; $i <= $num; $i++) { ?>
							<option value='<?php echo $i?>' <?php if($row_hierarchy['priority']==$i){ echo 'selected'; } else { echo 'hidden'; } ?> ><?php echo $i;?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select name="reporting_to[]" style="width: 115px;" required>
						    <option value=''>- Select -</option>
						    <?php
							$sql1=mysql_query("select id,reporting_to,business_hierarchy from mst_business_hierarchy order by id desc");
							while($row1=mysql_fetch_array($sql1)){
						    ?>
							<option value="<?php echo $row1['id']; ?>" <?php if($row_hierarchy['reporting_to']==$row1['id']){ echo "selected"; } ?>><?php echo $row1['business_hierarchy']; ?></option>
						    <?php } ?>
						</select>
					</td>
					</tr>
				<?php $j++; } ?>
			</table>

			</div>
			<div class="modal-footer">
				<input type="submit" name="hierarchy_reporting" value="Submit" class="btn btn-primary" >
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</form>
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

<script>
$('#assign').submit(function(event){
if($(".checked").length<1){
	event.preventDefault();
	alert('Check any one checkbox');
} else {
	$('#assign').submit();
}
});

$.ajax({
	url:"assign_hierarchy.php",
	data:"&grade=0",
	success: function(result){
		var grades = eval('(' + result + ')');
		for (i = 0; i < grades.length; i++) {
			$('#'+grades[i]).parent().attr('class','checked');
		}
	}
});

$('#business_hierarchy').change(function(){
$('.bh_checkbox').parent().attr('class','');
if($(this).val() != ''){
	var grade=$(this).val();
} else {
	var grade=0;
}
	$.ajax({
		url:"assign_hierarchy.php",
		data:"&grade="+grade,
		success: function(result){
			var grades = eval('(' + result + ')');
			for (i = 0; i < grades.length; i++) {
				$('#'+grades[i]).parent().attr('class','checked');
			}
		}
	});
});

$(".arrange").change(function(){
$(".arrange").children('option').show();

var sel = $(".arrange").map(function() { 
if($(this).attr("value")!=''){
 return $(this).attr("value");
 }}).get().join(',');

var selt = sel.split(',');
var i = 0;
$('.arrange').each(function(){
	$(".arrange").children("option[value=" + selt[i] + "]").hide();
i++;
});
});

</script>

</body>
</html>
<?php
}
?>