<?php
	include("include/connect.php");
	session_start();
	
	$id=$_SESSION['id'];
	//echo $m_id16;die();
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{	
ob_start();
?>
 <html>
 <body>
 	
 </body>
<?php

$sal = mysql_query("SELECT distinct pincode as pincode,`customer_name`,`distributor_id`,`id`,area_name  FROM `distributor_customer` where `pincode` !='.' and `pincode` !='0' and `pincode` !=' ' and `pincode` !='' and our_cust_id ='' and pincode = '".$_REQUEST['pincode_sel']."' ORDER BY distributor_id,customer_name,pincode ASC limit 1");
if(mysql_num_rows($sal)>0) {
	while($sal_row = mysql_fetch_array($sal))
	{
		$gn = mysql_query("select dis_name from distributor where dis_id ='".$sal_row['distributor_id']."' ");
		$gn_row = mysql_fetch_array($gn);
		$pincode = $sal_row['pincode']; 
		$encoding = mb_detect_encoding($pincode, 'utf-8, iso-8859-1, ascii', true);
		    if (strcasecmp($encoding, 'UTF-8') !== 0) {
		      $pincode = iconv($encoding, 'utf-8', $pincode);
		    }

		?>
		 <script src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){

			var cust = "<?php echo str_replace("\"", "\\\"", trim($sal_row['customer_name'])); ?>";
			var pin = "<?php echo $pincode; ?>";
			var pinid = "<?php echo $sal_row['id']; ?>";
			var area = "<?php echo $sal_row['area_name']; ?>";
			var url = 'auto_update.php?auto=auto_update';
			var form = $('<form action="' + url + '" method="post">' +
			  '<input type="text" name="customer" value="' + cust.replace("\"", "\\\"") + '" readonly/>' +
			  '<input type="text" name="customer_id" value="' + pinid + '" readonly/>' +
			  '<input type="text" name="area" value="' + area + '" readonly/>' +
			   '<input type="text" name="pincode" value="' + pin + '" readonly/>' +
			  '</form>');
			$('body').append(form);
			form.submit();
		});
		</script> 
 </html>
		<?php
	}
} else {
	?>
    <script type="text/javascript">location.href = 'pincode_mapping.php?status=completed&pincode=<?php echo $_REQUEST['pincode_sel'] ?>';</script>
    <?php
}

}
?>