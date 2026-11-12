<?php 
include('connection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form action="">
	<div align="center" > <h1> Transaction Report </h1></div>
	<table valign="top" border="1" width=""  style="font:Arial, Helvetica, sans-serif;color:#FFFFFF" >
<tr bgcolor="#0099FF"  bordercolor="#FFCCFF"   style="border-style:groove" >
	
	<td> Palmtec ID </td>
	<td> Receipt No</td>
	<td> Amount </td>
	<td> Acount No</td>
	<td> AccType</td>
	<td> Cancel </td>
	<td>CollectionDate</td>
	<td>CollectionTime</td>
	<td>Mode of pay</td>
	<td>Cheque Date</td>
	<td>Cheque Number</td>
	<td> Bank Name</td>
	<td> Fine Amount </td>
	<td> Agent Id </td>
	<td>Remark</td>
	
		
	</tr>
	
	<?php
	$sql="select * from transact";
	$res=mysqli_query($con,$sql);
	
	while($row=mysqli_fetch_array($res))
	{
		if($row['modepay']=='C')
			$mod="Cash";
		elseif($row['modepay']=='Q')
			$mod="Cheque";
		elseif($row['modepay']=='D')
			$mod="DD";
		echo '<tr  style="font:Arial, Helvetica, sans-serif;color:#000000" bordercolor="#FFCCFF"   ><td>'.$row['palmtec_id'].'</td><td>'.$row['receiptno'].'</td><td>'.$row['collectamt'].'</td><td>'.$row['acno'].'</td><td>'.$row['actype'].'</td><td>'.$row['cancel'].'</td><td>'.$row['collectdt'].'</td><td>'.$row['tr_time'].'</td><td>'.$mod.'</td><td>'.$row['chequedt'].'</td><td>'.$row['chequeno'].'</td><td>'.$row['bankname'].'</td><td>'.$row['bnk_FineAmt'].'</td><td>'.$row['ag_code'].'</td><td>'.$row['remark'].'</td>';
	}
	?>
	</tr>
	
	</table>
	</div>
</form>
</body>
</html>
