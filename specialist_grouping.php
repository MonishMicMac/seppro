<?php
include("include/connect.php");
session_start();
error_reporting(E_ALL);
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
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


if(@$_REQUEST['insert']=="Submit"){
	mysql_query("DELETE FROM specialist_grouping WHERE specialist='".$_REQUEST["specialist"]."'");
	foreach($_REQUEST['mst_product'] as $mst_product){
		$product=explode(",",$mst_product);
		mysql_query("INSERT INTO specialist_grouping(specialist,product,group_name,c_date,c_time) VALUES('".$_REQUEST["specialist"]."','$product[0]','$product[1]',curdate(),curtime())");
	}
	header('location: specialist_grouping.php');
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
</div>
</noscript>

<div id="content" class="span10">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Specialist Grouping</h2>
<div class="box-icon">
</div>
</div>


<br/>
<div class="box-content">

<form action="" method="post">
	<table>
		<td><label for="specialist">Doctor Specialist: </label></td>
		<td>
			<select id="specialist" name="specialist" data-rel="chosen" required>
				<option value="">--Select--</option>
				<?php 
				$select=mysql_query("SELECT * FROM specilist_list");
				while($row_sel=mysql_fetch_array($select)){ 
				?>
				<option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['specilist_name']; ?></option>
				<?php } ?> 
			</select><script>document.getElementById("specialist").value="<?=$_REQUEST['specialist'] ?>";</script>
		</td>
	</table>
	<h2>Grouped Product</h2>
	
	<?php
		$sql=mysql_query("select * from product_grouping GROUP BY group_name order by group_name");
		$i = 1;	
		echo "<table cellpadding=\"13\" cellspacing=\"7\"><tr>";	
		while($row=mysql_fetch_array($sql)){			
			echo "<td valign=\"top\"><table><tr><td style=\"background:#317eac;color:#FFFFFF;\"><h3 style=\"color:#FFFFFF;\"> &nbsp;<input type='checkbox' class='grouped'>".strtoupper($row['group_name'])."</h3></td></tr>";			
			$PROD = mysql_query("SELECT pro_name,id FROM product WHERE id IN (SELECT slv_product FROM product_grouping WHERE product_grouping.group_name='".$row['group_name']."')");
			while($P=mysql_fetch_object($PROD)){
				$num_rows=mysql_query("SELECT * FROM specialist_grouping WHERE specialist='".$_REQUEST['specialist']."' and group_name='".$row['group_name']."' and product='".$P->id."'");
				if(mysql_num_rows($num_rows)==0){
					echo "<tr><td><input type='checkbox' class='mst_product' name='mst_product[]' value='".$P->id.",".$row['group_name']."'> <span class=\"product\"> ".$P->pro_name."</span></td></tr>";
				} else {
					echo "<tr><td style='font-weight:bold;color:#317eac;'><input type='checkbox' class='mst_product' name='mst_product[]' value='".$P->id.",".$row['group_name']."' checked> <span class=\"product\"> ".$P->pro_name."</span></td></tr>";
				}
			}
			echo "</table></td>";if ($i%3 == 0){echo "</tr><tr>";}
			$i++;	
		}echo "</table>";
	?>  
	<br>
	<input type="submit" name="insert" value="Submit" class="btn btn-primary">
</form>
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
    $("#specialist").change(function(){
		$(".grouped").attr("checked",false);
		$(".mst_product").attr("checked",false);
		$(".slv_product").attr("checked",false);
		$(".grouped").parent().attr("class","");
		$(".mst_product").parent().attr("class","");
		$(".slv_product").parent().attr("class","");
        $.ajax({
        	url: "autosearch-y/representative.php", 
        	type: "post",
        	data: "&specialist="+$(this).val()+"&condition=specialist_grouping",
        	success: function(result){
		        var data = JSON.parse(result);
		        var mst_pro=data.mst_pro;
		        var slv_pro=data.slv_pro;

		        for (var i=0; i<mst_pro.length; i++) {
		        	$(".mst_product[value="+mst_pro[i]+"]").attr("checked",true);
		        	$(".mst_product[value="+mst_pro[i]+"]").parent().attr("class","checked");
		        }

		        for (var i=0; i<slv_pro.length; i++) {
		        	$(".slv_product[value="+slv_pro[i]+"]").attr("checked",true);
		        	$(".slv_product[value="+slv_pro[i]+"]").parent().attr("class","checked");
		        }
		    }
		});
    });

	$(".mst_product").click(function(){
		var len=$(this).closest('table').find('input[type=checkbox]').length-1;
		var m_len=$(this).closest('table').find('input[type=checkbox].mst_product:checked').length;
		if(len==m_len){
			$(this).closest('table').find('input[type=checkbox].grouped').attr('checked', true);
			$(this).closest('table').find('input[type=checkbox].grouped').parent().attr('class', 'checked');
		} else {
			$(this).closest('table').find('input[type=checkbox].grouped').attr('checked', false);
			$(this).closest('table').find('input[type=checkbox].grouped').parent().attr('class', '');
		}
		if($(this).is(':checked')){$(this).closest('tr').find('td:eq(0)').css({"font-weight":"bold","color":"#317eac"});}
		if(!$(this).is(':checked')){$(this).closest('tr').find('td:eq(0)').css({"font-weight":"normal","color":"#555555"});}
	});

	$(".grouped").click(function(){
		if($(this).prop('checked')){
			$(this).closest('table').find('input[type=checkbox]').each(function(){
	            $(this).attr('checked', true);
	            $(this).parent().attr('class', 'checked');
	            $(this).closest('tr').find('td:eq(0)').css({"font-weight":"bold","color":"#317eac"});
	        });
		} else {
			$(this).closest('table').find('input[type=checkbox]').each(function(){
	            $(this).attr('checked', false);
	            $(this).parent().attr('class', '');
	            $(this).closest('tr').find('td:eq(0)').css({"font-weight":"normal","color":"#555555"});
	        });
		}
	});

	$("#specialist").change(function(){
		if($(this).val()==''){
			window.location.href="specialist_grouping.php";
		} else {
			window.location.href="specialist_grouping.php?specialist="+$(this).val();
		}
	});
});
</script>

</body>
</html>
<?php
}
?>
