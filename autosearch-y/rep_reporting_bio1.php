<?php
	include("connect_db.php");
	
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);

if(isset($_GET["consolidated"])){	
	
	if($_SESSION['doc_cnt']>0){	
		// $SQL=mysql_query("SELECT doctors.doctor_name,doctors.doc_category,doctors.doc_pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue,drunavailable FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.doc_category,doctors.doc_pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue,drunavailable FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' AND tbl_work_plan.reporteddate != '' AND tbl_work_plan.reporteddate IS NOT NULL GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");	
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		// print_r($CNT);exit();

		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?>
</th>
<th>OUTTIME</th>
<th>PRESCRIPTION VALUE</th>
<th>POB VALUE</th>
<th>CATEGORY</th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ 

	 if($R->intime !='' && $R->reportedtime !='')
	 {
		$res= strtotime($R->reportedtime);
												$res1=strtotime($R->intime);
												$diff_minutes = $res - $res1;
												$trf=date("H:i:s", $diff_minutes);
											}else{
												$trf='--';
											}
	
	?>
	<?php if ($R->drunavailable == '0') { ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td>
		<?=$R->doctor_name; ?></td>
		<!-- <td><?=$R->intime; ?></td> -->
	<td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
	<td><?=$R->prescriptionvalue; ?></td>
	<td><?=$R->pobvalue; ?></td>
	<td><?=$R->doc_category; ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R->doc_pincode."-".$areaname->area_name; ?>
    </td></tr>
	<?php } else { ?>
		<tr style="color:red;"><td style="text-align:center"><?=$P; ?></td><td>
		<?=$R->doctor_name; ?></td>
		<!-- <td><?=$R->intime; ?></td> -->
	<td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
	<td><?=$R->prescriptionvalue; ?></td>
	<td><?=$R->pobvalue; ?></td>
	<td><?=$R->doc_category; ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R->doc_pincode."-".$areaname->area_name; ?>
    </td></tr>
		<?php } ?>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}
	}


	
if($_SESSION['chem_cnt']>0){
// 	$SQL1 = mysql_query("
//     SELECT 
//         tbl_customer_master.shop_name,
//         tbl_customer_master.pincode,
//         wp.reporteddate,
//         wp.reportedtime,
//         wp.prescriptionvalue,
//         wp.pobvalue,
//         wp.drunavailable
//     FROM 
//         tbl_work_plan wp
//     JOIN 
//         tbl_customer_master ON wp.wp_dc_id = tbl_customer_master.id
//     WHERE 
//         wp.wp_rep_id = '".$_GET["rep"]."'
//         AND wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."'
//         AND wp.wp_dc = 'C'
//     ORDER BY 
//         wp.reporteddate DESC, wp.reportedtime DESC
// "); 

$SQL1 = mysql_query("
    SELECT 
        tbl_customer_master.shop_name,
        tbl_customer_master.pincode,
        wp.reporteddate,
        wp.reportedtime,
        wp.prescriptionvalue,
        wp.pobvalue,
        wp.drunavailable
    FROM 
        tbl_work_plan wp
    JOIN 
        tbl_customer_master ON wp.wp_dc_id = tbl_customer_master.id
    WHERE 
        wp.wp_rep_id = '".$_GET["rep"]."'
        AND wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."'
        AND wp.wp_dc = 'C'
        AND wp.reporteddate != '' 
        AND wp.reporteddate IS NOT NULL
    ORDER BY 
        wp.reporteddate DESC, wp.reportedtime DESC
");
	echo mysql_error();
	$CNT1=mysql_num_rows($SQL1);
	if($CNT1>0){
		if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
			echo "<h2>".$_GET["rep_name"]." - CHEMIST LIST</h2>";
		} else {
			echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
		}
	$P=1;
?>
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

	<?php if ($R1->drunavailable == '0') { ?>
		
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
	<?php } else { ?>

		<tr style="color:red;"><td style="text-align:center"><?=$P; ?></td>
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
	<?php } ?>

<?php			
			$P++;}
?>
</tbody>
</table>
<?php
		}	
	}
}
if(isset($_GET["consolidated_pon"])){	

		$SQL=mysql_query("SELECT * FROM mst_task_scheduling WHERE  taskowner='".$_GET["rep"]."' AND (taskdate BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')  ORDER BY taskdate DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - Task LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th >Task Name</th><th>Task Description</th><th >Assigned</th><th >Visited</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->taskname; ?></td><td><?php echo  $R->definition; ?></td>
	<td><?php echo  $R->taskdate; ?></td>
	<td><?php if($R->status=='0') { echo "Pending"; } else { echo date('Y-m-d',strtotime($R->comdatetime)); } ?></td>
    </tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}


}
	if(isset($_GET["unvisited"])){		
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.drorchemist,doctors.doc_pincode,reporteddate,reportedtime,drunavailablereason,wp_date,prescriptionvalue,pobvalue FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND attendancestatus='0' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - CUSTOMER MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th>DATE</th>
<th>PRESCRIPTION VALUE</th>
<th>POB VALUE</th>
<th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->drorchemist.'-'.$R->doctor_name; ?></td><td><?=$R->wp_date; ?></td>
	<td><?=$R->prescriptionvalue; ?></td>
	<td><?=$R->pobvalue; ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R->doc_pincode."-".$areaname->area_name; ?>
    </td></tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}
	}
	
	if(isset($_GET["missed"])){	

	if($_SESSION['doc_cnt']>0){		
		$SQL=mysql_query(" SELECT 
        d.doctor_name, 
        d.doc_pincode,
        (SELECT wp.prescriptionvalue 
         FROM tbl_work_plan wp 
         WHERE wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
         AND wp.wp_rep_id = '".$_GET["rep"]."'
         LIMIT 1) AS prescriptionvalue,
        (SELECT wp.pobvalue 
         FROM tbl_work_plan wp 
         WHERE wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
         AND wp.wp_rep_id = '".$_GET["rep"]."'
         LIMIT 1) AS pobvalue
    FROM doctors d
    WHERE d.rep_id = '".$_GET["rep"]."'
    AND d.id NOT IN (
        SELECT wp.wp_dc_id 
        FROM tbl_work_plan wp
        WHERE wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
        AND wp.wp_dc = 'D' 
        AND wp.wp_rep_id = '".$_GET["rep"]."'
        GROUP BY wp.wp_dc_id
    )");
		
	
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th>
<th>PRESCRIPTION VALUE</th>
<th>POB VALUE</th>
<th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($MR=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$MR->doctor_name; ?></td>
	<td><?=$MR->prescriptionvalue; ?></td>
	<td><?=$MR->pobvalue; ?></td>
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
		$SQL1=mysql_query("SELECT shop_name,pincode,(SELECT wp.prescriptionvalue 
         FROM tbl_work_plan wp 
         WHERE wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
         AND wp.wp_rep_id = '".$_GET["rep"]."'
         LIMIT 1) AS prescriptionvalue,
        (SELECT wp.pobvalue 
         FROM tbl_work_plan wp 
         WHERE wp.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
         AND wp.wp_rep_id = '".$_GET["rep"]."'
         LIMIT 1) AS pobvalue FROM tbl_customer_master WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='C' AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		 
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
<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL1"]); ?></th><?php } else { ?><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><?php } ?>
<th>PRESCRIPTION VALUE</th>
<th>POB VALUE</th>
<th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R1=mysql_fetch_object($SQL1)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R1->shop_name; ?></td>
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
	if(isset($_GET["customerwise"])){	
		$DR=mysql_query("SELECT * FROM representative WHERE id='".$_GET["rep"]."'");$DRCNT=mysql_fetch_object($DR);
		// echo "SELECT DISTINCT(doc_pin_id) AS pincd FROM doctors WHERE id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";

		$SQL=mysql_query("SELECT DISTINCT(doc_pin_id) AS pincd FROM doctors WHERE id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')");

		// $SQL=mysql_query("SELECT doctor_name,doc_pincode,drorchemist FROM doctors WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='D' AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - AREA COVERED</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PINCODE</th><th style="text-align:center">AREA</th></tr>
</thead> 
<tbody>  
<?php while($MR=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td>
    <td style="text-align:center">
	<?php $AREA=mysql_query("SELECT area_name,pincode FROM pincode_list WHERE pin_id='".$MR->pincd."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		 echo $areaname->pincode; ?>
    </td>
<td style="text-align:center"><?php echo $areaname->area_name; ?></td></tr>
<?php			
			$P++;}
?></tbody>
</table>
<hr style="border:1px solid #317eac;height: 0px;">
<?php
// echo "SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
// 		$SQL=mysql_query("SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')");
	// echo "SELECT doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
		$SQL1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1') aND drorchemist='DOCTOR'");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - DOCTOR VISITED</h2>";
		$dr=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">PRODUCT USING</th><th style="text-align:center">SAMPLE GIVEN</th><th style="text-align:center">GIFT BOX</th><th style="text-align:center">REMARKS</th><th style="text-align:center">TYPE OF CALLS</th><th style="text-align:center">REPORTING TIME</th></tr>
</thead> 
<tbody>  
<?php while($MR1=mysql_fetch_object($SQL1)){ 
	// echo "SELECT SUM(CASE WHEN qty='0' THEN 1 ELSE 0 END) as samlpd,SUM(CASE WHEN qty!='0' THEN 1 ELSE 0 END) as pdlit FROM pobbooking WHERE client_id='".$MR1->id."' AND repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."' GROUP BY productid,client_id ";
	$SQL2=mysql_query("SELECT SUM(CASE WHEN qty='0' THEN 1 ELSE 0 END) as samlpd,SUM(CASE WHEN qty!='0' THEN 1 ELSE 0 END) as pdlit FROM pobbooking WHERE client_id='".$MR1->id."' AND repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."'");
	$MR2=mysql_fetch_object($SQL2);

	$SQLgrt=mysql_query("SELECT drunavailablereason,jointworkby,gift,reportedtime,wp_dc_id FROM  tbl_work_plan WHERE wp_dc_id='".$MR1->id."' AND wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1' ");
	$SQLgrt_res=mysql_fetch_object($SQLgrt);
	// echo $MR1->id;?>
	<tr class="docusesamp"><td style="text-align:center"><?=$dr; ?></td>
		<td hidden><?php echo $SQLgrt_res->wp_dc_id; ?></td>
			<td hidden><?php echo $_GET["rep"]; ?></td>
				<td hidden><?php echo $_GET["daterep"]; ?> </td>
				<td><?=$MR1->drorchemist.'_'.$MR1->doctor_name.'_'.$MR1->doc_pincode; ?></td>
    <td style="text-align:right">
	<?php echo $MR2->samlpd;
	 // $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$MR1->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		// echo $MR1->doc_pincode."-".$areaname->area_name; ?> </td>
		
				<td style="text-align:center"><?php echo $MR2->pdlit; ?></td>
<td style="text-align:center"><?php echo $SQLgrt_res->gift; ?></td>
<td style="text-align:center"><?php echo $SQLgrt_res->drunavailablereason; ?></td>
<td style="text-align:center"><?php if($SQLgrt_res->jointworkby==0){ echo 'INDIVIDUAL'; }else{ echo 'JOINT WORK';}  ?></td>
<td style="text-align:center"><?php echo $SQLgrt_res->reportedtime; ?></td></tr>

<?php			
			$dr++;}
?>
</tbody>
</table>
<hr style="border:1px solid #317eac;height: 0px;">
<div>&nbsp;</div>      
<div style="height:auto;" id="docterprductusesample"></div> 

<?php

// echo "SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
// 		$SQL=mysql_query("SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')");
	// echo "SELECT doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
		$SQLc1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1') aND drorchemist='SHOP'");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - CHEMIST VISITED</h2>";
		$drc=1;
?>
<table id="examplechm" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">PRODUCT USING</th><th style="text-align:center">SAMPLE GIVEN</th><th style="text-align:center">GIFT BOX</th><th style="text-align:center">REMARKS</th><th style="text-align:center">TYPE OF CALLS</th><th style="text-align:center">REPORTING TIME</th></tr>
</thead> 
<tbody>  
<?php while($MRc1=mysql_fetch_object($SQLc1)){ 

	$SQLc2=mysql_query("SELECT SUM(CASE WHEN qty='0' THEN 1 ELSE 0 END) as samlpdc,SUM(CASE WHEN qty!='0' THEN 1 ELSE 0 END) as pdlitc FROM pobbooking WHERE client_id='".$MRc1->id."' AND repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."' ");
	$MRc2=mysql_fetch_object($SQLc2);
	$SQLgrtc=mysql_query("SELECT drunavailablereason,jointworkby,gift,reportedtime,wp_dc_id FROM  tbl_work_plan WHERE wp_dc_id='".$MRc1->id."' AND wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1' ");
	$SQLgrtc_res=mysql_fetch_object($SQLgrtc);
	
	// echo $MRc1->id;?>
	<tr class="chmusesamp"><td style="text-align:center"><?=$drc; ?></td>
		<td hidden><?php echo $SQLgrtc_res->wp_dc_id; ?></td>
			<td hidden><?php echo $_GET["rep"]; ?></td>
				<td hidden><?php echo $_GET["daterep"]; ?> </td>
				<td><?=$MRc1->drorchemist.'_'.$MRc1->doctor_name.'_'.$MRc1->doc_pincode; ?></td>
    <td style="text-align:right">
	<?php echo $MRc2->samlpdc;
	 // $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$MR1->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		// echo $MR1->doc_pincode."-".$areaname->area_name; ?>
    </td><td style="text-align:center"><?php echo $MRc2->pdlitc; ?></td>
    <td style="text-align:center"><?php echo $SQLgrtc_res->gift; ?></td>
<td style="text-align:center"><?php echo $SQLgrtc_res->drunavailablereason; ?></td>
<td style="text-align:center"><?php if($SQLgrtc_res->jointworkby==0){ echo 'INDIVIDUAL'; }else{ echo 'JOINT WORK';}  ?></td>
<td style="text-align:center"><?php echo $SQLgrtc_res->reportedtime; ?></td></tr>
<?php			
			$drc++;}
?>
</tbody>
</table>
<hr style="border:1px solid #317eac;height: 0px;">
<div>&nbsp;</div>      
<div style="height:auto;" id="docterprductusesamplechm">
</div> 

	<script type="text/javascript">

	$('.docusesamp').click(function(){

		$.get("autosearch-y/rep_reporting.php?usesample=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
			$("#docterprductusesample").html(data);
		});	
		// $.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
		// 	$("#consolidated").html(data);
		// });		
	});
$('.chmusesamp').click(function(){

		$.get("autosearch-y/rep_reporting.php?usesamplechm=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
			$("#docterprductusesamplechm").html(data);
		});	
		// $.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
		// 	$("#consolidated").html(data);
		// });		
	});
	

</script>		
	
<?php
	
	}
	if(isset($_GET["usesample"])){
		
		$DRl=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id='".$_GET['cldid']."'  AND drorchemist='DOCTOR'");
		echo mysql_error();
		$DRCNTl=mysql_fetch_object($DRl);
		
		$SQLc1us=mysql_query("SELECT productid FROM pobbooking WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."' AND qty='0' GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTl->doctor_name." -DOCTOR PRODUCT USING</h2>";
		$drus=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th></tr>
</thead> 
<tbody>  
<?php while($MR1us=mysql_fetch_object($SQLc1us)){ 
	
	$SQL2us=mysql_query("SELECT * FROM product WHERE id='".$MR1us->productid."' ");
	$MR2us=mysql_fetch_object($SQL2us);

	?>
	<tr class="docusesamp"><td style="text-align:center"><?=$drus; ?></td>
    <td style="text-align:center"><?php echo $MR2us->pro_name; ?></td>	
				<!-- <td style="text-align:center"><?php echo $MR1us->Q; ?></td> -->
<?php			
			$drus++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
<?php
$SQLc1sg=mysql_query("SELECT sum(qty) AS Q,productid FROM pobbooking WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."' AND qty!='0' GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTl->doctor_name." -DOCTOR SAMPLE GIVEN PRODUCT</h2>";
		$drsg=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th><th style="text-align:center">QUANTITY</th></tr>
</thead> 
<tbody>  
<?php while($MR1sg=mysql_fetch_object($SQLc1sg)){ 
	
	$SQL2sg=mysql_query("SELECT * FROM product WHERE id='".$MR1sg->productid."' ");
	$MR2sg=mysql_fetch_object($SQL2sg);

	?>
	<tr class="docusesamp"><td style="text-align:center"><?=$drsg; ?></td>
    <td style="text-align:center"><?php echo $MR2sg->pro_name; ?></td>	
				<td style="text-align:center"><?php echo $MR1sg->Q; ?></td>
<?php			
			$drsg++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
<?php
	}

	if(isset($_GET["usesamplechm"])){
		// echo "SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id='".$_GET['cldid']."'  AND drorchemist='SHOP'";
		$DRlchm=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id='".$_GET['cldid']."'  aND drorchemist='SHOP'");
		echo mysql_error();
		$DRCNTlchm=mysql_fetch_object($DRlchm);
		
		$SQLc1uschm=mysql_query("SELECT productid FROM pobbooking WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."' AND qty='0' GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTlchm->doctor_name." -CHEMIST PRODUCT USING</h2>";
		$druschm=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th></tr>
</thead> 
<tbody> 

<?php while($MR1uschm=mysql_fetch_object($SQLc1uschm)){ 
	
	$SQL2uschm=mysql_query("SELECT * FROM product WHERE id='".$MR1uschm->productid."' ");
	$MR2uschm=mysql_fetch_object($SQL2uschm);

	?>
	<tr class="docusesamp"><td style="text-align:center"><?=$druschm; ?></td>
    <td style="text-align:center"><?php echo $MR2uschm->pro_name; ?></td>	
				<!-- <td style="text-align:center"><?php echo $MR1us->Q; ?></td> -->
<?php			
			$druschm++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
<?php
$SQLc1sgchm=mysql_query("SELECT sum(qty) AS Q,productid FROM pobbooking WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."' AND qty!='0' GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTlchm->doctor_name." -CHEMIST SAMPLE GIVEN PRODUCT</h2>";
		$drsgchm=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th><th style="text-align:center">QUANTITY</th></tr>
</thead> 
<tbody>  
<?php while($MR1sgchm=mysql_fetch_object($SQLc1sgchm)){ 
	
	$SQL2sgchm=mysql_query("SELECT * FROM product WHERE id='".$MR1sgchm->productid."' ");
	$MR2sgchm=mysql_fetch_object($SQL2sgchm);

	?>
	<tr class="docusesamp"><td style="text-align:center"><?=$drsgchm; ?></td>
    <td style="text-align:center"><?php echo $MR2sgchm->pro_name; ?></td>	
				<td style="text-align:center"><?php echo $MR1sgchm->Q; ?></td>
<?php			
			$drsgchm++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
<?php
	}

	
//////////VISITIED REPORT////


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
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=1 ORDER BY reporteddate DESC");
		} else {
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=1 ORDER BY reporteddate DESC");
		}

?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
	<tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><th style="text-align:center">Category</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="text-align:center">Reported</th>
	<!-- <th style="text-align:center">Intime</th> -->
	<th style="text-align:center">Outtime</th>
	<th style="text-align:center">Prescription Value</th>
	<th style="text-align:center">Pob Value</th>
	<th style="text-align:center">PINCODE</th></tr>


    </thead> 
    <tbody>
		<?php $P=1;while($DR=mysql_fetch_object($D)){ 

if($DR->intime !='' && $DR->reportedtime !='')
{
												$res2= strtotime($DR->reportedtime);
												$res12=strtotime($DR->intime);
												$diff_minutes2 = $res2 - $res12;
												$trf2=date("H:i:s", $diff_minutes2);
											}else{
												$trf2='--';
											}
			// echo "SELECT pin_id FROM master_pincode WHERE pincode='".$DR->pincode."'";
			 $SQL = mysql_query("SELECT pin_id FROM master_pincode WHERE pincode='".$DR->pincode."'");
                 $RS = mysql_fetch_object($SQL);
                 // echo "SELECT chemist_id FROM doctors WHERE doctor_name='".$DR->name."' AND doc_pin_id='".$RS->pin_id."'";
                 $DOCTORID = mysql_query("SELECT chemist_id FROM doctors WHERE doctor_name='".$DR->name."' AND doc_pin_id='".$RS->pin_id."'");
                 $DRID = mysql_fetch_object($DOCTORID);
                  $b1=mysql_query("SELECT SUM(quantity) AS YQTY, SUM(free_quantity) AS YFQTY, SUM(replace_quantity) AS YRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp a WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id IN (".$DRID->chemist_id.") AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != ''"); $customer3=mysql_fetch_object($b1); 
                  // echo round($customer3->YPTS,2);
                 ?>

    <?php if ($DR->drunavailable == '0') { ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){} else { ?><td><?=$DR->doc_qualification; ?></td>	<td><?=$DR->doc_category; ?></td><?php } ?>
					<td><?=$DR->drunavailablereason; ?></td>
					<!-- <td><?=$DR->intime; ?></td> -->
				
					<td><?=date("d/m/Y",strtotime($DR->reporteddate))." ".$DR->reportedtime; ?></td>
										<td><?=$DR->prescriptionvalue; ?></td>
										<td><?=$DR->pobvalue; ?></td>

                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
	<?php } else { ?>

		<tr style="color: red;">
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){} else { ?><td><?=$DR->doc_qualification; ?></td>	<td><?=$DR->doc_category; ?></td><?php } ?>
					<td><?=$DR->drunavailablereason; ?></td>
					<!-- <td><?=$DR->intime; ?></td> -->
				
					<td><?=date("d/m/Y",strtotime($DR->reporteddate))." ".$DR->reportedtime; ?></td>
										<td><?=$DR->prescriptionvalue; ?></td>
										<td><?=$DR->pobvalue; ?></td>

                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>

	<?php } ?>

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
		
/////2 time////
		
		if($CNT1>0){
			$R1=mysql_fetch_object($SQL1);
			echo "<h3> Two Time Visit Listed ".$_SESSION["LABEL"]." (".$R1->DR.") </h3>";

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=2 ORDER BY reporteddate DESC");
		} else {
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) as D FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=2 ORDER BY reporteddate DESC");
		}
			
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><th style="text-align:center;width:25%;">Category</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="width:50%;"><table style="width:100%;"><tr><th style="text-align:center;width:35%;">Reported</th>
	<th style="text-align:center;width:15%;">Intime</th>
	<th style="text-align:center;width:35%;">Outtime</th>
	<th style="text-align:center;width:25%;">Prescription Value</th>
	<th style="text-align:center;width:20%;">Pob Value</th>
	<th style="text-align:center;width:15%;">Spend Time</th>
	<th style="text-align:center;width:35%;">PINCODE</th></tr></table></th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR1=mysql_fetch_object($D1)){ 

			if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D15=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime
			,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR1->wp_dc_id."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id  ORDER BY reporteddate DESC");
		} else {
			$D15=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,
			doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR1->wp_dc_id."' AND tbl_work_plan.wp_dc_id=doctors.id  ORDER BY reporteddate DESC");
		}
	
		?>

				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR1->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){} else { ?><td><?=$DR1->doc_qualification; ?></td>
						<td style="width:35%;"><?php echo $DR1->doc_category; ?></td><?php } ?>
              
                	<td style="width:50%;">
                		<table style="width:100%;">
                			<?php while($DR15=mysql_fetch_object($D15)){ 
								
								if($DR15->intime !='' && $DR15->reportedtime !='')
								{
									$res3= strtotime($DR15->reportedtime);
									$res13=strtotime($DR15->intime);
									$diff_minutes3 = $res3 - $res13;
									$trf3=date("H:i:s", $diff_minutes3);
								}else{
									$trf3='--';
								}

								?>

                    <?php if ($DR15->drunavailable == '0') { ?>
                			<tr>
                			<td style="width:35%;"><?php echo $DR15->drunavailablereason; ?></td>
                			<td style="width:15%;"><?php echo $DR15->intime; ?></td>

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR15->reporteddate))." ".$DR15->reportedtime; ?></td>
							<td style="width:25%;"><?=$DR15->prescriptionvalue; ?></td>
										<td style="width:25%;"><?=$DR15->pobvalue; ?></td>
                			<td style="width:15%;"><?php echo $trf3; ?></td>

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR15->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR15->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
				<?php } else { ?>

					<tr style="color: red;">
                			<td style="width:35%;"><?php echo $DR15->drunavailablereason; ?></td>
                			<td style="width:15%;"><?php echo $DR15->intime; ?></td>

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR15->reporteddate))." ".$DR15->reportedtime; ?></td>
							<td style="width:25%;"><?=$DR15->prescriptionvalue; ?></td>
										<td style="width:25%;"><?=$DR15->pobvalue; ?></td>
                			<td style="width:15%;"><?php echo $trf3; ?></td>

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR15->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR15->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>

					<?php } ?>


                <?php } ?>
                
            </table>
        </td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		
		// THREE TIMES/////
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
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D=3 ORDER BY reporteddate DESC");
		} else {
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D=3 ORDER BY reporteddate DESC");
		}
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
      <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><th style="text-align:center;width:35%;">Category</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="width:50%;"><table style="width:100%;"><tr><th style="text-align:center;width:35%;">Reported</th>
	<th style="text-align:center;width:15%;">Intime</th>
	<th style="text-align:center;width:35%;">Outtime</th>
	<th style="text-align:center;width:15%;">Spend Time</th>

	<th style="text-align:center;width:35%;">PINCODE</th></tr></table></th></tr>
    </thead>
    <tbody>
		<?php $P=1;while($DR2=mysql_fetch_object($D2)){ 
			if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D152=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR2->wp_dc_id."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id  ORDER BY reporteddate DESC");
		} else {
			$D152=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR2->wp_dc_id."' AND tbl_work_plan.wp_dc_id=doctors.id  ORDER BY reporteddate DESC");
		} ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR2->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){} else { ?><td><?=$DR2->doc_qualification; ?></td>
						<td style="width:35%;"><?php echo $DR2->doc_category; ?></td><?php } ?>
              
                	<td style="width:50%;">
                		<table style="width:100%;">
                			
                			<?php while($DR152=mysql_fetch_object($D152)){ 
								
																
if($DR152->intime !='' && $DR152->reportedtime !='')
{
												$res4= strtotime($DR152->reportedtime);
												$res14=strtotime($DR152->intime);
												$diff_minutes4 = $res4 - $res14;
												$trf4=date("H:i:s", $diff_minutes4);
											}else{
												$trf4='--';
											}
								?>

<?php if ($DR152->drunavailable == '0') { ?>
                			<tr>
                			<td style="width:35%;"><?php echo $DR152->drunavailablereason; ?></td>
                			<td style="width:15%;"><?php echo $DR152->intime; ?></td>

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR152->reporteddate))." ".$DR152->reportedtime; ?></td>
                			<td style="width:15%;"><?php echo $trf4; ?></td>

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR152->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR152->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
				<?php } else { ?>
					<tr style="color:red;">
                			<td style="width:35%;"><?php echo $DR152->drunavailablereason; ?></td>
                			<td style="width:15%;"><?php echo $DR152->intime; ?></td>

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR152->reporteddate))." ".$DR152->reportedtime; ?></td>
                			<td style="width:15%;"><?php echo $trf4; ?></td>

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR152->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR152->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
                <?php } ?>

                <?php } ?>
                
            </table>
        </td>
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
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id GROUP BY wp_dc_id HAVING D>3 ORDER BY reporteddate DESC");
		} else {
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.drunavailable,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id,COUNT(wp_dc_id) AS D FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id=doctors.id GROUP BY wp_dc_id HAVING D>3 ORDER BY reporteddate DESC");
		}
	?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		  <thead>
    <tr><th style="text-align:center">S.NO</th><?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Qualification</th><th style="text-align:center;width:35%;">Category</th><?php } else { ?><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><?php } ?><th style="width:50%;"><table style="width:100%;"><tr><th style="text-align:center;width:35%;">Reported</th>
	<!-- <th style="text-align:center;width:15%;">Intime</th> -->
	<th style="text-align:center;width:35%;">Outtime</th>
	<!-- <th style="text-align:center;width:15%;">Spend Time</th> -->

	<th style="text-align:center;width:35%;">PINCODE</th></tr></table></th></tr>
    </thead>
		<tbody>
			<?php $P=1;while($DR3=mysql_fetch_object($D3)){ 
					if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
			$D153=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_customer_master.shop_name as name,tbl_customer_master.pincode,wp_rep_id R,wp_dc_id FROM tbl_work_plan,tbl_customer_master WHERE attendancestatus='1' AND wp_dc='C' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR3->wp_dc_id."' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id  ORDER BY reporteddate DESC");
		} else {
			$D153=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR3->wp_dc_id."' AND tbl_work_plan.wp_dc_id=doctors.id  ORDER BY reporteddate DESC");
		}
		?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR3->name; ?></td><?php if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){} else { ?><td><?=$DR3->doc_qualification; ?></td>
						<td style="width:35%;"><?php echo $DR3->doc_category; ?></td><?php } ?>
              
                	<td style="width:50%;">
                		<table style="width:100%;">
                			
                			<?php while($DR153=mysql_fetch_object($D153)){ 

								if($DR153->intime !='' && $DR153->reportedtime !='')
								{
									$res5= strtotime($DR153->reportedtime);
												$res15=strtotime($DR153->intime);
												$diff_minutes5 = $res5 - $res15;
												$trf5=date("H:i:s", $diff_minutes5);
											}else{
												$trf5='--';
											}
								?>

                      <?php if ($Y->drunavailable == '0') { ?>
                			<tr>
                			<td style="width:35%;"><?php echo $DR153->drunavailablereason; ?></td>
                			<!-- <td style="width:15%;"><?php echo $DR153->intime; ?></td> -->

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR153->reporteddate))." ".$DR153->reportedtime; ?></td>
                			<!-- <td style="width:15%;"><?php echo $trf5; ?></td> -->

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR153->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR153->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>

				<?php } else { ?>

					<tr style="color:red;">
                			<td style="width:35%;"><?php echo $DR153->drunavailablereason; ?></td>
                			<!-- <td style="width:15%;"><?php echo $DR153->intime; ?></td> -->

							<td style="width:35%;"><?=date("d/m/Y",strtotime($DR153->reporteddate))." ".$DR153->reportedtime; ?></td>
                			<!-- <td style="width:15%;"><?php echo $trf5; ?></td> -->

                    <td style="text-align:right;width:35%;">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR153->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR153->pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>

					<?php } ?>

                <?php } ?>
                
            </table>
        </td>
                </tr>
			<?php $P++;} ?>
		</tbody>
		</table>
	<?php
		}

////chemist list///

		if($_SESSION['chem_cnt']>0){
			$SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue,drunavailable FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
			echo mysql_error();
			$CNT1=mysql_num_rows($SQL1);
			if($CNT1>0){
				if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
					echo "<h2>".$_GET["rep_name"]." - CHEMIST LIST</h2>";
				} else {
					echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
				}
			$P=1;
		?>
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
		
			<?php if ($R1->drunavailable == '0') { ?>
				
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
			<?php } else { ?>
		
				<tr style="color:red;"><td style="text-align:center"><?=$P; ?></td>
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
			<?php } ?>
		
		<?php			
					$P++;}
		?>
		</tbody>
		</table>
		<?php
				}	
			}



			////doctor unapprove list///

		if($_SESSION['doc_cnt']>0){
			$SQL1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name as name,doctors.doc_pincode as pincode,doctors.doc_qualification,doctors.doc_category,wp_rep_id R,wp_dc_id FROM tbl_work_plan,doctors WHERE attendancestatus='1' AND wp_dc='D' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND doctors.managerapprovestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id  ORDER BY reporteddate DESC");
			echo mysql_error();
			$CNT1=mysql_num_rows($SQL1);

			if($CNT1>0){
				if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
					echo "<h2>".$_GET["rep_name"]." - DOCTOR UNAPPROVE LIST</h2>";
				} else {
					echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
				}
			$P=1;
		?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		<thead>
		<tr><th style="text-align:center">S.NO</th><th style="text-align:center">DOCTOR NAME</th>
		<th>REPORTED DATE/TIME</th>
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
		
			<?php if ($R1->drunavailable == '0') { ?>
				
			<tr><td style="text-align:center"><?=$P; ?></td>
			<td><?=$R1->name; ?></td>
			<td><?php if($R1->reporteddate!=""){echo date("d/m/Y",strtotime($R1->reporteddate))." ".$R1->reportedtime;} ?></td>
			<td><?=$R1->prescriptionvalue; ?></td>
			<td><?=$R1->pobvalue; ?></td>
			<td style="text-align:right">
				<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R1->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
				echo $R1->pincode."-".$areaname->area_name; ?>
			</td>
			</tr>
			<?php } else { ?>
		
				<tr style="color:red;"><td style="text-align:center"><?=$P; ?></td>
			<td><?=$R1->name; ?></td>
			<td><?php if($R1->reporteddate!=""){echo date("d/m/Y",strtotime($R1->reporteddate))." ".$R1->reportedtime;} ?></td>
			<td><?=$R1->prescriptionvalue; ?></td>
			<td><?=$R1->pobvalue; ?></td>
			<td style="text-align:right">
				<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R1->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
				echo $R1->pincode."-".$areaname->area_name; ?>
			</td>
			</tr>
			<?php } ?>
		
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