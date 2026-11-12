<?php
include("include/connect.php");
$tab_id=$_REQUEST['tab_id'];
$rand_no=$_REQUEST['rand_no'];

	$sumqty1=mysql_query("SELECT sam_pur_entry_qty,sam_pur_entry_pname from sample_pur_entry where sam_pur_entry_id='$tab_id'")or die(mysql_error());
	$sumqty1_aa=mysql_fetch_array($sumqty1);
	$pro_id=$sumqty1_aa['sam_pur_entry_pname'];
	$quantity=$sumqty1_aa['sam_pur_entry_qty'];

	$sql1=mysql_query("SELECT quantity FROM tbl_purchase WHERE product_id='$pro_id'");
	$row1=mysql_fetch_array($sql1);
	$quan1=$row1['quantity']-$quantity;
	if($quan1>0){ $qty1=$quan1; } else { $qty1='0'; }
	mysql_query("UPDATE tbl_purchase SET quantity=$qty1 WHERE product_id='$pro_id'");

	$sql2=mysql_query("SELECT tbl_quantity FROM tbl_check_purchase WHERE tbl_product_id='$pro_id'");
	$row2=mysql_fetch_array($sql2);
	$quan2=$row1['tbl_quantity']-$quantity;
	if($quan2>0){ $qty2=$quan2; } else { $qty2='0'; }
	mysql_query("UPDATE tbl_check_purchase SET tbl_quantity=$qty2 WHERE tbl_product_id='$pro_id'");

// echo "UPDATE tbl_purchase SET quantity=$qty1 WHERE product_id='$pro_id'<br>";
// echo "UPDATE tbl_check_purchase SET tbl_quantity=$qty2 WHERE tbl_product_id='$pro_id'";


mysql_query("delete from sample_pur_entry where sam_pur_entry_id='$tab_id'");

echo '<form name="frm" action="" method="post" enctype="multipart/form-data" >';
echo '<input type="hidden" name="table_id123" id="table_id123" value="';
echo $rand_no;
echo '" />';

echo '<table width="100%" border="1" cellpadding="10" cellspacing="0">
<tr style="background-color:#CCCCCC;">
<td width="15%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Product ID</td>
<td width="25%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Product Name</td>
<td width="12%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Qty</td>
<td width="14%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Ptr</td>
<td width="12%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Total</td>
<td width="12%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">Delete</td>
</tr>';
?>


<?php
//echo"select * from t_order where rand_no ='$rand_no'";
$order=mysql_query("select * from sample_pur_entry where sam_pur_entry_purno ='$rand_no'");
$i=0;
while($row_order=mysql_fetch_array($order))
{
$tab_id=$row_order['sam_pur_entry_id'];
$tab_name=$row_order['sam_pur_entry_pname'];
$qnty=$row_order['sam_pur_entry_qty'];
$st=$row_order['sam_pur_entry_sval'];
$tv=$row_order['sam_pur_entry_tval'];
$bat=$row_order['sam_pur_entry_bat'];
$mfr=$row_order['sam_pur_entry_mfrdate'];
$exp=$row_order['sam_pur_entry_expdate'];
$vno=$row_order['sam_pur_entry_purno'];
 $sqtyname=mysql_query("SELECT * FROM product WHERE id = '".$row_order['sam_pur_entry_pname']."'") or die(mysql_error());
  $sqty_Rname=mysql_fetch_array($sqtyname);
?>
<?php
echo '<tr><td align="center">';
echo $tab_name;
echo '</td><td align="center">';
echo $sqty_Rname['pro_name'];
echo '</td><td align="center">';
echo $qnty;
echo '</td><td align="center">';
echo $st;
echo '</td><td align="center">';
echo $tv;
echo '</td>

<td align="center">
<a href="#" onClick="get_delete(';
echo $tab_id;
echo ')">
Delete</a></td></tr>';
$i=$tv+$i;
}
echo'<tr>
<td colspan="5" align="right">
<span  style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">Grand Total</span>
</td>
<td align="center" >
<span  style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">';
echo $i;
echo '</span></td>
</tr>';

echo'<tr>
<td colspan="5" align="right">
<span  style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;"></span>
</td>

<td align="center" ><button name="submit" id="submit" >Submit</button></td>
</tr>';

echo '</table>';
echo '</form>';
?>