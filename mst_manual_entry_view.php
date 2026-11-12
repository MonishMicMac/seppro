<table width="100%" cellpadding="5" cellspacing="7" border="0" style="border:1px solid #CCCCCC; border-collapse:collapse;" align="left"> 
	<tr style="border:1px solid #CCCCCC; border-collapse:collapse;"><th align="left">CUSTOMER</th><th align="left">Product</th><th>QTY</th><th>R</th><th>F</th><th align="center">Action</th></tr>
    <?php
		include("include/connect.php");		
		$SQL = mysql_query("SELECT * FROM areawise_temp WHERE c_date='".date("d/m/Y")."' ORDER BY id DESC");
		while($B=mysql_fetch_object($SQL)){
	?>
    <tr style="border:1px solid #CCCCCC; border-collapse:collapse;"><td><?=$B->cust_name;?></td><td><?=$B->pro_name;?></td><td align="center"><?=$B->quantity;?></td><td align="center"><?=$B->replace_quantity;?></td><td align="center"><?=$B->free_quantity;?></td><td align="center"><a href="javascript:del(<?=$B->id;?>)"><img src="img/uploadify-cancel.png" width="20" height="20" /></a></td></tr>
    <?php		
		}
	?>
</table>