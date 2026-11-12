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
	$slv_product=$_REQUEST['slv_product'];

	mysql_query("DELETE FROM temp_sample_tbl_rep WHERE rep_id='".$_SESSION['id']."'");
	foreach ($slv_product as $product) {
		$pro=explode(',', $product);
		if($pro[3]!='' && $pro[3]!='0'){
			mysql_query("UPDATE tbl_purchase SET quantity=quantity-$pro[3] WHERE product_id='$pro[2]'");
			mysql_query("INSERT INTO sample_purchase_allotment(group_name,product_id,quantity,rep_id,doc_id,c_date,c_time) VALUES('$pro[1]','$pro[2]','$pro[3]','$rep_id','$pro[0]',curdate(),curtime())");
		}
	}
	header('location: sample_allotment_doctor.php');
}

if(@$_REQUEST['condition']=="get_total_quantity"){
	$pro_qty=explode(",", $_REQUEST['value']);
	foreach ($pro_qty as $val) {
		$data=explode("-", $val);
		$value.=$data[0].',';

	}
	$sql=mysql_query("SELECT tbl_product_id,tbl_quantity FROM tbl_check_purchase WHERE tbl_product_id IN (".rtrim($value,',').")");
	while($row=mysql_fetch_array($sql)){
		$json['pro_qty'][]=$row['tbl_product_id']."-".$row['tbl_quantity'];
	}
	echo json_encode($json);
	exit;
}

if(@$_REQUEST['condition']=="check_sample"){
	$quan=$_REQUEST['quantity'];
	$quan1=$_REQUEST['prev_quan'];
	$product=$_REQUEST['product'];
	$doc_id=$_REQUEST['doc_id'];
	$group_name=$_REQUEST['group_name'];

	mysql_query("DELETE FROM temp_sample_tbl_rep WHERE product_id='$product' AND doc_id='$doc_id' AND group_name='$group_name' AND rep_id='".$_SESSION['id']."'");
	if($quan>0){
		mysql_query("INSERT INTO temp_sample_tbl_rep(rep_id,product_id,doc_id,group_name,quantity) VALUES('".$_SESSION['id']."','$product','$doc_id','$group_name','$quan')");
	}
	mysql_query("UPDATE tbl_check_purchase SET tbl_quantity=tbl_quantity+$quan1 WHERE tbl_product_id='$product'");
	mysql_query("UPDATE tbl_check_purchase SET tbl_quantity=tbl_quantity-$quan WHERE tbl_product_id='$product'");
	exit;
}

$sel=mysql_query("SELECT * FROM temp_sample_tbl_rep WHERE rep_id='".$_SESSION['id']."'");
while($sel_row=mysql_fetch_array($sel)){
	$qty=$sel_row['quantity'];
	mysql_query("UPDATE tbl_check_purchase SET tbl_quantity=tbl_quantity+$qty WHERE tbl_product_id='".$sel_row['product_id']."'");
}
mysql_query("DELETE FROM temp_sample_tbl_rep WHERE rep_id='".$_SESSION['id']."'");
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
.border{
	border: 1px solid #dddddd;
    border-left: 0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
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
<h2><i class="icon-user"></i>Sample Allotment</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form class="form-horizontal" name="thisForm" action="" method="post">
    	<?php if($_SESSION["AUTH"]!='1'){ ?>
        <div class="control-group">
        	<label class="control-label" for="typeahead">Representative<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="rep_name" name="rep_name" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    if($_SESSION["AUTH"]=='2'){
                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND id in (select repid from assigningreptomanager where managerid='".$_SESSION["id"]."')");
                    } else {
                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND rep_id='0' ORDER BY rep_name ASC");
                    }
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
                    <?php } ?> 
                </select><script>document.getElementById("rep_name").value="<?=$_REQUEST['rep_name'] ?>";</script>
            </div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="rep_name" id="rep_name" value="<?php echo $_SESSION['id']; ?>">
        <?php } ?>

    <?php if(@$_REQUEST['rep_name']!=''){ ?>
        <table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
    	<?php 
        $query='';
        if(@$_REQUEST['rep_name']!=''){
        	$query="AND rep_assign='".$_REQUEST['rep_name']."'";
        }
    	$sql=mysql_query("SELECT * FROM doctors WHERE doctor_name!='' $query ORDER BY doctor_name ASC");
		while ($row=mysql_fetch_array($sql)) { ?>
    	<tr>
    		<td><?php echo $row['doctor_name']; ?></td>
    		<td>
			<?php $sql1=mysql_query("SELECT GROUP_CONCAT(DISTINCT group_name) as group_name FROM specialist_grouping WHERE specialist in (".$row['specialistid'].")");
			$row1=mysql_fetch_array($sql1);
			if($row1['group_name']!=''){ ?>
			<table class="border" border="1">
			<?php $group_name=explode(',', $row1['group_name']);
			if(count($group_name)>1){
			    for ($i=0; $i < count($group_name); $i++) { 
			    	$imp_grp[]='\''.$group_name[$i].'\'';
			    }
			    $group=implode(',', $imp_grp);
			} elseif(count($group_name)==1) {
			    $group='\''.$group_name[0].'\'';
			}

			$sql2=mysql_query("SELECT group_name FROM promoted_products WHERE group_name IN ($group) and rep_id='".$_REQUEST['rep_name']."' AND product_id IN (SELECT sam_pur_entry_pname FROM sample_pur_entry WHERE CURDATE()<=DATE_SUB(sam_pur_entry_expdate, INTERVAL 90 DAY)) GROUP BY group_name");
			while ($row2=mysql_fetch_array($sql2)) { ?>
			<tr>
				<td><?php echo $row2['group_name']; ?></td>
				<td>
				<table class="border" border="1">
				<thead>
				<th>Product</th>
				<th>Given</th>
				<th>Total</th>
				<th>Need</th>
				</thead>
				<?php
				$sql3=mysql_query("SELECT (select pro_name from product where id=promoted_products.product_id) as pro_name,doc_id,group_name,product_id FROM promoted_products WHERE group_name='".$row2['group_name']."' and rep_id='".$_REQUEST['rep_name']."' AND product_id IN (SELECT sam_pur_entry_pname FROM sample_pur_entry WHERE CURDATE()<=DATE_SUB(sam_pur_entry_expdate, INTERVAL 90 DAY))");
				while ($row3=mysql_fetch_array($sql3)) { ?>
				<tr>
					<td><?php echo $row3['pro_name']; ?></td>
					<?php
					$num_rows=mysql_query("SELECT sum(quantity) as quantity FROM sample_purchase_allotment WHERE group_name='".$row3['group_name']."' and product_id='".$row3['product_id']."' and doc_id='".$row['id']."' and rep_id='".$_REQUEST['rep_name']."' group by group_name,product_id");
					$row_num=mysql_fetch_array($num_rows);
					$quantity_val='0';
					if($row_num['quantity']!=''){ $quantity_val=$row_num['quantity']; }

					$quantity=mysql_query("SELECT tbl_quantity FROM tbl_check_purchase WHERE tbl_product_id='".$row3['product_id']."'");
					$row_quan=mysql_fetch_array($quantity);
					$quantity_max='0';
					if($row_quan['tbl_quantity']!=''){ $quantity_max=$row_quan['tbl_quantity']; }

					echo "<td hidden><input type='checkbox' class='slv_product' name='slv_product[]' value='".$row['id'].','.$row3['group_name'].','.$row3['product_id'].",0' checked></td>";
					echo "<td><input type='text' value='".$quantity_val."' style='width: 30px;' readonly></td>";
					echo "<td><input type='text' class='max_product' product='".$row3['product_id']."' value='".$quantity_max."' style='width: 30px;' readonly></td>";
					echo "<td><input type='text' name='quantity' class='quantity' doc_id='".$row['id']."' group_name='".$row3['group_name']."' product='".$row3['product_id']."' max_quan='".$quantity_max."' prev_quan='0' value='0' style='width: 30px;'></td>";
					?>

				</tr>
				<?php } ?>
				</table>
				</td>
			</tr>
			<?php } ?>
			</table>
			<?php } ?>
    		</td>
    	</tr>
        <?php } ?>
        </table>

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
// function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
// $(document).on("keydown", disableF5);

$("#rep_name").change(function(){
	if($(this).val()==''){
		window.location.href="sample_allotment_doctor.php";
	} else {
		window.location.href="sample_allotment_doctor.php?rep_name="+$(this).val();
	}
});

$(".quantity").focusout(function(){
	var g_quan=parseInt($(this).val());
	var m_quan=parseInt($(this).attr('max_quan'));

	if(g_quan<=m_quan){
		var quantity=$(this).val();
		var prev_quan=$(this).attr("prev_quan");
		var product=$(this).attr("product");
		var doc_id=$(this).attr("doc_id");
		var group_name=$(this).attr("group_name");

		$.ajax({
			url: "sample_allotment_doctor.php",
			type: "post",
			context: this,
			data: "&condition=check_sample&quantity="+quantity+"&prev_quan="+prev_quan+"&product="+product+"&doc_id="+doc_id+"&group_name="+group_name,
			success: function(result){
	        	$(this).attr("prev_quan", quantity);
	    	}
	    });

		var str=$(this).closest('tr').find('td input[type=checkbox]').val();
		var n=str.lastIndexOf(",");
		var value=str.substr(0, n);
		var final_value=value+','+$(this).val();
		$(this).closest('tr').find('td input[type=checkbox]').val(final_value);
	} else {
		$(this).val('0');
		var str=$(this).closest('tr').find('td input[type=checkbox]').val();
		var n=str.lastIndexOf(",");
		var value=str.substr(0, n);
		var final_value=value+',0';
		$(this).closest('tr').find('td input[type=checkbox]').val(final_value);
	}
});

setInterval(function(){
	var value=[];
	$(".max_product").each(function(){
		var qty=$(this).val();
		var prod=$(this).attr("product");
		value.push(prod+'-'+qty);
	});

	$.ajax({
		url: "sample_allotment_doctor.php",
		type: "post",
		data: "&condition=get_total_quantity&value="+value,
		success: function(result){
			var val=jQuery.parseJSON(result);
			var pq_val=val['pro_qty'];
			for (var i=0;i<pq_val.length;i++) {
				var str=pq_val[i];
				var myarr = str.split("-");
				$("input[product="+myarr[0]+"].max_product").val(myarr[1]);
				$("input[product="+myarr[0]+"].quantity").attr("max_quan",myarr[1]);
			}
    	}
    });

}, 700);

$(".quantity").keypress(function(event){
	if (event.keyCode === 10 || event.keyCode === 13) {
		event.preventDefault();
	}
});

$(".quantity").keyup(function(event){
	var g_quan=parseInt($(this).val());
	var m_quan=parseInt($(this).attr('max_quan'));

	if(g_quan<=m_quan){
		var str=$(this).closest('tr').find('td input[type=checkbox]').val();
		var n=str.lastIndexOf(",");
		var value=str.substr(0, n);
		var final_value=value+','+$(this).val();
		$(this).closest('tr').find('td input[type=checkbox]').val(final_value);
	} else {
		$(this).val('0');
		var str=$(this).closest('tr').find('td input[type=checkbox]').val();
		var n=str.lastIndexOf(",");
		var value=str.substr(0, n);
		var final_value=value+',0';
		$(this).closest('tr').find('td input[type=checkbox]').val(final_value);
	}
});
</script>
</body>
</html>
<?php
}
?>