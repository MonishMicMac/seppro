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
if($command=='product_search')
{
$mark_id=$_POST['mark_id'];
$_SESSION['mark_id']=$mark_id;
echo "<script type='text/javascript'>window.location='product_search.php'</script>";
}
}
include("encrypt.php");
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('product','where 1','order by id desc');
$res2=$ad->view('marketer','','order by id desc');
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
<h2><i class="icon-user"></i> Stockist List</h2>
<div class="box-icon">

</div>
</div>
<div class="box-content">
<span style="text-align:justify;vertical-align:top"><strong>Select Head Quarters</strong> : </span> 
<select name="hq" id="hq" class="form-control select2"  data-rel="chosen" required>
	<option value="">-- Select HQ --</option>
    <?php $HQ = mysql_query("SELECT * FROM mst_headquarters WHERE 1"); while($H=mysql_fetch_object($HQ)){ ?>
    <option value="<?=$H->headquarters_id; ?>"><?=$H->headquarters_name; ?></option>
    <?php } ?>
</select>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.No</th>
<th>Stockist Name</th>
<th>Stockist HQ</th>
<th align="center">Action</th>
</tr>
</thead>   
<tbody>

<?php
	$i=1;
	$Stockist = mysql_query("SELECT dis_id,dis_name,IFNULL((SELECT headquarters_name FROM mst_headquarters WHERE mst_headquarters.headquarters_id=distributor.headquarters_id),'VACANT') HQ FROM distributor WHERE 1");
	while($row_res=mysql_fetch_array($Stockist)){
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $row_res['dis_name']; ?></td>
<td><?php echo strtoupper($row_res['HQ']); ?></td>
<td class="center"><input type="checkbox" class="form-control" name="d_id[]" value="<?php echo $row_res['dis_id']; ?>"></td>
</tr>
<?php
$i++;
}
?>

</tbody>
</table> 
<div><input type="button" name="hqassigning" id="hqassigning" class="btn btn-primary" value="Assigning"></div>           
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
	<script>
    $("#hqassigning").click(function(){
		 var favorite = [];
            $.each($("input[name='d_id[]']:checked"), function(){            
            	favorite.push($(this).val());
            });
            var pin =favorite;
			
            $.get("autosearch-y/headquarters.php?hq_assigning=add&hq_id="+$("#hq").val()+"&stockist="+pin+"",function(data,status){
                alert("Y"+data);
            }); 
	});
    </script>
		
</body>
</html>
<?php
}

