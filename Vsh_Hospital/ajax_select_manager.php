<?php
include("include/connect.php");
//error_reporting(0);
$select_manager=$_REQUEST['select_manager'];
?>
<option value="">---Select---</option>
<?php
 $rep=mysql_query("SELECT id,rep_name FROM representative WHERE id IN($select_manager) AND rep_id>0"); while($fetch_rep=mysql_fetch_array($rep)){ ?>
        	<option value="<?php echo $fetch_rep['id'];?>"><?php echo $fetch_rep['rep_name'];?></option>
        <?php 
		} 
		
	?>	
