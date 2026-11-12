<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER,DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);
	if(isset($_GET["consolidated"])){	
	// echo "SELECT doctors.doctor_name,doctors.drorchemist,doctors.doc_pincode,reporteddate,reportedtime,drunavailablereason FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC";	
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.drorchemist,doctors.doc_pincode,reporteddate,reportedtime,drunavailablereason FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_rep_id='".$_GET["rep"]."' AND (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND tbl_work_plan.wp_dc ='D' AND tbl_work_plan.attendancestatus = 1 ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - Customer LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th>REPORTED</th><th>LAST VISITED</th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->doctor_name; ?></td><td><?=$R->drunavailablereason; ?></td><td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
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
		$SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime 
		FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_GET["rep"]."' 
		AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' 
		GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
		echo mysql_error();
		$CNT1=mysql_num_rows($SQL1);
		if($CNT1>0){
		echo "<h2>".$_GET["rep_name"]." - CHEMIST LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CHEMIST</th><th>LAST VISITED</th><th style="text-align:center">PINCODE</th></tr>
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
	
	if(isset($_GET["missed"])){	
	// echo "SELECT doctor_name,doc_pincode,drorchemist FROM doctors WHERE rep_id ='".$_GET["rep"]."' AND id IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='D' AND wp_rep_id='".$_GET["rep"]."' AND attendancestatus !=1)";	
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.drorchemist,doctors.doc_pincode,reporteddate,reportedtime,drunavailablereason FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_rep_id='".$_GET["rep"]."' AND (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND tbl_work_plan.wp_dc ='D' AND tbl_work_plan.attendancestatus = 0 ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - CUSTOMER MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">PINCODE</th></tr>
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
		$SQL1=mysql_query("SELECT shop_name,pincode FROM tbl_customer_master WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='C' AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		echo mysql_error();
		$CNT1=mysql_num_rows($SQL1);
		if($CNT1>0){
		echo "<h2>".$_GET["rep_name"]." - CHEMIST MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CHEMIST</th><th style="text-align:center">PINCODE</th></tr>
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
		$SQL1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1') ");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - DOCTOR VISITED</h2>";
		$dr=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><!-- <th style="text-align:center">PRODUCT USING</th><th style="text-align:center">SAMPLE GIVEN</th><th style="text-align:center">GIFT BOX</th> --><th style="text-align:center">REMARKS</th><th style="text-align:center">TYPE OF CALLS</th><th style="text-align:center">REPORTING TIME</th></tr>
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
   <!--  <td style="text-align:right">
	<?php echo $MR2->samlpd;
	 // $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$MR1->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		// echo $MR1->doc_pincode."-".$areaname->area_name; ?> </td>
		
				<td style="text-align:center"><?php echo $MR2->pdlit; ?></td>
<td style="text-align:center"><?php echo $SQLgrt_res->gift; ?></td> -->
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
<!-- <div style="height:auto;" id="docterprductusesample"></div>  -->

<?php

// echo "SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
// 		$SQL=mysql_query("SELECT  SUM(CASE WHEN qty= '0' THEN 1 ELSE 0 END) as samlpd FROM pobbooking WHERE client_id IN(SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')");
	// echo "SELECT doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1')";
		// $SQLc1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(wp_dc_id) AS clid FROM tbl_work_plan WHERE wp_rep_id='".$_GET["rep"]."' AND wp_date='".$_GET["daterep"]."' AND attendancestatus='1') aND drorchemist='SHOP'");
		// echo mysql_error();
		
		// echo "<h2>".$DRCNT->rep_name." - CHEMIST VISITED</h2>";
		// $drc=1;
?>
<!-- <table id="examplechm" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
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
</table> -->
<!-- <hr style="border:1px solid #317eac;height: 0px;"> -->
<div>&nbsp;</div>      
<div style="height:auto;" id="docterprductusesamplechm">
</div> 

	<script type="text/javascript">

	$('.docusesamp').click(function(){

		$.get("autosearch-y/nurse_report.php?usesample=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
			$("#docterprductusesample").html(data);
		});	
		// $.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
		// 	$("#consolidated").html(data);
		// });		
	});
$('.chmusesamp').click(function(){

		$.get("autosearch-y/nurse_report.php?usesamplechm=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
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



	if(isset($_GET["detailed"])){
		echo "<h2>".$_GET["rep_name"]." - Visited Call Report for ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."</h2>";
		$SQL=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=1) AS B GROUP BY R");
		$CNT=mysql_num_rows($SQL);	
		if($CNT>0){
			$R=mysql_fetch_object($SQL); 
			echo "<h3> One Visit Listed Customer (".$R->DR.") </h3>";
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=1 ORDER BY reportedtime DESC");
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR=mysql_fetch_object($D)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR->doctor_name; ?></td><td><?=$DR->doc_qualification; ?></td><td><?=$DR->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR->reporteddate))." ".$DR->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR->doc_pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// TWO TIMES
		// echo "SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=2) AS B GROUP BY R";
		$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=2) AS B GROUP BY R");
		$CNT1=mysql_num_rows($SQL1);			
		if($CNT1>0){
			$R1=mysql_fetch_object($SQL1);
			echo "<h3> Two Time Visit Listed customer (".$R1->DR.") </h3>";
			// echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=2";
			
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">Count</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $D1ex=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=2");
		$s=1;
			while($DR1ex=mysql_fetch_object($D1ex))
			{
			
			// echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id` FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR1ex->wp_dc_id."' AND  `tbl_work_plan`.wp_dc_id=doctors.id ";
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id` FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR1ex->wp_dc_id."' AND  `tbl_work_plan`.wp_dc_id=doctors.id ");
			 $P=1;while($DR1=mysql_fetch_object($D1)){ 
			 ?>
				<tr>
                	<td style="text-align:center"><?=$s; ?><td style="text-align:center"><?=$P; ?></td><td><?=$DR1->doctor_name; ?></td><td><?=$DR1->doc_qualification; ?></td><td><?=$DR1->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR1->reporteddate))." ".$DR1->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR1->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR1->doc_pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
		<?php  $P++;  } $s++;  } ?>
    </tbody>
    </table>
<?php
		}
		
		// THREE TIMES
		$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=3) AS B GROUP BY R");
		$CNT2=mysql_num_rows($SQL2);			
		if($CNT2>0){
			$R2=mysql_fetch_object($SQL2); 
			echo "<h3> Three Time Visit Listed Customer (".$R2->DR.") </h3>";
			
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">Count</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php  $D2ex=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND `wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=3");
		$s=1;
			while($DR2ex=mysql_fetch_object($D2ex))
			{
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id` FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND `wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR2ex->wp_dc_id."' AND `tbl_work_plan`.wp_dc_id=doctors.id ");
			 $P=1;while($DR2=mysql_fetch_object($D2)){ ?>
				<tr>
                	<td style="text-align:center"><?=$s; ?><td style="text-align:center"><?=$P; ?></td><td><?=$DR2->doctor_name; ?></td><td><?=$DR2->doc_qualification; ?></td><td><?=$DR2->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR2->reporteddate))." ".$DR2->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR2->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR2->doc_pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
		<?php $P++;  } $s++; }?>
    </tbody>
    </table>
<?php
		}
		// > 3 TIMES
		$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D>3) AS B GROUP BY R");
		$CNT3=mysql_num_rows($SQL3);	
		if($CNT3>0){
			$R3=mysql_fetch_object($SQL3); 
			echo "<h3> More than 3 Visit Listed Customer (".$R3->DR.") </h3>";
	
	?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		<thead>
		<tr><th style="text-align:center">S.NO</th><th style="text-align:center">Count</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
		</thead> 
		<tbody>
			<?php 		$D3ex=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D>3");
			$s=1;	
			while($DR3ex=mysql_fetch_object($D3ex))
			{
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id` FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND tbl_work_plan.wp_dc_id='".$DR3ex->wp_dc_id."' AND `tbl_work_plan`.wp_dc_id=doctors.id ");
			 $P=1;  while($DR3=mysql_fetch_object($D3)){ ?>
					<tr>
						<td style="text-align:center"><?=$s; ?><td style="text-align:center"><?=$P; ?></td><td><?=$DR3->doctor_name; ?></td><td><?=$DR3->doc_qualification; ?></td><td><?=$DR3->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR3->reporteddate))." ".$DR3->reportedtime; ?></td>
						<td style="text-align:right">
							<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR3->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
							echo $DR3->doc_pincode."-".$areaname->area_name; ?>
						</td>
					</tr>
			<?php $P++;   } $s++; }  ?>
		</tbody>
		</table>
	<?php
		}
	}
?>