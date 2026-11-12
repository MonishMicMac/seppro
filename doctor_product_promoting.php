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

if(@$_REQUEST['submit']=="Submit"){
	$rep_id=$_REQUEST['rep_name'];
	$doc_id=$_REQUEST['doc_name'];
	$type=$_REQUEST['type'];
	$slv_product=$_REQUEST['slv_product'];
	$call_stage=$_REQUEST['call_stage'];
	$Comments=$_REQUEST['Comments'];
	$single_joint=$_REQUEST['single_joint'];
	$manager=$_REQUEST['manager'];

	if($type=='Promote'){
		$promoted_products='';
		mysql_query("UPDATE promoted_products SET status='0' WHERE rep_id='$rep_id' AND doc_id='$doc_id'");
		foreach ($slv_product as $product) {
			$pro=explode(',', $product);
			mysql_query("UPDATE promoted_products SET status='1' WHERE rep_id='$rep_id' AND doc_id='$doc_id' AND group_name='$pro[0]' AND product_id='$pro[1]'");
			$promoted_products.=$pro[0].'/'.$pro[1].',';
		}
	}
	mysql_query("UPDATE tbl_work_plan SET drunavailablereason='$Comments',jointworkby='$manager',prescriptionvalue='$call_stage',attendancestatus='1',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',promotion_service='$type',prescriptionvalue='$call_stage',promoted_products='".rtrim($promoted_products,',')."' WHERE wp_date='".date('Y-m-d')."' and wp_dc_id='$doc_id' and wp_rep_id='$rep_id'");
	header('location: doctor_product_promoting.php');
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
<h2><i class="icon-user"></i>Doctor Product Promoting</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form class="form-horizontal" name="thisForm" action="" method="post">
        <input type="hidden" name="rep_name" id="rep_name" value="<?php echo $_SESSION['id']; ?>">

        <div class="control-group">
        	<label class="control-label" for="typeahead">Doctor<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="doc_name" name="doc_name" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    $select=mysql_query("SELECT id,doctor_name FROM doctors WHERE doctor_name!='' AND id IN (select wp_dc_id from tbl_work_plan where wp_date='".date('Y-m-d')."') ORDER BY doctor_name ASC");
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['doctor_name']; ?></option>
                    <?php } ?> 
                </select><script>document.getElementById("doc_name").value="<?=$_REQUEST['doc_name'] ?>";</script>
            </div>
        </div>

        <?php if(@$_REQUEST['doc_name']!='') { ?>
        <div class="control-group">
			<div class="controls">
		        <?php
		        	$sql_query=mysql_query("SELECT specialistid, doc_loc_address, doc_qualification, doc_pincode, doc_contact_no, Client_id, (select hos_name from mst_hospital where id=doctors.doc_hospital_clinic_name) as hospital, dob, (select area_name from pincode_list where pin_id=doctors.doc_pin_id limit 0,1) as pincode, (select teritary_type from mst_tertiary where tertiary_id in (select tertiary_id from tbl_tertiary where tertiary_pin=doctors.doc_pin_id)) as teritery FROM doctors WHERE id='".$_REQUEST['doc_name']."'");
		        	$row_query=mysql_fetch_array($sql_query);

		        	$sql3=mysql_query("SELECT group_concat(specilist_name) as specilist FROM specilist_list WHERE id in (".$row_query['specialistid'].")");
		        	$row3=mysql_fetch_array($sql3);
		        ?>
				<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
					<tr><th>Specialist</th><td><?php echo $row3['specilist']; ?></td><th>Teritery</th><td><?php echo strtoupper($row_query['teritery']); ?></td></tr>
					<tr><th>Address</th><td><?php echo $row_query['hospital']; ?></td><th>Qualification</th><td><?php echo $row_query['Client_id']; ?></td></tr>
					<tr><th>Address</th><td><?php echo $row_query['doc_loc_address']; ?></td><th>Qualification</th><td><?php echo $row_query['doc_qualification']; ?></td></tr>
					<tr><th>Pincode</th><td><?php echo $row_query['doc_pincode']; ?></td><th>Contact</th><td><?php echo $row_query['doc_contact_no']; ?></td></tr>
					<tr><th>Area</th><td><?php echo $row_query['pincode']; ?></td><th>D.O.B</th><td><?php echo date('d-m-Y',strtotime($row_query['dob'])); ?></td></tr>
				</table>
			</div>
		</div>

        <div class="control-group"> 
		    <div class="controls"> 
		       <label class="radio">
		           <div class="radio" id="uniform-add3"><span class="checked"><input type="radio" class="type" name="type" id="add3" value="Promote" checked="" style="opacity: 0;"></span></div>
		           Promotional 
		       </label>
		       <label class="radio">
		           <div class="radio" id="uniform-add4"><span><input type="radio" class="type" name="type" id="add4" value="Service" style="opacity: 0;"></span></div> 
		           Service
		       </label>       
		    </div>
		</div>

        <div class="control-group" id="insert">
			<div class="controls">
			<?php
				$sql1=mysql_query("SELECT product_id,group_name FROM promoted_products WHERE rep_id='".$_SESSION['id']."' and doc_id in (SELECT id FROM doctors WHERE id='".$_REQUEST['doc_name']."') group by group_name");
				$i = 1;	
				echo "<table cellpadding=\"13\" cellspacing=\"7\"><tr>";
				while ($row1=mysql_fetch_array($sql1)) {
					echo "<td valign=\"top\"><table><tr><td style=\"background:#317eac;color:#FFFFFF;\"><h3 style=\"color:#FFFFFF;\"> &nbsp;<input type='checkbox' class='grouped'>".strtoupper($row1['group_name'])."</h3></td></tr>";

					$sql2=mysql_query("SELECT * FROM product WHERE id in (select product_id from promoted_products WHERE group_name='".$row1['group_name']."' and rep_id='".$_SESSION['id']."' and doc_id='".$_REQUEST['doc_name']."')");
					while ($row2=mysql_fetch_array($sql2)) {
							$num_rows=mysql_query("SELECT * FROM promoted_products WHERE group_name='".$row1['group_name']."' and product_id='".$row2['id']."' and doc_id='".$_REQUEST['doc_name']."' and rep_id='".$_SESSION['id']."' and status='1'");
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

        <div class="control-group" id="view">
			<div class="controls">
			<?php
				$sql1=mysql_query("SELECT product_id,group_name FROM promoted_products WHERE doc_id='".$_REQUEST['doc_name']."' AND rep_id='".$_SESSION['id']."' and status='1' group by group_name");
				$i = 1;	
				echo "<table cellpadding=\"13\" cellspacing=\"7\"><tr>";
				while ($row1=mysql_fetch_array($sql1)) {
					echo "<td valign=\"top\"><table><tr><td style=\"background:#317eac;color:#FFFFFF;text-align:center;\"><h3 style=\"color:#FFFFFF;\"> &nbsp;".strtoupper($row1['group_name'])."</h3></td></tr>";
					$sql2=mysql_query("SELECT * FROM product WHERE id in (SELECT product_id FROM promoted_products WHERE doc_id='".$_REQUEST['doc_name']."' AND rep_id='".$_SESSION['id']."' AND group_name='".$row1['group_name']."' and status='1')");
					while ($row2=mysql_fetch_array($sql2)) {
						echo "<tr><td>".$row2['pro_name']."</td></tr>";
					}
					echo "</table></td>";if ($i%3 == 0){echo "</tr><tr>";}
					$i++;
				}
				echo "</table>";
			?>
            </div>
        </div>

        <div class="control-group">
        	<label class="control-label" for="typeahead">Call Stage<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="call_stage" name="call_stage" data-rel="chosen" style="width: 250px;" required>
                    <option value="">--Select--</option>
                    <option value="Maintanance">Maintanance</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Opportunity">Opportunity</option>
                    <option value="Negotiation">Negotiation</option>
                    <option value="Survey">Survey</option>
                    <option value="Deal Lost">Deal Lost</option>
                    <option value="Proposal">Proposal</option>
                    <option value="Deal won">Deal won</option>
                </select>
            </div>
        </div>

        <div class="control-group">
        	<label class="control-label" for="typeahead">Comments<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <textarea name="Comments" required></textarea>
            </div>
        </div>

        <div class="control-group"> 
		    <div class="controls"> 
		       <label class="radio">
		           <div class="radio" id="uniform-add"><span class="checked"><input type="radio" class="single_joint" name="single_joint" id="add" value="single" checked="" style="opacity: 0;"></span></div>
		           Individual 
		       </label>
		       <label class="radio">
		           <div class="radio" id="uniform-add2"><span><input type="radio" class="single_joint" name="single_joint" id="add2" value="joint" style="opacity: 0;"></span></div> 
		           Jointwork
		       </label>       
		    </div>
		</div>

        <div class="control-group" id="show_manager">
        	<label class="control-label" for="typeahead">Manager<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="manager" name="manager" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    $sql3=mysql_query("SELECT * FROM representative WHERE rep_name!='' AND rep_id>0");
                    while($row3=mysql_fetch_array($sql3)){ 
                    ?>
                    <option value="<?php echo $row3['id']; ?>"><?php echo $row3['rep_name']; ?></option>
                    <?php } ?> 
                </select>
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


<?php if(@$_REQUEST['doc_name']!='') { ?>
	<br>
	<h2>Previous Promoted Report</h2>
	<div class="box-content">
		<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
			<thead>
				<th>S.No</th>
				<th>Date</th>
				<th>Doctor</th>
				<th>Type</th>
				<th>Promoted Products</th>
				<th>Call Stage</th>
				<th>Comments</th>
				<th>Jointwork</th>
			</thead>
			<?php
				$i=1;
				$sql=mysql_query("SELECT wp_date, (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doctor, promotion_service, promoted_products, prescriptionvalue, drunavailablereason, ifnull((select rep_name from representative where id=tbl_work_plan.jointworkby),'N/A') as mgr_name FROM tbl_work_plan WHERE promoted_products!='' AND wp_dc_id='".$_REQUEST['doc_name']."' AND wp_rep_id='".$_SESSION['id']."' ORDER BY wp_date DESC");
				while ($row=mysql_fetch_array($sql)) {
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo date('d-m-Y',strtotime($row['wp_date'])); ?></td>
					<td><?php echo $row['doctor']; ?></td>
					<td><?php echo $row['promotion_service']; ?></td>
					<td>
						<?php
							if($row['promoted_products']!=''){
								echo "<table class='table-bordered'><tr><th>Group</th><th>Product</th></tr>"; 
								$prom=explode(',',$row['promoted_products']); 
								foreach ($prom as $prom_pro) {
									$pro=explode('/', $prom_pro);
									$sql1=mysql_query("SELECT group_name,(select pro_name from product where id=product_grouping.slv_product) as product FROM product_grouping WHERE group_name='$pro[0]' AND slv_product='$pro[1]'");
									$row1=mysql_fetch_array($sql1);
									echo "<tr><td>".$row1['group_name']."</td><td>".$row1['product']."</td></tr>";
								}
								echo "</table>";
							}
						?>
					</td>
					<td><?php echo $row['prescriptionvalue']; ?></td>
					<td><?php echo $row['drunavailablereason']; ?></td>
					<td><?php echo $row['mgr_name']; ?></td>
				</tr>
			<?php $i++; } ?>
		</table>
	</div>
<?php } ?>

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
$("#view").hide();
$("#show_manager").hide();

$(".type").click(function(){
	if($(this).val()=='Promote'){
		$("#insert").show();
		$("#view").hide();
	} else if($(this).val()=='Service'){
		$("#insert").hide();
		$("#view").show();
	}
});

$(".single_joint").click(function(){
	if($(this).val()=='single'){
		$("#show_manager").hide();
	} else if($(this).val()=='joint'){
		$("#show_manager").show();
	}
});

$("#doc_name").change(function(){
	window.location.href="doctor_product_promoting.php?&doc_name="+$(this).val();
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
</script>
</body>
</html>
<?php
}
?>