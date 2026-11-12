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
if(isset($_REQUEST["group_name5"]))
{
	// echo "SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC";
		  ?> <option value="">--Select--</option>
		  <?php 
            $select=mysql_query("SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['subgroup_name']; ?>"><?php echo $row_sel['subgroup_name']; ?></option>
            <?php } 
            exit();
        }

if(isset($_REQUEST['submit'])){
	if($_REQUEST['condition']=='new_grp'){

		$sql1=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['add_group_name']."'");
		if(mysql_num_rows($sql1)==0){
			if($_REQUEST['conditionsub']=='new_subgrp'){
				$sql11=mysql_query("SELECT * FROM product_grouping WHERE subgroup_name='".$_REQUEST['add_sub_group_name']."'");
				if(mysql_num_rows($sql11)==0){
			foreach(@$_REQUEST['slv_product'] as $slv_product){
				$sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['add_group_name']."'  AND slv_product='".$slv_product."'");
				if(mysql_num_rows($sql)==0){
					// echo "INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['add_group_name']."','".$slv_product."','".$_REQUEST['add_sub_group_name']."',curdate(),curtime()) 1";
					mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['add_group_name']."','".$slv_product."','".$_REQUEST['add_sub_group_name']."',curdate(),curtime())");
					echo "<script type='text/javascript'>alert('Added Successfully');window.location='product_grouping_kalzem.php'</script>"; 
				}
				else
				{
					echo "<script type='text/javascript'>alert('Product Already Added This Group')</script>"; 
				}
			}
		}
		else
		{
			echo "<script type='text/javascript'>alert('SUB Group Name Already Exists')</script>"; 
		}
		}
			if($_REQUEST['conditionsub']=='old_subgrp'){
				// $sql11=mysql_query("SELECT * FROM product_grouping WHERE subgroup_name='".$_REQUEST['subgroup_name']."'");
				// if(mysql_num_rows($sql11)==0){
			foreach(@$_REQUEST['slv_product'] as $slv_product){
				$sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['add_group_name']."'  AND slv_product='".$slv_product."'");
				if(mysql_num_rows($sql)==0){
					// echo "INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['add_group_name']."','".$slv_product."','".$_REQUEST['add_sub_group_name']."',curdate(),curtime()) 2";
					mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['add_group_name']."','".$slv_product."','".$_REQUEST['subgroup_name']."',curdate(),curtime())");
					echo "<script type='text/javascript'>alert('Added Successfully');window.location='product_grouping_kalzem.php'</script>"; 
				}
				else
				{
					echo "<script type='text/javascript'>alert('Product Already Added This Group')</script>"; 
				}
			}
		// }
		// else
		// {
		// 	echo "<script type='text/javascript'>alert('SUB Group Name Already Exists')</script>"; 
		// }
		}
		
		} else {
			echo "<script type='text/javascript'>alert('Group Name Already Exists')</script>"; 
		}
	} elseif($_REQUEST['condition']=='old_grp') {
		if($_REQUEST['conditionsub']=='new_subgrp'){
				$sql11=mysql_query("SELECT * FROM product_grouping WHERE subgroup_name='".$_REQUEST['add_sub_group_name']."'");
				if(mysql_num_rows($sql11)==0){
		foreach(@$_REQUEST['slv_product'] as $slv_product){
			$sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['group_name']."'  AND slv_product='".$slv_product."'");
			if(mysql_num_rows($sql)==0){
				// echo "INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['group_name']."','".$slv_product."','".$_REQUEST['add_sub_group_name']."',curdate(),curtime()) 3";
				mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['group_name']."','".$slv_product."','".$_REQUEST['add_sub_group_name']."',curdate(),curtime())");
				echo "<script type='text/javascript'>alert('Added Successfully');window.location='product_grouping_kalzem.php'</script>"; 
			}
			else
			{
				echo "<script type='text/javascript'>alert('Product Already Added This Group')</script>"; 
			}

		}
		}
		else
		{
			echo "<script type='text/javascript'>alert('SUB Group Name Already Exists')</script>"; 
		}
	}
	if($_REQUEST['conditionsub']=='old_subgrp'){
				// $sql11=mysql_query("SELECT * FROM product_grouping WHERE subgroup_name='".$_REQUEST['subgroup_name']."'");
				// if(mysql_num_rows($sql11)==0){
		foreach(@$_REQUEST['slv_product'] as $slv_product){
			$sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['group_name']."'  AND slv_product='".$slv_product."'");
			if(mysql_num_rows($sql)==0){
				// echo "INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['group_name']."','".$slv_product."','".$_REQUEST['subgroup_name']."',curdate(),curtime()) 4";
				mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['group_name']."','".$slv_product."','".$_REQUEST['subgroup_name']."',curdate(),curtime())");
				echo "<script type='text/javascript'>alert('Added Successfully');window.location='product_grouping_kalzem.php'</script>"; 
			}
			else
			{
				echo "<script type='text/javascript'>alert('Product Already Added This Group')</script>"; 
			}
		}
		// }
		// else
		// {
		// 	echo "<script type='text/javascript'>alert('SUB Group Name Already Exists')</script>"; 
		// }
	}
	}
	// elseif($_REQUEST['conditionsub']=='old_subgrp') {
	// 	foreach(@$_REQUEST['slv_product'] as $slv_product){
	// 		$sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$_REQUEST['group_name']."' AND subgroup_name='".$_REQUEST['subgroup_name']."' AND slv_product='".$slv_product."'");
	// 		if(mysql_num_rows($sql)==0){
	// 			mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$_REQUEST['group_name']."','".$slv_product."','".$_REQUEST['subgroup_name']."',curdate(),curtime())");
	// 			echo "<script type='text/javascript'>alert('Added Successfully')</script>"; 
	// 		}
	// 	}
	// }


	
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
<h2><i class="icon-user"></i> Product Promoting</h2>
<div class="box-icon">

</div>
</div>
<form name="product_grouping" method="post" action="">
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.No</th>
<th>Group Name</th>
<th>SUB Name</th>
<th>Product Name</th>

<!-- <th>Dr Specialist</th> -->
</tr>
</thead>   
<tbody>
<?php
$i=1;
$product_list=mysql_query("select * from product_grouping group by group_name,subgroup_name");
while($row_res=mysql_fetch_array($product_list)){
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $row_res['group_name']; ?></td>
<td><?php echo $row_res['subgroup_name']; ?></td>
<td class="center">
	<?php
		$ExistingGP = mysql_query("SELECT GROUP_CONCAT(pro_name) as product from product where id IN (SELECT slv_product FROM product_grouping WHERE group_name='".$row_res['group_name']."' AND subgroup_name='".$row_res['subgroup_name']."')");
		$row_res1=mysql_fetch_array($ExistingGP); 
		echo $row_res1["product"];
	?>
</td>
<!-- <td>
	<?php
		$specialist='';
		$ExistingGP1 = mysql_query("SELECT (select specilist_name from specilist_list where id=specialist_grouping.specialist) as GP FROM specialist_grouping WHERE group_name='".$row_res['group_name']."' group by specialist,group_name");
		while($row_res2=mysql_fetch_array($ExistingGP1)){ $specialist.=$row_res2["GP"].','; }
		if($specialist!=''){ echo rtrim($specialist,','); } else { echo 'N/A'; }
		
	?>
</td> -->
</tr>
<?php
$i++;
}
?>

</tbody>
</table>  
         
</div>
</form>
</div>

</div>





<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i> Product Grouping
</h2>
<div class="box-icon">

</div>
</div>
<form name="product_grouping" id="product_grouping" method="post" action="">
<div class="box-content">
	<div class="span12">
<div class="span6">
<input type="hidden" name="condition" id="condition" value="old_grp">

<div class="control-group" id="old_group">
	<label class="control-label" for="typeahead"><strong>Group Name</strong></label>
	<div class="controls">
        <select id="group_name" name="group_name" data-rel="chosen" style="width: 250px;">
            <option value="">--Select--</option>
            <?php 
            $select=mysql_query("SELECT id,group_name FROM product_grouping WHERE group_name!='' GROUP BY group_name ORDER BY group_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['group_name']; ?>"><?php echo $row_sel['group_name']; ?></option>
            <?php } ?> 
        </select>
    	&nbsp;&nbsp;<a class="btn btn-primary" id="new" style="width: 40px;margin-top: -15px;">Add</a>
    </div>
</div>

<div class="control-group" id="new_group">
	<label class="control-label" for="typeahead"><strong>New Product Group Name</strong></label>
	<div class="controls">
		<input type="text" name="add_group_name" id="add_group_name" class="form-control input">
		&nbsp;&nbsp;<a class="btn btn-primary" id="old" style="width: 40px;margin-top: -15px;">Select</a>
    </div>
</div>
</div>
<div class="span6">
<input type="hidden" name="conditionsub" id="conditionsub" value="old_subgrp">
<div class="control-group" id="old_subgroup">
	<label class="control-label" for="typeahead"><strong>sub Group Name</strong></label>
	<div class="controls">
        <select id="subgroup_name1" name="subgroup_name" class="form-control" style="width: 250px;">
            <option value="">--Select--</option>
           
        </select>
    	&nbsp;&nbsp;<a class="btn btn-primary" id="newsub" style="width: 40px;margin-top: -15px;">Add</a>
    </div>
</div>

<div class="control-group" id="new_subgroup">
	<label class="control-label" for="typeahead"><strong>New sub Product Group Name</strong></label>
	<div class="controls">
		<input type="text" name="add_sub_group_name" id="add_sub_group_name" class="form-control input">
		&nbsp;&nbsp;<a class="btn btn-primary" id="oldsub" style="width: 40px;margin-top: -15px;">Select</a>
    </div>
</div>
</div>
</div>
<!-- <br/> -->
<hr style="border:1px solid #45a3da;height: 0px;">

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.No</th>
<th>Product Name</th>
<th>Group Name</th>
<th>Sub Group Name</th>
<th align="center">Select</th>

</tr>
</thead>   
<tbody>
<?php
$i=1;
$product_list=mysql_query("select * from product");
while($row_res=mysql_fetch_array($product_list))
{
	// echo "SELECT GROUP_CONCAT(group_name) AS group,GROUP_CONCAT(subgroup_name) AS subgroup from product_grouping WHERE slv_product='".$row_res['id']."'";
	$product_list1=mysql_query("SELECT GROUP_CONCAT(group_name) AS grup,GROUP_CONCAT(subgroup_name) AS subgroup from product_grouping WHERE slv_product='".$row_res['id']."'");
	$row_res1=mysql_fetch_array($product_list1);

	
$d_id=$row_res['id'];

?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $row_res['pro_name']; ?></td>
<td><?php echo $row_res1['grup']; ?></td>
<td><?php echo $row_res1['subgroup']; ?></td>
<td class="center"><?php echo "<input type='checkbox' class='slv_product' name='slv_product[]' value='".$row_res['id']."'> "; ?></td>
</tr>
<?php
$i++;
}
?>

</tbody>
</table>  
<div><input type="submit" name="submit" class="btn btn-primary" value="Add New Group"></div>          
</div>
</form>
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
	$("#new_group").hide();

	$("#new").click(function(){
		$("#old_group").hide();
		$("#new_group").show();
		$("#condition").val("new_grp");
	});

	$("#old").click(function(){
		$("#old_group").show();
		$("#new_group").hide();
		$("#condition").val("old_grp");
	});
		$("#new_subgroup").hide();

	$("#newsub").click(function(){
		$("#old_subgroup").hide();
		$("#new_subgroup").show();
		$("#conditionsub").val("new_subgrp");
	});

	$("#oldsub").click(function(){
		$("#old_subgroup").show();
		$("#new_subgroup").hide();
		$("#conditionsub").val("old_subgrp");
	});

    $("#mst_product").change(function(){
		$(".slv_product").attr("checked",false);
		$(".slv_product").parent().attr("class","");
        $.ajax({
        	url: "autosearch-y/representative.php", 
        	type: "post",
        	data: "&pro_id="+$(this).val()+"&condition=show_pro_grouping",
        	success: function(result){
		        var data = JSON.parse(result);
		        for (var i=0; i<data.length; i++) {
		        	$(".slv_product[value="+data[i]+"]").attr("checked",true);
		        	$(".slv_product[value="+data[i]+"]").parent().attr("class","checked");
		        }
		    }
		});
    });


    $("#product_grouping").submit(function(){
		if($("#condition").val()=='old_grp'){
			if($("#group_name").val()==''){
				alert("Please Select Group Name");
				return false;
			} else if($('.slv_product:checked').length==0) {
				alert("Select Any Product");
				return false;
			} else {
				form.submit();
			}
		} else if($("#condition").val()=='new_grp'){
			if($("#add_group_name").val()==''){
				alert("Please Enter Group Name");
				return false;
			} else if($('.slv_product:checked').length==0) {
				alert("Select Any Product");
				return false;
			} else {
				form.submit();
			}
		}
    });

      $("#group_name").change(function(){  
  	// alert($('#group_name').val());
    $.post("product_grouping_kalzem.php",{group_name5:$('#group_name').val()}, function( data ) {    	
     // alert(data);    
      $('#subgroup_name1').html(data);
    });      
  });

});
</script>

</body>
</html>
<?php
}

?>
