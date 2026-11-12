<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);
if(isset($_GET["consolidated"])){	
	if($_SESSION['doc_cnt']>0){	
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_pincode,reporteddate,reportedtime,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><th>HOSPITAL</th><th>LAST VISITED</th><th style="text-align:center">PINCODE</th><th style="text-align:center">PURPOSE</th><th style="text-align:center">TYPE</th><th style="text-align:center">PRODUCT</th><th style="text-align:center">FEEDBACK</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){
$SQLPRO=mysql_query("SELECT group_concat(pro_name) as pronameid FROM product WHERE ID IN (".$R->productname.")");
		$SQLPRO_ROW=mysql_fetch_object($SQLPRO);
		 ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->doctor_name; ?></td><td><?=$R->doc_hospital_clinic_name; ?></td><td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R->doc_pincode."-".$areaname->area_name; ?>
    </td>
<td><?=$R->purposeofvisit; ?></td>
<td><?=$R->prescriptionvalue; ?></td>
<td><?=$SQLPRO_ROW->pronameid; ?></td>
<td><?=$R->drunavailablereason; ?></td></tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}
	}
if($_SESSION['chem_cnt']>0){
	$SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
	echo mysql_error();
	$CNT1=mysql_num_rows($SQL1);
	if($CNT1>0){
		if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
			echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL1"])." LIST</h2>";
		} else {
			echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
		}
	$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL1"]); ?></th><?php } else { ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><?php } ?><th>LAST VISITED</th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R1=mysql_fetch_object($SQL1)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R1->shop_name; ?></td><td><?php if($R1->reporteddate!=""){echo date("d/m/Y",strtotime($R1->reporteddate))." ".$R1->reportedtime;} ?></td>
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
	
	if(isset($_GET["missed"])){	
	if($_SESSION['doc_cnt']>0){		
		$SQL=mysql_query("SELECT doctor_name,doc_pincode FROM doctors WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='D' AND attendancestatus='1' AND drunavailable='0'  AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($MR=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$MR->doctor_name; ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$MR->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $MR->doc_pincode."-".$areaname->area_name; ?>
    </td></tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}
	}
	if($_SESSION['chem_cnt']>0){
		$SQL1=mysql_query("SELECT shop_name,pincode FROM tbl_customer_master WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='C' AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		echo mysql_error();
		$CNT1=mysql_num_rows($SQL1);
		if($CNT1>0){
		if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
			echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL1"])." MISSED LIST</h2>";
		} else {
			echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST</h2>";
		}
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL1"]); ?></th><?php } else { ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><?php } ?><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R1=mysql_fetch_object($SQL1)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R1->shop_name; ?></td>
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
	if(isset($_GET["detailed"])){
		echo "<h2>".$_GET["rep_name"]." - Visited Call Report for ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."</h2>";
		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$SQL=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=1) AS B GROUP BY R");
		} else {
			$SQL=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=1) AS B GROUP BY R");
		}
		$CNT=mysql_num_rows($SQL);	
		if($CNT>0){
			$R=mysql_fetch_object($SQL); 
			echo "<h3> One Visit Listed ".$_SESSION["LABEL"]." (".$R->DR.") </h3>";

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=1 ORDER BY reporteddate DESC");
		} else {
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=1 ORDER BY reporteddate DESC");
		}

?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th><th style="text-align:center">PURPOSE</th><th style="text-align:center">TYPE</th><th style="text-align:center">PRODUCT</th>
    	<!-- <th style="text-align:center">FEEDBACK</th> -->
    </tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR=mysql_fetch_object($D)){
		$SQLPRO=mysql_query("SELECT group_concat(pro_name) as pronameid FROM product WHERE ID IN (".$DR->productname.")");
		$SQLPRO_ROW=mysql_fetch_object($SQLPRO); ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR->name; ?></td><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?> <td><?=$DR->doc_qualification; ?></td> <?php } else { ?><?php } ?><td><?=$DR->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR->reporteddate))." ".$DR->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR->pincode."-".$areaname->area_name; ?>
                    </td>
                    <td><?=$DR->purposeofvisit; ?></td>
<td><?=$DR->prescriptionvalue; ?></td>
<td><?=$SQLPRO_ROW->pronameid; ?></td>
<!-- <td><?=$DR->drunavailablereason; ?></td> -->
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// TWO TIMES
		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=2) AS B GROUP BY R");
		} else {
			$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=2) AS B GROUP BY R");
		}
		$CNT1=mysql_num_rows($SQL1);			
		if($CNT1>0){
			$R1=mysql_fetch_object($SQL1);
			echo "<h3> Two Time Visit Listed ".$_SESSION["LABEL"]." (".$R1->DR.") </h3>";

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=2 ORDER BY reporteddate DESC");
		} else {
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) as D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=2 ORDER BY reporteddate DESC");
		}
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th><th style="text-align:center">PURPOSE</th><th style="text-align:center">TYPE</th><th style="text-align:center">PRODUCT</th>
    	<!-- <th style="text-align:center">FEEDBACK</th> -->
    </tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR1=mysql_fetch_object($D1)){ 
			$SQLPRO=mysql_query("SELECT group_concat(pro_name) as pronameid FROM product WHERE ID IN (".$DR1->productname.")");
		$SQLPRO_ROW=mysql_fetch_object($SQLPRO);
		?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR1->name; ?></td><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?><td><?=$DR1->doc_qualification; ?></td><?php } else {  } ?><td><?=$DR1->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR1->reporteddate))." ".$DR1->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR1->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR1->pincode."-".$areaname->area_name; ?>
                    </td>
                    <td><?=$DR1->purposeofvisit; ?></td>
<td><?=$DR1->prescriptionvalue; ?></td>
<td><?=$SQLPRO_ROW->pronameid; ?></td>
<!-- <td><?=$DR1->drunavailablereason; ?></td> -->
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		
		// THREE TIMES
		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=3) AS B GROUP BY R");
		} else {
			$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D=3) AS B GROUP BY R");
		}
		$CNT2=mysql_num_rows($SQL2);			
		if($CNT2>0){
			$R2=mysql_fetch_object($SQL2); 
			echo "<h3> Three Time Visit Listed ".$_SESSION["LABEL"]." (".$R2->DR.") </h3>";

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=3 ORDER BY reporteddate DESC");
		} else {
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=3 ORDER BY reporteddate DESC");
		}
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th><th style="text-align:center">PURPOSE</th><th style="text-align:center">TYPE</th><th style="text-align:center">PRODUCT</th>
    	<!-- <th style="text-align:center">FEEDBACK</th> -->
    </tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR2=mysql_fetch_object($D2)){
		$SQLPRO=mysql_query("SELECT group_concat(pro_name) as pronameid FROM product WHERE ID IN (".$DR2->productname.")");
		$SQLPRO_ROW=mysql_fetch_object($SQLPRO); ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR2->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ ?><td><?=$DR2->doc_qualification; ?></td><?php } else {  } ?><td><?=$DR2->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR2->reporteddate))." ".$DR2->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR2->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR2->pincode."-".$areaname->area_name; ?>
                    </td>
                    <td><?=$DR2->purposeofvisit; ?></td>
<td><?=$DR2->prescriptionvalue; ?></td>
<td><?=$SQLPRO_ROW->pronameid; ?></td>
<!-- <td><?=$DR2->drunavailablereason; ?></td> -->
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// > 3 TIMES
		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D>3) AS B GROUP BY R");
		} else {
			$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT wp_rep_id R,COUNT(wp_dc_id) AS D FROM tbl_work_plan WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id HAVING D>3) AS B GROUP BY R");
		}
		$CNT3=mysql_num_rows($SQL3);	
		if($CNT3>0){
			$R3=mysql_fetch_object($SQL3); 
			echo "<h3> More than 3 Visit Listed ".$_SESSION["LABEL"]." (".$R3->DR.") </h3>";

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D>3 ORDER BY reporteddate DESC");
		} else {
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.productname,tbl_work_plan.purposeofvisit FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D>3 ORDER BY reporteddate DESC");
		}
	?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		<thead>
		<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th><th style="text-align:center">PURPOSE</th><th style="text-align:center">TYPE</th><th style="text-align:center">PRODUCT</th>
			<!-- <th style="text-align:center">FEEDBACK</th> -->
		</tr>
		</thead> 
		<tbody>
			<?php $P=1;while($DR3=mysql_fetch_object($D3)){
			$SQLPRO=mysql_query("SELECT group_concat(pro_name) as pronameid FROM product WHERE ID IN (".$D3->productname.")");
		$SQLPRO_ROW=mysql_fetch_object($SQLPRO); ?>
				<tr>
					<td style="text-align:center"><?=$P; ?></td><td><?=$DR3->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ ?><td><?=$DR3->doc_qualification; ?></td><?php } else {  } ?><td><?=$DR3->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR3->reporteddate))." ".$DR3->reportedtime; ?></td>
					<td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR3->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
						echo $DR3->pincode."-".$areaname->area_name; ?>
					</td>
					<td><?=$DR3->purposeofvisit; ?></td>
<td><?=$DR3->prescriptionvalue; ?></td>
<td><?=$SQLPRO_ROW->pronameid; ?></td>
<!-- <td><?=$DR3->drunavailablereason; ?></td> -->
				</tr>
			<?php $P++;} ?>
		</tbody>
		</table>
	<?php
		}
	}
?>