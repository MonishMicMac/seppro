<?php
session_start();
include("include/connect.php");
$id=$_SESSION['id'];

if(!isset($_SESSION['id']))
{
echo "<script type=text/javascript>window.location='index.php?err';</script>";
}
else
{
?>

<?php 
if(isset($_REQUEST['catg_id'])){

	// echo "hi";
	// exit();
$a=mysql_query("SELECT * FROM representative WHERE cat_id='".$_REQUEST['catg_id']."'") or die(mysql_error());
?> <option value="">Select Employee Name</option><?php
while($row=mysql_fetch_array($a))
{?>
     
  <option value="<?php echo $row['id']; ?>"><?php echo $row['rep_name']; ?></option>
  <?php

}
?>
<script type="text/javascript">
			// jQuery(function($) {			
			// 	$(".empname").chosen(); 					
			// });
		</script>
<?php
}
  
  }  ?>

