<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");
error_reporting(0);
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if(isset($_GET["representative"])){
	mysql_query("DELETE FROM rep_area WHERE rep_id=0");
	$pin=$_GET["pin"];
	$pin1=explode(",",$pin);
	$I=1;
	?>
	<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
		<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Tertiart Name</th><th>Action</th></tr>
		<?php 

		foreach ($pin1 as $teritary_type) {
			$ter_type=explode("-", $teritary_type);
			
			$SQL = mysql_query("SELECT * FROM tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id IN (".@$ter_type[0].") AND tbl_tertiary.tertiary_pin=master_pincode.pin_id");
			while($R=mysql_fetch_object($SQL)){
				$P=mysql_query("SELECT * FROM rep_area WHERE rep_id=0 AND pin_id='".$R->tertiary_pin."'");
				$CNT=mysql_num_rows($P);
				if($CNT==0){
					mysql_query("INSERT INTO rep_area (rep_id,district_id,pin_id,tertiary_id,c_date,c_time) VALUES (0,'".$R->district_id."','".$R->tertiary_pin."','".$R->tertiary_id."','".date("Y-m-d")."','".date("H:i:s")."')");
					mysql_query("UPDATE mst_tertiary SET teritary_type='".@$ter_type[1]."'  where tertiary_id IN (".@$ter_type[0].") ");
					$hq=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$ter_type[0].") ") ;
					$row_hq=mysql_fetch_object($hq);
					mysql_query("UPDATE rep_area set hq_id='".$row_hq->hq_id."' WHERE tertiary_id IN (".@$ter_type[0].") ");
				}
			}	
			$S=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$ter_type[0].")");
			?>

			<?php  while($P=mysql_fetch_object($S)){ ?>
			<tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->tertiary_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->tertiary_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
			<?php $I++; } ?>
			
			<?php	
		} 
		?>
	</table>
	<?php 
}
if(isset($_GET["representative_id"])){
	mysql_query("DELETE FROM rep_area WHERE tertiary_id=".@$_GET["pin"]."");
	$S=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$_GET["pin"].")");
	?>
	<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
		<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Tertiart Name</th><th>Action</th></tr>
		<?php $I=1; while($P=mysql_fetch_object($S)){ ?>
		<tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->tertiary_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->tertiary_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
		<?php $I++; } ?>
	</table>
	<?php
}
?>
