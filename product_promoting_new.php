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

if($_REQUEST['rep_name']=='' && $_SESSION["AUTH"]=='1'){
	header('location: product_promoting_new.php?rep_name='.$_SESSION['id']);
}

if(@$_REQUEST['submit']=="Submit"){
	$rep_id=$_REQUEST['rep_name'];
	$doc_id=$_REQUEST['doc_name'];
	$type=$_REQUEST['type'];
	$slv_product=$_REQUEST['slv_product'];
	$call_stage=$_REQUEST['call_stage'];
	$Comments=$_REQUEST['Comments'];
	$single_joint=$_REQUEST['single_joint'];
	$manager=$_REQUEST['manager'];

	mysql_query("DELETE FROM promoted_products WHERE rep_id='$rep_id' AND doc_id='$doc_id'");
	foreach ($slv_product as $product) {
		$pro=explode(',', $product);
		mysql_query("INSERT INTO promoted_products(group_name,product_id,rep_id,doc_id,c_date,c_time) VALUES('$pro[0]','$pro[1]','$rep_id','$doc_id',curdate(),curtime())");
	}
	header('location: product_promoting_new.php');
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
<h2><i class="icon-user"></i>Product Promoting</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form class="form-horizontal" name="thisForm" action="" method="post">
    
    <div class="control-group"><label class="control-label" for="typeahead">Branch<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="branch" id="branch" data-rel="chosen" required>
    	<option value="">---Select---</option>
         <?php $select_branch=mysql_query("SELECT GROUP_CONCAT(`id`) as repid,`rep_name`,`rep_state_status` FROM `representative` group by `rep_state_status`"); while($fetch_branch=mysql_fetch_array($select_branch)){ ?>
        	<option value="<?php echo $fetch_branch['repid'];?>"><?php echo $fetch_branch['rep_state_status']; ?></option>
        <?php } ?>
    </select>
</div></div>
    
    
    	<?php if($_SESSION["AUTH"]!='1'){ ?>
        <div class="control-group">
        	<label class="control-label" for="typeahead">Representative<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="rep_name" name="rep_name" style="width: 250px;">
                    <option value="">--Select--</option>
                   <?php /*?> <?php 
                    if($_SESSION["AUTH"]=='2'){
                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND id in (select repid from assigningreptomanager where managerid='".$_SESSION["id"]."')");
                    } else {
                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND rep_id='0' ORDER BY rep_name ASC");
                    }
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
                    <?php } ?> <?php */?>
                </select><script>document.getElementById("rep_name").value="<?=$_REQUEST['rep_name'] ?>";</script>
            </div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="rep_name" id="rep_name" value="<?php echo $_SESSION['id']; ?>">
        <?php } ?>

        <?php if(@$_REQUEST['rep_name']!=''){ ?>
        <div class="control-group">
        	<label class="control-label" for="typeahead">Doctor<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="doc_name" name="doc_name" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    $query='';
                    if(@$_REQUEST['rep_name']!=''){
                    	$query="AND rep_assign='".$_REQUEST['rep_name']."'";
                    }
                    $select=mysql_query("SELECT id,doctor_name FROM doctors WHERE doctor_name!='' $query ORDER BY doctor_name ASC");
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['doctor_name']; ?></option>
                    <?php } ?> 
                </select><script>document.getElementById("doc_name").value="<?=$_REQUEST['doc_name'] ?>";</script>
            </div>
        </div>
        <?php } ?>

		<?php if(@$_REQUEST['doc_name']!=''){ ?>
        <div class="control-group">
			<div class="controls">
		        <?php
		        	$sql_query=mysql_query("SELECT specialistid, doc_loc_address, doc_qualification, doc_pincode, doc_contact_no, Client_id, (select concat(hos_name,' (',hos_type,')') from mst_hospital where id=doctors.doc_hospital_clinic_name) as hospital, dob, (select area_name from pincode_list where pin_id=doctors.doc_pin_id limit 0,1) as pincode, (select teritary_type from mst_tertiary where tertiary_id in (select tertiary_id from tbl_tertiary where tertiary_pin=doctors.doc_pin_id)) as teritery FROM doctors WHERE id='".$_REQUEST['doc_name']."'");
		        	$row_query=mysql_fetch_array($sql_query);

		        	$sql3=mysql_query("SELECT group_concat(specilist_name) as specilist FROM specilist_list WHERE id in (".$row_query['specialistid'].")");
		        	$row3=mysql_fetch_array($sql3);
		        ?>
				<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
					<tr><th>Specialist</th><td><?php echo $row3['specilist']; ?></td><th>Teritery</th><td><?php echo strtoupper($row_query['teritery']); ?></td></tr>
					<tr><th>Hospital</th><td><?php echo $row_query['hospital']; ?></td><th>Client ID</th><td><?php echo $row_query['Client_id']; ?></td></tr>
					<tr><th>Address</th><td><?php echo $row_query['doc_loc_address']; ?></td><th>Qualification</th><td><?php echo $row_query['doc_qualification']; ?></td></tr>
					<tr><th>Pincode</th><td><?php echo $row_query['doc_pincode']; ?></td><th>Contact</th><td><?php echo $row_query['doc_contact_no']; ?></td></tr>
					<tr><th>Area</th><td><?php echo $row_query['pincode']; ?></td><th>D.O.B</th><td><?php echo date('d-m-Y',strtotime($row_query['dob'])); ?></td></tr>
				</table>
			</div>
		</div>

        <div class="control-group" id="insert">
			<div class="controls">
			<?php
				$sql=mysql_query("SELECT specialistid FROM doctors WHERE id='".$_REQUEST['doc_name']."'");
				$row=mysql_fetch_array($sql);
				$sql1=mysql_query("SELECT product,group_name FROM specialist_grouping WHERE specialist in (".$row['specialistid'].") group by group_name");
				$i = 1;	
				echo "<table cellpadding=\"13\" cellspacing=\"7\"><tr>";
				while ($row1=mysql_fetch_array($sql1)) {
					echo "<td valign=\"top\"><table><tr><td style=\"background:#317eac;color:#FFFFFF;\"><h3 style=\"color:#FFFFFF;\"> &nbsp;<input type='checkbox' class='grouped'>".strtoupper($row1['group_name'])."</h3></td></tr>";	
					$sql2=mysql_query("SELECT * FROM product WHERE id in (select product from specialist_grouping WHERE group_name='".$row1['group_name']."')");
					while ($row2=mysql_fetch_array($sql2)) {
						$num_rows=mysql_query("SELECT * FROM promoted_products WHERE group_name='".$row1['group_name']."' and product_id='".$row2['id']."' and doc_id='".$_REQUEST['doc_name']."' and rep_id='".$_REQUEST['rep_name']."'");
						if(mysql_num_rows($num_rows)=='0'){
							echo "<tr><td><input type='checkbox' class='slv_product' name='slv_product[]' value='".$row1['group_name'].','.$row2['id']."'> ".$row2['pro_name']."</td></tr>";
						} else {
							echo "<tr><td style='font-weight:bold;color:#317eac;'><input type='checkbox' class='slv_product' name='slv_product[]' value='".$row1['group_name'].','.$row2['id']."' checked> ".$row2['pro_name']."</td></tr>";
						}
					}
					echo "</table></td>";if ($i%3 == 0){echo "</tr><tr>";}
					$i++;
				}
				echo "</table>";
			?>
            </div>
        </div>

        <div class="control-group">
        	<div class="controls">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit"/> 
            </div>
        </div>
        <?php } ?>
    </form>
</div>
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
$("#doc_name").change(function(){
	if($(this).val()==''){
		window.location.href="product_promoting_new.php?rep_name="+$("#rep_name").val();
	} else {
		window.location.href="product_promoting_new.php?rep_name="+$("#rep_name").val()+"&doc_name="+$(this).val();
	}
});

$("#rep_name").change(function(){
	if($(this).val()==''){
		window.location.href="product_promoting_new.php";
	} else {
		window.location.href="product_promoting_new.php?rep_name="+$(this).val();
	}
});

$(".slv_product").click(function(){
	var len=$(this).closest('table').find('input[type=checkbox]').length-1;
	var m_len=$(this).closest('table').find('input[type=checkbox].slv_product:checked').length;
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



$('#branch').change(function(){	
			   
	var branch = $('#branch').val();
	//alert(branch);
	$.ajax({
      url:"ajax_select_promoting.php",
      type: "POST",
      data: "branch_id="+branch,
      dataType: "html",
      success: function(data) { 
	  //alert(data);
	  $('#rep_name').html(data);
	     
      }
    });
 });


</script>
</body>
</html>
<?php
}
?>