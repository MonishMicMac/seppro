<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);
	if(isset($_GET["consolidated"])){		
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.doc_pincode,reporteddate,reportedtime FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - DOCTOR LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">DOCTOR</th><th>LAST VISITED</th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->doctor_name; ?></td><td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
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
		$SQL1=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$_GET["rep"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
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
		$SQL=mysql_query("SELECT doctor_name,doc_pincode FROM doctors WHERE rep_id ='".$_GET["rep"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='D' AND wp_rep_id='".$_GET["rep"]."' GROUP BY wp_dc_id)");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - DOCTOR MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">DOCTOR</th><th style="text-align:center">PINCODE</th></tr>
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
	if(isset($_GET["detailed"])){
		echo "<h2>".$_GET["rep_name"]." - Visited Call Report for ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."</h2>";
		$SQL=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=1) AS B GROUP BY R");
		$CNT=mysql_num_rows($SQL);	
		if($CNT>0){
			$R=mysql_fetch_object($SQL); 
			echo "<h3> One Visit Listed Doctor (".$R->DR.") </h3>";
			$D=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=1 ORDER BY reportedtime DESC");
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
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
		$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=2) AS B GROUP BY R");
		$CNT1=mysql_num_rows($SQL1);			
		if($CNT1>0){
			$R1=mysql_fetch_object($SQL1);
			echo "<h3> Two Time Visit Listed Doctor (".$R1->DR.") </h3>";
			$D1=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=2");
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR1=mysql_fetch_object($D1)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR1->doctor_name; ?></td><td><?=$DR1->doc_qualification; ?></td><td><?=$DR1->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR1->reporteddate))." ".$DR1->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR1->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR1->doc_pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		
		// THREE TIMES
		$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D=3) AS B GROUP BY R");
		$CNT2=mysql_num_rows($SQL2);			
		if($CNT2>0){
			$R2=mysql_fetch_object($SQL2); 
			echo "<h3> Three Time Visit Listed Doctor (".$R2->DR.") </h3>";
			$D2=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D=3");
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR2=mysql_fetch_object($D2)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR2->doctor_name; ?></td><td><?=$DR2->doc_qualification; ?></td><td><?=$DR2->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR2->reporteddate))." ".$DR2->reportedtime; ?></td>
                    <td style="text-align:right">
						<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR2->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
                        echo $DR2->doc_pincode."-".$areaname->area_name; ?>
                    </td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// > 3 TIMES
		$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT `wp_rep_id` R,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan` WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' GROUP BY `wp_dc_id` HAVING D>3) AS B GROUP BY R");
		$CNT3=mysql_num_rows($SQL3);	
		if($CNT3>0){
			$R3=mysql_fetch_object($SQL3); 
			echo "<h3> More than 3 Visit Listed Doctor (".$R3->DR.") </h3>";
			$D3=mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doc_qualification,`wp_rep_id` R,`wp_dc_id`,COUNT(`wp_dc_id`) AS D FROM `tbl_work_plan`,doctors WHERE attendancestatus='1' AND `wp_dc`='D' AND (`wp_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_rep_id='".$_GET["rep"]."' AND `tbl_work_plan`.wp_dc_id=doctors.id GROUP BY `wp_dc_id` HAVING D>3");
	?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		<thead>
		<tr><th style="text-align:center">S.NO</th><th style="text-align:center">DR</th><th style="text-align:center">Qualification</th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
		</thead> 
		<tbody>
			<?php $P=1;while($DR3=mysql_fetch_object($D3)){ ?>
					<tr>
						<td style="text-align:center"><?=$P; ?></td><td><?=$DR3->doctor_name; ?></td><td><?=$DR3->doc_qualification; ?></td><td><?=$DR3->drunavailablereason; ?></td><td><?=date("d/m/Y",strtotime($DR3->reporteddate))." ".$DR3->reportedtime; ?></td>
						<td style="text-align:right">
							<?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$DR3->doc_pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
							echo $DR3->doc_pincode."-".$areaname->area_name; ?>
						</td>
					</tr>
			<?php $P++;} ?>
		</tbody>
		</table>
	<?php
		}
	}
?>