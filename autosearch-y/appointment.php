<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if(isset($_GET["appointment"])){
	$SQL=mysql_query("SELECT * FROM tbl_product_proposed WHERE product_name='".$_GET["sample_product"]."' AND type='P' AND appointment_id=0 AND dc_id=".$_GET["dc_id"]." AND dc='".$_GET["dc"]."' AND c_date='".date("Y/m/d")."'");
	$CNT=mysql_num_rows($SQL);
	if($CNT==0){
		mysql_query("INSERT INTO  tbl_product_proposed(product_name,dc_id,dc,type,c_date,c_time) VALUES('".$_GET["sample_product"]."','".$_GET["dc_id"]."','".$_GET["dc"]."','P','".date("Y/m/d")."','".date("H:i:s")."')");
		echo "<strong>PRODUCT PROPOSED FOR INSERTED!</strong>";
	}
	else{
		echo "<strong>ALREADY EXISTS!</strong>";
	}
	$S=mysql_query("SELECT * FROM tbl_product_proposed WHERE appointment_id=0 AND type='P'");	
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Product Name</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->product_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->product_proposed_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["proposed_del"])){
	mysql_query("DELETE FROM tbl_product_proposed WHERE product_proposed_id=".$_GET["product_proposed_id"]."");	
	echo "<strong>PRODUCT PROPOSED FOR DELETED!</strong>";
	$S=mysql_query("SELECT * FROM tbl_product_proposed WHERE appointment_id=0 AND type='P'");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Product Name</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->product_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->product_proposed_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["sample"])){
	$SQL=mysql_query("SELECT * FROM tbl_product_proposed WHERE product_name='".$_GET["sample_product"]."' AND type='S' AND appointment_id=0 AND dc_id=".$_GET["dc_id"]." AND dc='".$_GET["dc"]."' AND c_date='".date("Y/m/d")."'");
	$CNT=mysql_num_rows($SQL);
	if($CNT==0){
		mysql_query("INSERT INTO  tbl_product_proposed(product_name,prodcut_qty,dc_id,dc,type,c_date,c_time) VALUES('".$_GET["sample_product"]."','".$_GET["prodcut_qty"]."','".$_GET["dc_id"]."','".$_GET["dc"]."','S','".date("Y/m/d")."','".date("H:i:s")."')");
		echo "<strong>SAMPLE PRODUCT INSERTED!</strong>";
	}
	else{
		echo "<strong>ALREADY EXISTS!</strong>";
	}
	$S=mysql_query("SELECT * FROM tbl_product_proposed WHERE appointment_id=0 AND type='S'");	
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Product Name</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">QTY</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->product_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->prodcut_qty; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:delMe('<?=$P->product_proposed_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["sample_del"])){
	mysql_query("DELETE FROM tbl_product_proposed WHERE product_proposed_id=".$_GET["product_proposed_id"]."");	
	echo "<strong>SAMPLE PRODUCT DELETED!</strong>";
	$S=mysql_query("SELECT * FROM tbl_product_proposed WHERE appointment_id=0 AND type='S'");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Product Name</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">QTY</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->product_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->prodcut_qty; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:delMe('<?=$P->product_proposed_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["manager"])){

?>
<div class="control-group" id="joint_to">
    <label class="control-label" for="typeahead">Select Joint To : <span style="color:#FF0000;">*</span> </label>
        <div class="controls" style="padding-left:15px">
        <?php
			switch (@$_GET["reporting_to"]) {
				case 'RSM':
					$SQL=mysql_query("SELECT * FROM mst_headquarters");
					while($R=mysql_fetch_object($SQL)){
						echo "<label class=\"radio\"><input type='radio' name='report' value='$R->headquarters_name'>".$R->headquarters_name."</label>";
					}
				break;
				case 'SM':
					$SQL=mysql_query("SELECT * FROM mst_region");
					while($R=mysql_fetch_object($SQL)){
						echo "<label class=\"radio\"><input type='radio' name='report' value='$R->region_name'>".$R->region_name."</label>";
					}
				break;
				case 'ZSM':
					$SQL=mysql_query("SELECT * FROM mst_zonal");
					while($R=mysql_fetch_object($SQL)){
						echo "<label class=\"radio\"><input type='radio' name='report' value='$R->zonal_name'>".$R->zonal_name."</label>";
					}
				break;
				case 'NSM':
					echo "<label class=\"radio\"><input type='radio' name='report' value='NSM'>NSM</label>";
				break;
			}
		?>        
        </div>
    </div>
<?php
}
if(isset($_GET["yuvaraj"])){
	$yu = explode(",",$_GET["pin"]);	
	$yu1 = array();
	foreach($yu as $y){
		$yu1 = explode(" ",$y);		
		mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time,UP,jointworkby) VALUES ('".$_GET["s_date"]."','".$yu1[0]."','".$yu1[1]."','".$_GET["rep_id"]."','".date("Y-m-d")."','".date("H:i:s")."','P','".$_GET["worktype"]."')");	
	}
	echo "Work Plan Scheduled Successfully";
}
?>