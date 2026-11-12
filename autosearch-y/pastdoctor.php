<?php
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

mysql_query("INSERT INTO tbl_pastdoctor(doctor_id,pdr_loc,doctor_pyrpractice,doctor_ppinid,doctor_paddress) VALUES(0,'".$_GET["pastloc"]."','".$_GET["pastyr"]."','".$_GET["pastpincode"]."','".$_GET["pastaddr"]."')");
?>
<table cellpadding="5" cellspacing="3" width="100%" border="0" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<caption><strong>Doctor More Location</strong></caption>
	<tr style="border:1px solid #CCCCCC; border-collapse:collapse;"><th style="border:1px solid #CCCCCC; border-collapse:collapse;">Sl.No</th><th style="border:1px solid #CCCCCC; border-collapse:collapse;">No of Years Practice</th><th style="border:1px solid #CCCCCC; border-collapse:collapse;">Location</th><th style="border:1px solid #CCCCCC; border-collapse:collapse;">Pincode</th><th style="border:1px solid #CCCCCC; border-collapse:collapse;">Address</th></tr>
    <?php
		$y=1;
		$SQL=mysql_query("SELECT * FROM tbl_pastdoctor,master_pincode WHERE tbl_pastdoctor.doctor_id=0 AND tbl_pastdoctor.doctor_ppinid=master_pincode.pin_id");
		while($R=mysql_fetch_object($SQL)){
	?>
    <tr style="border:1px solid #CCCCCC; border-collapse:collapse;"><td style="text-align:center;border:1px solid #CCCCCC; border-collapse:collapse;"><?=$y; ?></td><td style="text-align:center;border:1px solid #CCCCCC; border-collapse:collapse;"><?=$R->doctor_pyrpractice; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;"><?=$R->pdr_loc; ?></td><td style="text-align:center;border:1px solid #CCCCCC; border-collapse:collapse;"><?=$R->pincode; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;"><?=$R->doctor_paddress; ?></td></tr>
    <?php $y++; } ?>
</table>