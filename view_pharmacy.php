<?php 
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
</head>
<body>
<?php 
$a=mysql_query("select * from temp_table where status='' and mark_id='$m_id16' order by id desc");
$count_a=mysql_num_rows($a);
?>
<div style="height:450px; overflow:auto;">
<table width="567" height="154" border="0" cellpadding="0" cellspacing="0">
<tr><td align="left" colspan="2" valign="middle" bgcolor="#ffffff" style="font-family: Arial, Helvetica, sans-serif; color: #7a7a7a; font-size: 18px; letter-spacing: -1px;"><h3>Pharmacy List </h3></td></tr>
<tr>
<td width="138" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Customer Code</td>
<td width="288" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Customer Name</td>
<td width="141" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Pincode</td>
</tr>
<?php
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<tr><td><?php echo $row_a['dc_id']; ?></td><td><?php echo $row_a['cust_name']; ?></td><td><?php echo $row_a['pincode']; ?></td></tr>


<?php
}
}
else
{
?>
<tr><td>No Records Found</td></tr>
<?php
}
?>
</table>
</div></body>
</html>
<?php
}
?>