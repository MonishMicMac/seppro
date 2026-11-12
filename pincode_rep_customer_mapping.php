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
	source: "autosearch-y/rep_search.php",
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
	function yuvaraj(pin_id,rep_id){
		$.post("autosearch-y/rep_customer_mapping.php?rep_id="+rep_id+"&pin_id="+pin_id+"", {rep_id: rep_id}, function(data){});			
	}
	function priyanka(pin_id,rep_id){
		$.post("autosearch-y/rep_customer_mapping.php?rep_id1="+rep_id+"&pin_id="+pin_id+"", {rep_id: rep_id}, function(data){});			
	}
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
<h2><i class="icon-user"></i>Pincode  Representative <-> Customer Mapping</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
   <!-- BODY CONTENT - Start -->
   <?php ?>
   <table id="rep" class="table table-striped table-bordered bootstrap-datatable datatable">
   <thead><tr><th>PINCODE</th><th>No of Customers</th><th>Rep Assign</th></tr></thead>
   <tbody>
   <?php
		$pinIds = mysql_query("SELECT COUNT(*) AS NCUST, master_pincode.pincode AS PIN   FROM tbl_customer_master,master_pincode WHERE tbl_customer_master.pin_id NOT IN (SELECT PIN_ID FROM `rep_area` GROUP BY PIN_ID) AND tbl_customer_master.pin_id=master_pincode.pin_id GROUP BY tbl_customer_master.pin_id ORDER BY tbl_customer_master.pin_id"); while($YUVI=mysql_fetch_object($pinIds)){	?>
    	<tr>
        	<td id="pincode"><?php echo $YUVI->PIN; ?></td>
            <td><?php echo $YUVI->NCUST; ?></td>            
            <td><input type="text" id="Y<?php echo $YUVI->PIN; ?>" name="blah" />&nbsp;<img src="img/rep_customer_mapinng.png" width="63" height="40" id="MAP"></td>
            
         </tr>
    <?php } ?>
    <script type="text/javascript">
			$(document).ready(function() {
				$("#MAP").click(function () {
					var rep = $(this).siblings("input[type=text]").val();
					var pin = $('#rep tr td:first').text()
					$.post("autosearch-y/rep_customer_mapping.php?repid="+rep+"&pincode="+pin,function(data,status){alert(data);});
					window.location.href='pincode_rep_customer_mapping.php';
				});
			});
			</script>
    </tbody>
        </table>        
   
   <!-- BODY CONTENT - End -->
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
$(document).ready(function() {
$('#example').dataTable();
});
</script>
<script type="text/javascript" src="src/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="styles/token-input.css" type="text/css" />

    <script type="text/javascript">
    $(document).ready(function() {
        $("input[type=button]").click(function () {
            alert("Would submit: " + $(this).siblings("input[type=text]").val());
        });
    });
    </script>
    
    <script type="text/javascript">
	$(document).ready(function() {
		$("<?php
		$pinIds = mysql_query("SELECT COUNT(*) AS NCUST, master_pincode.pincode AS PIN   FROM tbl_customer_master,master_pincode WHERE tbl_customer_master.pin_id NOT IN (SELECT PIN_ID FROM `rep_area` GROUP BY PIN_ID) AND tbl_customer_master.pin_id=master_pincode.pin_id GROUP BY tbl_customer_master.pin_id ORDER BY tbl_customer_master.pin_id"); while($YUVI=mysql_fetch_object($pinIds)){ echo $our_id = "#Y".$YUVI->PIN.",";} echo substr($our_id,0,-1);?>?>").tokenInput([
		<?php  $sql = mysql_query("SELECT id,rep_name FROM representative"); while($P=mysql_fetch_object($sql)){ ?>
			{id: <?php echo $P->id ?>, name: "<?php echo $P->rep_name; ?>"},
		<?php } ?>
		]);
	});
	</script>
</body>
</html>
<?php
}
?>