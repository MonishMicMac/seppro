<?php
	include("include/connect.php");
	$rep_id=$_REQUEST['id'];
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$sql=mysql_query("SELECT areawise_temp.pincode,areawise_temp.cust_name,count(*) as qty,SUM(areawise_temp.quantity*product.ptr) AS TOTPTR from areawise_temp,product where rep_id='$rep_id' and areawise_temp.our_product_id=product.id and date(bill_date) between '$from' and '$to' group by areawise_temp.our_cust_id order by pincode");
?>
	<div style="float:left;">
	<table class="table table-bordered" style="width:345px;font-size: 13px;">
		<thead><th>PINCODE</th><th>COVERED CUSTOMER</th><th>QTY</th><th>PTR</th></thead> 
		<?php while($row=mysql_fetch_array($sql)){ ?>
		<tr>
			<td><?php echo $row['pincode']; ?></td>
			<td><?php echo strtoupper($row['cust_name']); ?></td>
			<td><?php echo $row['qty']; ?></td>
			<td><?php echo round($row['TOTPTR'],2); ?></td>
		</tr>
		<?php } ?>
	</table>
	</div>

<?php
	$sql=mysql_query("SELECT shop_name,pincode from tbl_customer_master where rep_id='$rep_id' and id not in (select distinct(our_cust_id) as cust_id from areawise_temp where rep_id='$rep_id' and date(bill_date) between '$from' and '$to') order by pincode");
?>
	<div style="float:right;">
	<table class="table table-bordered" style="width:300px;font-size: 13px;">
		<thead><th>PINCODE</th><th>UN-COVERED CUSTOMER</th></thead> 
		<?php while($row=mysql_fetch_array($sql)){ ?>
		<tr>
			<td><?php echo $row['pincode']; ?></td>
			<td><?php echo strtoupper($row['shop_name']); ?></td>
		</tr>
		<?php } ?>
	</table>
	</div>