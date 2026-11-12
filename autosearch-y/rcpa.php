<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if(isset($_GET["theraphy"])){
	mysql_query("INSERT INTO mst_theraphy(theraphy) VALUES('".$_GET["theraphy_name"]."')");
	echo "Theraphy Added";
}

if(isset($_GET["composition"])){
	mysql_query("INSERT INTO mst_composition(composition) VALUES('".$_GET["composition_name"]."')");
	echo "Composition Added";
}
if(isset($_GET["company"])){
	mysql_query("INSERT INTO mst_company(company) VALUES('".$_GET["company_name"]."')");
	echo "Company Added";
}

if(isset($_GET["rcpa"])){
	mysql_query("INSERT INTO tbl_rcpa(pin_id,dc_id,pat_floatng,stockist_id,patient_type,theraphy,composition,brand_name,qty,company_name,c_date,c_time) VALUES('".$_GET["pin_id"]."','".$_GET["chemist_name"]."','".$_GET["avg_patient"]."','".$_GET["doc_stockist"]."','".$_GET["doc_patient_type"]."','".$_GET["theraphy_name"]."','".$_GET["composition_name"]."','".$_GET["brand_name"]."','".$_GET["qty"]."','".$_GET["company_name"]."','".date("Y-m-d")."','".date("H:i:s")."')");
	echo "RCPA Added";
}

if(isset($_GET["pat_type"])){
	$SQL=mysql_query("SELECT * FROM mst_patient_type WHERE patient_type_name='".$_GET["pt_name"]."'");
	$CNT=mysql_num_rows($SQL);
	if($CNT==0){
		mysql_query("INSERT INTO mst_patient_type(patient_type_name) VALUES('".$_GET["pt_name"]."')");
		$C=mysql_insert_id();
	}
	if($CNT==1){
		$R=mysql_fetch_object($SQL);
		$C=$R->patient_id;
	}
	$PT=mysql_query("SELECT * FROM tbl_drpatient_type WHERE doctor_id = 0 AND patient_type_id = ".$C."");
	$CNT1=mysql_num_rows($PT);
	if($CNT1==0){
		mysql_query("INSERT INTO tbl_drpatient_type(doctor_id,patient_type_id) VALUES(0,".$C.")");
	}
	if($CNT1==1){echo "<strong>Patient Type Exists!!!</strong>";}
	$S=mysql_query("SELECT mst_patient_type.patient_type_name AS PTNAME,tbl_drpatient_type.drpatient_type_id AS ID  FROM mst_patient_type,tbl_drpatient_type WHERE mst_patient_type.patient_id=tbl_drpatient_type.patient_type_id AND tbl_drpatient_type.doctor_id=0");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Patient Type</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->PTNAME; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->ID; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["pat_type_del"])){
	mysql_query("DELETE FROM tbl_drpatient_type WHERE drpatient_type_id=".$_GET["pt_id"]."");
$S=mysql_query("SELECT mst_patient_type.patient_type_name AS PTNAME,tbl_drpatient_type.drpatient_type_id AS ID  FROM mst_patient_type,tbl_drpatient_type WHERE mst_patient_type.patient_id=tbl_drpatient_type.patient_type_id AND tbl_drpatient_type.doctor_id=0");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Patient Type</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->PTNAME; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->ID; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["area_id"])){
	$Pin=mysql_query("SELECT * FROM pincode_list WHERE pin_id=".$_GET["pin_id"]." AND area_name='".$_GET["area_name"]."'");
	$CNT=mysql_num_rows($Pin);
	if($CNT==1){
		echo "Hi! Already Area Available.";
	}
	if($CNT==0){
		$Pin1=mysql_query("SELECT * FROM pincode_list WHERE pin_id=".$_GET["pin_id"]."");
		$T=mysql_fetch_object($Pin1);
		mysql_query("INSERT INTO pincode_list(state_id,state_name,dist_id,area_name,pin_id,pincode,c_date,c_time) VALUES('".$T->state_id."','".$T->state_name."','".$T->dist_id."','".$_GET["area_name"]."','".$_GET["pin_id"]."','".$T->pincode."','".date("Y-m-d")."','".date("H:i:s")."')");
		echo "Thank You Very Much, Area Added.";
	}
}
if(isset($_GET["pttype"])){		
	$DC=mysql_query("SELECT doctor_id FROM tbl_drpatient_type WHERE doctor_id IN (SELECT doctor_id FROM tbl_doctor_chemist WHERE dc_id=".$_REQUEST["dc_id"].") AND patient_type_id IN (SELECT patient_id FROM mst_patient_type WHERE patient_type_name='".$_GET["pt_type"]."')");
	$CNT=mysql_num_rows($DC);
	if($CNT==1){
		echo "Hi! Already Patient Type Available.";
	}
	if($CNT==0){
		$D=mysql_fetch_object($DC);	
		$SQL=mysql_query("SELECT patient_id FROM mst_patient_type WHERE patient_type_name='".$_GET["pt_type"]."'");
		$C=mysql_num_rows($SQL);
		if($C==1){
			$R=mysql_fetch_object($SQL);		
			mysql_query("INSERT INTO tbl_drpatient_type(doctor_id,patient_type_id) VALUES('".$D->doctor_id."','".$R->patient_id."')");
		}
		if($C==0){	
			$D=mysql_query("SELECT doctor_id FROM tbl_doctor_chemist WHERE dc_id=".$_REQUEST["dc_id"]."");	
			$DR=mysql_fetch_object($D);				
			mysql_query("INSERT INTO mst_patient_type(patient_type_name) VALUES('".$_GET["pt_type"]."')");			
			$Z=mysql_insert_id();	
			mysql_query("INSERT INTO tbl_drpatient_type(doctor_id,patient_type_id) VALUES('".$DR->doctor_id."','".$Z."')");
		}
	}
}
if(isset($_GET["stockist"])){
	$SQL=mysql_query("SELECT * FROM mst_rcpa_stockist WHERE stockist_name='".$_GET["stockist_name"]."'");
	$CNT=mysql_num_rows($SQL);
	if($CNT==1){
		$D=mysql_fetch_object($SQL);
		mysql_query("INSERT INTO tbl_rcpa_stockist(dc_id,stockist_id) VALUES(".$_GET["dc_id"].",".$D->stockist_id.")");
	}
	if($CNT==0){		
		mysql_query("INSERT INTO mst_rcpa_stockist(stockist_name) VALUES('".$_GET["stockist_name"]."')");
		$Z=mysql_insert_id();		
		mysql_query("INSERT INTO tbl_rcpa_stockist(dc_id,stockist_id) VALUES(".$_GET["dc_id"].",".$Z.")");
	}	
}
if(isset($_GET["chemist_stockist"])){
	$SQL=mysql_query("SELECT * FROM mst_rcpa_stockist WHERE stockist_name='".$_GET["stockist_name"]."'");
	$CNT=mysql_num_rows($SQL);
	if($CNT==1){
		$D=mysql_fetch_object($SQL);
		mysql_query("INSERT INTO tbl_rcpa_stockist(dc_id,stockist_id) VALUES(0,".$D->stockist_id.")");
	}
	if($CNT==0){		
		mysql_query("INSERT INTO mst_rcpa_stockist(stockist_name) VALUES('".$_GET["stockist_name"]."')");
		$Z=mysql_insert_id();		
		mysql_query("INSERT INTO tbl_rcpa_stockist(dc_id,stockist_id) VALUES(0,".$Z.")");
	}	
}
if(isset($_GET["chemist_doctor"])){
	if($_GET["other_qua"]!=""){
		$SQL=mysql_query("SELECT * FROM mst_doctor_degree WHERE deg_name='".$_GET["other_qua"]."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT==0){
			mysql_query("INSERT INTO mst_doctor_degree(deg_name) VALUES('".$_GET["other_qua"]."')");
			$_GET["qualification"] = mysql_insert_id();		
		}
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			$_GET["qualification"] = $R->deg_id;
		}
	}	
	if($_GET["other_specialist"]!=""){
		$SQL=mysql_query("SELECT * FROM specilist_list WHERE specilist_name='".$_GET["other_specialist"]."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT==0){
			mysql_query("INSERT INTO specilist_list(specilist_name) VALUES('".$_GET["other_specialist"]."')");
			$_GET["specilist"] = mysql_insert_id();		
		}
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			$_GET["specilist"] = $R->id;
		}
	}
	if($_GET["other_category"]!=""){
		$SQL=mysql_query("SELECT * FROM mst_category WHERE category_name='".$_GET["other_category"]."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT==0){
			mysql_query("INSERT INTO mst_category(category_name) VALUES('".$_GET["other_category"]."')");
			$_GET["doc_category"] = mysql_insert_id();		
		}
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			$_GET["doc_category"] = $R->category_id;
		}
	}
	if($_GET["other_class"]!=""){
		$SQL=mysql_query("SELECT * FROM mst_classification WHERE classification_name='".$_GET["other_class"]."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT==0){
			mysql_query("INSERT INTO mst_classification(classification_name) VALUES('".$_GET["other_class"]."')");
			$_GET["doc_classification"] = mysql_insert_id();		
		}
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			$_GET["doc_classification"] = $R->classification_id;
		}
	}
	
	$area=mysql_query("SELECT id FROM pincode_list WHERE pin_id='".$_GET["che_pincode"]."' GROUP BY pin_id");
	$areaid=mysql_fetch_object($area);
	
	mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,doc_gender,doc_category,doc_yr_practice,doc_practice_loc,doc_practice_pday,dr_latitude,dr_longitude,doc_specific,doc_regis_no,doc_loc_address,doc_area_id,doc_pin_id,doc_contact_no,email,doc_status) VALUES ('".$_GET["doctor_name"]."','".$_GET["qualification"]."','".$_GET["specilist"]."','".$_GET["gender"]."','".$_GET["doc_category"]."','".$_GET["doc_yr_practice"]."','".$_GET["doc_practice_loc"]."','".$_GET["doc_practice_pday"]."','".$_GET["latitude1"]."','".$_GET["longitude1"]."','".$_GET["doc_specific"]."','".$_GET["dr_reg"]."','".$_GET["address1"]."','".$areaid->id."','".$_GET["che_pincode"]."','".$_GET["dr_cno"]."','".$_GET["dr_email"]."',0)");
	echo mysql_error();
}
?>