<?php
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

mysql_query("DELETE FROM tbl_doctor_chemist WHERE dc_id=".$_GET["d_id"].""); 
?>
<table  class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead><tr><th>S.No</th><th>Doctor</th><th style="width:750px;">Address&hellip;&hellip;&hellip;&hellip;&hellip;</th><th><img src="img/map.png" width="25" height="25"></th><th><img src="img/uploadify-cancel.png" width="10" height="10"></th></tr></thead>
    <tbody>
    	<?php 
			$y=1;
			$R=mysql_query("SELECT tbl_customer_master.shop_name AS SNAME, tbl_customer_master.customer_address AS ADDRESS, tbl_doctor_chemist.dc_id AS ID FROM tbl_doctor_chemist,tbl_customer_master WHERE tbl_doctor_chemist.rep_id=0 AND tbl_doctor_chemist.status=1 AND tbl_doctor_chemist.doctor_id=0 AND tbl_doctor_chemist.chemist_id=tbl_customer_master.id");
			while($S=mysql_fetch_object($R)){
		?>
    	<tr><td><?=$y; ?></td><td><?=$S->SNAME; ?></td><td><?=$S->ADDRESS; ?></td><td><a href="javascript:Address('<?=$S->ID; ?>')" id=""><img src="img/map.png" width="25" height="25"></a></td><td><a href="javascript:delMe('<?=$S->ID; ?>')"><img src="img/uploadify-cancel.png" width="10" height="10"></a></td></tr>
        <?php $y++; } ?>
    </tbody>
</table>