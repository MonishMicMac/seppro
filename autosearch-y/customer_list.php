<?php
session_start();
include("../include/connect.php");

if(@$_REQUEST['condition']=='show_cust_list'){
?>
<table class="table table-bordered">
<thead>
	<th>DOCTOR NAME</th>
	<th>PINCODE</th>
	<th>CONTACT NUMBER</th>
	<th>ADDRESS</th>
	<?php if($_REQUEST['status']==1){ ?>
		<th>ACTION</th>
	<?php } ?>
</thead>
<?php
$sql_get=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) as wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_id']."' AND wp_date='".$_REQUEST['date']."'");
$row_get=mysql_fetch_array($sql_get);

$sql=mysql_query("SELECT id,doctor_name,doc_pincode,doc_contact_no,doctor_addrs FROM doctors where id IN (".$row_get['wp_dc_id'].")");
if(mysql_num_rows($sql) > 0){ 
	while($row=mysql_fetch_array($sql)){
		echo "<tr style='background-color:#C690D4; color:white;' class='cust_tr'>";
		echo '<td>'.strtoupper($row['doctor_name']).'</td>';
		echo '<td>'.$row['doc_pincode'].'</td>';
		echo '<td>'.$row['doc_contact_no'].'</td>';
		echo '<td>'.$row['doctor_addrs'].'</td>';
		if($_REQUEST['status']==1){
			echo '<td style="text-align: center;"><a href="javascript:void(0)" onclick="return delete_tp(this);" doc_id="'.$row['id'].'" date="'.$_REQUEST['date'].'"><img src="img/wrong.png" alt="Delete" height="20" width="20"></a></td>';
		}
		echo '</tr>';
	}
} else {
	echo "<td colspan='5' align='center'>No Records Found</td>";
}
?>
</table>

<script type="text/javascript">
	$(".cust_tr").hover(function(){
	    $(this).css("color", "black");
	    }, function(){
	    $(this).css("color", "white");
	});
</script>
<?php
}

if(@$_REQUEST['condition']=='delete'){
	mysql_query("DELETE FROM tbl_work_plan WHERE wp_dc_id='".$_REQUEST['doc_id']."' AND wp_date='".$_REQUEST['date']."'");
}

if(@$_REQUEST['condition']=='insert'){
	$sql=mysql_query("SELECT count(*) as cnt FROM tbl_work_plan WHERE wp_dc_id='".$_REQUEST['doc_id']."' AND wp_rep_id='".$_REQUEST['tp_rep_id']."' AND wp_date='".$_REQUEST['tp_date']."'");
	$row=mysql_fetch_array($sql);

	if($row['cnt']==0){
		mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time)VALUES('".$_REQUEST['tp_date']."','D','".$_REQUEST['doc_id']."','".$_REQUEST['tp_rep_id']."',CURDATE(),CURTIME())");
		echo "<script type='text/javascript'>window.location='../customer_report_calander.php';</script>";
	} else {
		echo "<script type='text/javascript'>alert('This Record Already Inserted...');window.location='../customer_report_calander.php';</script>";
	}
}
?>