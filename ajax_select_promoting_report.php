<?php
include("include/connect.php");
session_start();
//error_reporting(0);
$select_rep=$_REQUEST['branch_id'];
?>
<option value="">---Select---</option>
 <?php 
	 if($_SESSION["AUTH"]=='2'){
		           $select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND id IN(select repid from assigningreptomanager where managerid='".$_SESSION["id"]."') AND id IN($select_rep)");
		                    } else {
		                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND rep_id='0' AND id IN($select_rep) ORDER BY rep_name ASC");
		                    }
		                    while($row_sel=mysql_fetch_array($select)){ 
		                    ?>
		                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
		                    <?php } ?> 
