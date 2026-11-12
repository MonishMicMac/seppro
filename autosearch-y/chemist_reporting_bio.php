<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);
if(isset($_GET["daily_report"])){	
	// print_r($_SESSION);exit();
	
if($_SESSION['chem_cnt']>0){
	// print_r($_REQUEST);exit();

	// $SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_REQUEST["representative"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
	// echo mysql_error();

	$SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_REQUEST["representative1"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
	// print_r($_REQUEST);exit();


	if($SQL1){
		if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
	//print_r($CNT1);exit();

			echo "<h2> CHEMIST LIST LIST</h2>";

		} else {
			echo "<h2> CHEMIST LIST LIST</h2>";
		}
	$P=1;
?>

<a href="rep_chemist_report_excel_bio.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["representative1"]; ?>" target="_blank" style="margin-left: 90%;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a><br>

<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL1"]); ?></th><?php } else { ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><?php } ?>
<!-- <th>INTIME</th> -->
<th>OUTTIME</th>
<th>PRESCRIPTION VALUE</th>
<th>POB VALUE</th>
<th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R1=mysql_fetch_object($SQL1)){
	
	if($R1->intime !='' && $R1->reportedtime !='')
	{
		                                       $res1= strtotime($R1->reportedtime);
												// $res11=strtotime($R1->intime);
												$diff_minutes1 = $res1 - $res11;
												$trf1=date("H:i:s", $diff_minutes1);
											}else{
												$trf1='--';
											}

	?>
	<tr><td style="text-align:center"><?=$P; ?></td>
	<td><?=$R1->shop_name; ?></td>
	<!-- <td><?=$R1->intime; ?></td> -->

	<td><?php if($R1->reporteddate!=""){echo date("d/m/Y",strtotime($R1->reporteddate))." ".$R1->reportedtime;} ?></td>
	<td><?=$R1->prescriptionvalue; ?></td>
	<td><?=$R1->pobvalue; ?></td>

    <td style="text-align:right">
		<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R1->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R1->pincode."-".$areaname->area_name; ?>
    </td>
    </tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
		}	
	}
}

?>

