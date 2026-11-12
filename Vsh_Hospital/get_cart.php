<?php
include("include/connect.php");


		 if($_REQUEST['submit']=='insert'){ 
		 	$staff_max = mysql_query("SELECT  MAX(sam_pur_entry_purno) FROM sample_pur_entry")or die(mysql_error());	
while($strow = mysql_fetch_array($staff_max)){
		$st_id_before=$strow['MAX(sam_pur_entry_purno)'];				
		if($st_id_before=="")
		{
		$st_id='1001';	
		$f_word='SPE';	
		$Staff_id=$f_word.$st_id;		
	    }
		else
		{		
		$st_id1=substr($st_id_before,3)+1;	
		$f_word='SPE';	
		$Staff_id=$f_word.$st_id1;	
		}
}

		 }
		  if(isset($_REQUEST['productname'])){ 
		  	 $sqty1=mysql_query("SELECT * FROM mst_batchdetails WHERE product_id = '".$_REQUEST["productname"]."'") or die(mysql_error());
			  $sqty1_R=mysql_fetch_array($sqty1);
			  echo $st1=$sqty1_R['batch'];
			  
		 }
		  if(isset($_REQUEST['suppliername'])){ 
		  	 $sqty1s=mysql_query("SELECT * FROM distributor WHERE id = '".$_REQUEST["suppliername"]."'") or die(mysql_error());
			  $sqty1s_R=mysql_fetch_array($sqty1s);?>
			  <table style="width:100%">
			  <tr><td style="width:10%"><span class="invoice-info-label">Address</span></td>
        <td style="width:10%"><span class="black">:<?php echo $sqty1s_R['corp_addr'];?> </span></td>      
        <td style="width:10%"></td>  
        <td style="width:10%"></td> 
        <td style="width:10%"></td>  
            
    </tr>
    <tr>
    	<td style="width:10%"><span class="invoice-info-label">Phone Number</span></td>
        <td style="width:10%"><span class="black">:<?php echo $sqty1s_R['cp_no'];?> </span></td> 
        <td style="width:10%"></td>   
         
    </tr> 
</table>

		<?php  }
if($_REQUEST['pro_name']){
$pro_name=mysql_real_escape_string($_REQUEST['pro_name']);
$pro_name12=$_REQUEST['pro_name'];
$quantity=$_REQUEST['quantity'];
$rand_no=$_REQUEST['rand_no'];
$batch=$_REQUEST['batch'];
$mfrdate=$_REQUEST['mfrdate'];
$expdate=$_REQUEST['expdate'];
$invoicedate=$_REQUEST['invoicedate'];
$invoiceno=$_REQUEST['invoiceno'];
$suppliername=$_REQUEST['suppliername1'];




$aa=mysql_query("SELECT * from product where id='$pro_name'")or die(mysql_error());
$count_aa=mysql_num_rows($aa);
$row_aa=mysql_fetch_array($aa);
$pro_id=$row_aa['id'];
// $mrp=$row_aa['mrp'];

// $aa1=mysql_query("select * from doctors where id='$pat_id'")or die(mysql_error());
// $row_aa1=mysql_fetch_array($aa1);
// $patient_name=$row_aa1['patient_name'];
 // $sqty=mysql_query("SELECT * FROM product WHERE id = '".$row_aa["id"]."'") or die(mysql_error());
 //  $sqty_R=mysql_fetch_array($sqty);
  $samplevalue=$row_aa['ptr'];
  $totalvalue=$quantity*$samplevalue;


$pharmacyname=0;

$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_add=$_SERVER['REMOTE_ADDR']; 
if($count_aa!='0')
{
	
if($pro_name!='' && $quantity!='')
{	
mysql_query("insert into sample_pur_entry(sam_pur_entry_pname,sam_pur_entry_qty,sam_pur_entry_sval,sam_pur_entry_tval,sam_pur_entry_bat,sam_pur_entry_mfrdate,sam_pur_entry_expdate,sam_pur_entry_purno,sam_pur_entry_purdate,sam_pur_entry_supname,sam_pur_entry_invdate,sam_pur_entry_invno)values('$pro_id','$quantity','$samplevalue','$totalvalue','$batch','".date("Y-m",strtotime($mfrdate))."','".date("Y-m",strtotime($expdate))."','$rand_no','$c_date','$suppliername','".date("Y-m-d",strtotime($invoicedate))."','$invoiceno')")or die(mysql_error());

// $sumqty=mysql_query("SELECT sum(sam_pur_entry_qty) AS quantitysum from sample_pur_entry where sam_pur_entry_pname='$pro_id'")or die(mysql_error());
// $sumqty_aa=mysql_fetch_array($sumqty);

	// $sumqtypur=mysql_query("SELECT sum(quantity) AS quantitysumpur from tbl_purchase where product_id='$pro_id'")or die(mysql_error());
	// $sumqtypur_aa=mysql_fetch_array($sumqtypur);

	// if(!$sumqtypur_aa['quantitysumpur'])
	// {				
	// 	mysql_query("insert into tbl_purchase(product_id,quantity)values('$pro_id','".$sumqty_aa['quantitysum']."')")or die(mysql_error());	
	// }
	// else
	// {
	// 	$totalpur=$sumqtypur_aa['quantitysumpur']+$sumqty_aa['quantitysum'];
	// 	mysql_query("UPDATE tbl_purchase SET quantity='$totalpur' WHERE  product_id='$pro_id'")or die(mysql_error());
	// }


	$sql1=mysql_query("SELECT * FROM tbl_purchase WHERE product_id='$pro_id'");
	if(mysql_num_rows($sql1)>0){
		mysql_query("UPDATE tbl_purchase SET quantity=quantity+$quantity WHERE product_id='$pro_id'");
	} else {
		mysql_query("INSERT INTO tbl_purchase(product_id,quantity) VALUES('$pro_id','$quantity')");
	}

	$sql2=mysql_query("SELECT * FROM tbl_check_purchase WHERE tbl_product_id='$pro_id'");
	if(mysql_num_rows($sql2)>0){
		mysql_query("UPDATE tbl_check_purchase SET tbl_quantity=tbl_quantity+$quantity WHERE tbl_product_id='$pro_id'");
	} else {
		mysql_query("INSERT INTO tbl_check_purchase(tbl_product_id,tbl_quantity) VALUES('$pro_id','$quantity')");
	}
}


}





echo '<form name="frm" action="samplepurchaseent" method="post" enctype="multipart/form-data" >';
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

echo "</td><td align='center'><a href='#' onClick='get_delete(".$tab_id.");' >Delete</a></td></tr>";
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

// if(isset($_REQUEST['submit'])=='Submit')
// { 
	
// 	echo "<script type='text/javascript'>alert('Product Sample Added Successfully');window.location.href='samplepurchase1.php';</script>";
// }



}
?>