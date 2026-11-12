<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");


if(isset($_GET["representative"])){
	mysql_query("DELETE FROM rep_area WHERE rep_id=0");
	$SQL = mysql_query("SELECT * FROM tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id IN (".@$_GET["pin"].") AND tbl_tertiary.tertiary_pin=master_pincode.pin_id");
	while($R=mysql_fetch_object($SQL)){
		$P=mysql_query("SELECT * FROM rep_area WHERE rep_id=0 AND pin_id='".$R->tertiary_pin."'");
		$CNT=mysql_num_rows($P);
		if($CNT==0){
			mysql_query("INSERT INTO rep_area (rep_id,district_id,pin_id,tertiary_id,c_date,c_time) VALUES (0,'".$R->district_id."','".$R->tertiary_pin."','".$R->tertiary_id."','".date("Y-m-d")."','".date("H:i:s")."')");
		}
	}	
$S=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$_GET["pin"].")");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Tertiart Name</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->tertiary_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->tertiary_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php	
}
if(isset($_GET["representative_id"])){
	mysql_query("DELETE FROM rep_area WHERE tertiary_id=".@$_GET["pin"]."");
	$S=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$_GET["pin"].")");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Tertiart Name</th><th>Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->tertiary_name; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center"><a href="javascript:deleteMe('<?=$P->tertiary_id; ?>')"><img src="img/uploadify-cancel.png" width="16" height="16" /></a></td></tr>
    <?php $I++; } ?>
</table>
<?php
}
if(isset($_GET["manager"])){
	mysql_query("DELETE FROM tbl_manager_tertiary WHERE manager_id=0");
$SQL = mysql_query("SELECT * FROM tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id IN (".@$_GET["pin"].") AND tbl_tertiary.tertiary_pin=master_pincode.pin_id");
	while($R=mysql_fetch_object($SQL)){
		$P=mysql_query("SELECT * FROM tbl_manager_tertiary WHERE manager_id=0 AND tertiary_id='".$R->tertiary_pin."'");
		$CNT=mysql_num_rows($P);
		if($CNT==0){
			mysql_query("INSERT INTO tbl_manager_tertiary (manager_id,tertiary_id,c_date,c_time) VALUES (0,'".$R->tertiary_id."','".date("Y-m-d")."','".date("H:i:s")."')");
		}
	}	
$S=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (".@$_GET["pin"].")");
?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse">Tertiart Name</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=$I; ?></td><td style="border:1px solid #CCCCCC; border-collapse:collapse"><?=$P->tertiary_name; ?></td></tr>
    <?php $I++; } ?>
</table>
<?php
}
if(isset($_GET["mapping"])){
	foreach((array)$_GET["pin"] as $r){
		mysql_query("UPDATE pincode_list SET rep_id=".$_GET["rep"]." WHERE id=".$r."");
		mysql_query("UPDATE tbl_customer_master SET rep_id=".$_GET["rep"]." WHERE area_id=".$r."");
		mysql_query("UPDATE areawise_temp SET rep_id=".$_GET["rep"]." WHERE area_id=".$r."");
	}	
	echo "AREA MAPPED <-> REP";
}
if(isset($_GET["area"])){
	$SQL=mysql_query("SELECT * FROM master_pincode WHERE pin_id=".$_GET["pin"]."");
	$R=mysql_fetch_object($SQL);	
	mysql_query("INSERT INTO pincode_list(state_id,dist_id,area_name,pin_id,pincode,rep_id,c_date,c_time) VALUES('".$R->state_id."','".$R->district_id."','".$_GET["areaname"]."','".$R->pin_id."','".$R->pincode."','".$_GET["rep"]."','".date("Y/m/d")."','".date("H:i:s")."')");
	echo "NEW AREA ADDED";
}
if(isset($_GET["carea"])){	
	foreach((array)$_GET["pin"] as $r){
		mysql_query("DELETE FROM pincode_list WHERE id IN (".$r.")");
	}				
	$SQL=mysql_query("SELECT * FROM master_pincode WHERE pin_id=".$_GET["pincode"]."");
	$R=mysql_fetch_object($SQL);	
	mysql_query("INSERT INTO pincode_list(state_id,dist_id,area_name,pin_id,pincode,rep_id,c_date,c_time) VALUES('".$R->state_id."','".$R->district_id."','".$_GET["areaname"]."','".$R->pin_id."','".$R->pincode."','".$_GET["rep"]."','".date("Y/m/d")."','".date("H:i:s")."')");
	$LAST_ID = mysql_insert_id();
	foreach((array)$_GET["pin"] as $t)
		mysql_query("UPDATE  tbl_customer_master SET area_id=".$LAST_ID." WHERE area_id  IN (".$t.")");
	echo "AREA CORRECTED SUCCESSFULLY!!!";
}
if(isset($_GET["wp_rep"])){ // WORK PLAN - START
?>
    	
    	<select name="pin" id="pin" data-rel="chosen">  
        	<option value="">-- Select Representative --</option>      	
            <?php  $R=mysql_query("SELECT master_pincode.pin_id AS PIN, master_pincode.pincode AS P FROM rep_area,master_pincode WHERE rep_area.rep_id=".$_GET["pin"]." AND rep_area.pin_id=master_pincode.pin_id ORDER BY master_pincode.pin_id"); while($P=mysql_fetch_object($R)){ ?>
            	<option value="<?php echo $P->PIN; ?>"><?php echo $P->P; ?></option>
            <?php } ?>
        </select>
   
<?php	
}
if(isset($_GET["wp_chy"])){
	$A=mysql_query("SELECT * FROM tbl_customer_master WHERE pin_id=".$_GET["pin"]." AND rep_id=".$_GET["rep"]."");
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="t">
	<thead>
    <tr><td>Select</td><td>Sl.No</td><td>Chemist Name</td><td>Address</td><td>Last Planned</td><td>Last Visited</td></tr>
    </thead>
    <tbody>
    <?php $I=1; while($P=mysql_fetch_object($A)){ ?>
    <tr><td><input type="checkbox" name="chemist[]" id="chemist[]" value="<?=$P->id; ?>" /></td><td><?=$I; ?></td><td><?=$P->shop_name; ?></td><td><?=$P->customer_address; ?></td><td>NA</td><td>NA</td></tr>
    <?php $I++; } ?>
    </tbody>
</table>
<?php	
}
if(isset($_GET["work_plan"])){
	$chy = explode(",",$_GET["chemist"]);
	foreach($chy as $r){
		mysql_query("INSERT INTO  tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time) VALUES('".date("Y/m/d",strtotime($_GET["wp_date"]))."','".$_GET["pin"]."','".$_GET["dc"]."','".$r."','".$_GET["rep"]."','".date("Y/m/d")."','".date("H:i:s")."')");		
	}
}
if(isset($_GET["wp_dr"])){
	$A=mysql_query("SELECT * FROM doctors WHERE doc_pin_id=".$_GET["pin"]."");
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="t">
	<thead>
    <tr><td>Select</td><td>Sl.No</td><td>Doctor Name</td><td>Address</td><td>Last Planned</td><td>Last Visited</td></tr>
    </thead>
    <tbody>
    <?php $I=1; while($P=mysql_fetch_object($A)){ ?>
    <tr><td><input type="checkbox" name="chemist[]" id="chemist[]" value="<?=$P->id; ?>" /></td><td><?=$I; ?></td><td><?=$P->doctor_name; ?></td><td><?=$P->doctor_addrs; ?></td><td>NA</td><td>NA</td></tr>
    <?php $I++; } ?>
    </tbody>
</table>
<?php	
}
if(isset($_GET["wp_representative"])){
	$date=explode("/",$_GET["wp_date"]);
	$wp_date = $date[2]."/".$date[1]."/".$date[0];
	
$A=mysql_query("SELECT doctors.doctor_name AS DNAME, doctors.doctor_addrs AS ADDRESS FROM tbl_work_plan, doctors WHERE wp_rep_id=".$_GET["rep"]." AND wp_date='".$wp_date."' AND wp_dc='D' AND tbl_work_plan.wp_dc_id=doctors.id");
 $DCNT = mysql_num_rows($A);
 if($DCNT>0){
 	echo "<h3>DOCTOR APPOINTMENT @ ".$_GET["wp_date"]."</h3>";
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="t">
	<thead>
    <tr><td>Sl.No</td><td>Doctor Name</td><td>Address</td></tr>
    </thead>
    <tbody>
    <?php $I=1; while($P=mysql_fetch_object($A)){ ?>
    <tr><td><?=$I; ?></td><td><?=$P->DNAME; ?></td><td><?=$P->ADDRESS; ?></td></tr>
    <?php $I++; } ?>
    </tbody>
</table>
<div>&nbsp;</div>
<?php
}
	$C=mysql_query("SELECT tbl_customer_master.shop_name AS DNAME, tbl_customer_master.customer_address AS ADDRESS FROM tbl_work_plan, tbl_customer_master WHERE wp_rep_id=".$_GET["rep"]." AND wp_date='".$wp_date."' AND wp_dc='C' AND tbl_work_plan.wp_dc_id=tbl_customer_master.id");
	$CCNT = mysql_num_rows($C);
 	if($CCNT>0){
	echo "<h3>CHEMIST APPOINTMENT @ ".$_GET["wp_date"]."</h3>";
?>

<table class="table table-striped table-bordered bootstrap-datatable datatable" id="t" style="width:600px">
	<thead>
    <tr><td>Sl.No</td><td>Chemist Name</td><td>Address</td></tr>
    </thead>
    <tbody>
    <?php $I=1; while($CHY=mysql_fetch_object($C)){ ?>
    <tr><td><?=$I; ?></td><td><?=$CHY->DNAME; ?></td><td><?=$CHY->ADDRESS; ?></td></tr>
    <?php $I++; } ?>
    </tbody>
</table>
<?php	
}
}
if(isset($_GET["frr_dashboard"])){
	//echo $_GET["MGR"];
?>
<div style="width:43%; float:left; position:relative;">
    <div style="background:#F5F5F5; border-radius:5px;"> <!-- 1st INNER ROOT - Start -->                    	
    <h3 align="center" style="padding:5px">Representative Report</h3>
    <div style="border-top:1px solid #DADADA">&nbsp;</div>
    <div id="baba">
        <?php
				$BG=1;
                $rep=mysql_query("SELECT rep_name,id FROM  representative WHERE reporting_manager=".$_GET["MGR"].""); while($R=mysql_fetch_object($rep)){ 
				$RP=mysql_query("SELECT COUNT(wp_rep_id) as MPCNT FROM tbl_work_plan WHERE wp_rep_id =".$R->id." AND c_date='".date("2015-10-05")."' AND UP='P'"); $RPCNT=mysql_num_rows($RP);
				$RU=mysql_query("SELECT COUNT(wp_rep_id) as MPCNT FROM tbl_work_plan WHERE wp_rep_id =".$R->id." AND c_date='".date("2015-10-05")."' AND UP='U'");  $RUCNT=mysql_num_rows($RU);  				             
            ?>                     
    <div <?php if($BG % 2 == 0){ ?> style="background:#32CD32; width:15% color:#18140E; margin:5px; padding:15px; border-radius:5px;" <?php }if($BG % 2 != 0){ ?> style="background:#F5EB27; width:15% color:#18140E; margin:5px; padding:15px; border-radius:5px;" <?php } ?>>
        <div style="text-align:left;">
            <div>
            <table>
           
            <tr>
                <td><img <?php if($BG % 2 == 0){ ?>src="img/medical64.png"<?php }if($BG % 2 != 0){ ?>src="img/rep.png"<?php } ?> width="64" height="64" id="MGR" title="<?=$R->id; ?>"></td>
                <td>
                    <table style="font-size:12px;">
                            <tr><td><em><?=$R->rep_name; ?></em></td></tr>
                            <tr><td>Doctor Met</td></tr>
                            <tr><td>P - <?php  if($RPCNT>0){ $REPP=mysql_fetch_object($RP); echo $REPP->MPCNT;} if($RPCNT==0){echo 0;} ?> | U - <?php if($RUCNT>0){ $REPU=mysql_fetch_object($RU); echo $REPU->MPCNT; } if($RUCNT==0){echo 0;} ?> </td></tr>
                            <tr><td>LM - 0 | LUM - 0</td></tr>
                            <tr><td>PC - 0</td></tr>
                            <tr><td>SR - 0</td></tr>
                            <tr><td>Chemist Visit</td></tr>
                            <tr><td>P - 0 | UP - 0</td></tr>
                            <tr><td>LM - 0 | LUM - 0</td></tr>
                            <tr><td>SR - 0</td></tr>
                            <tr><td>RCPA - 0</td></tr>
                     </table>
                </td>
            </tr>
            
            </table>
            </div>
                                        
        </div>
    </div>   
    <?php $BG++; } ?>                     
    </div>
    <div>&nbsp;</div>
</div>
</div>
<?php	
}
if(isset($_GET["doctor"])){
	$SQL=mysql_query("SELECT * FROM doctors WHERE rep_assign=".$_GET["pin"]." ORDER BY doctor_name");
	$CNT=mysql_num_rows($SQL);
	if($CNT>0){
	echo "<input type='text' placeholder='search' onkeyup='filterValue(this.value)' style='width:200px;'>";	
?>
<h3>ASSIGN REPRESENTATIVE <-> DOCTOR </h3>
<table class="table table-striped table-bordered">
	<thead><th>Sl.No</th><th> <input type="checkbox" name="select" id="select" onclick="select1();" /> Select</th><th>Doctor Name</th><th>Specilist</th><th>Qualification</th><th>Doctor Address</th></thead>
    <tbody>
    
<?php 
    $y=1;
    while($BABA=mysql_fetch_object($SQL)){   
    
?>	
	<tr class="yuvi">
	<td><?=$y; ?></td>
    <td><input type="checkbox" name="doctors[]" value="<?=$BABA->id; ?>" ></td>            
    <td><?=$BABA->doctor_name; ?></td>
    <td><?=$BABA->doc_specilist_id; ?></td><td><?=$BABA->doc_qualification; ?></td><td><?=$BABA->doctor_addrs; ?></td></tr>
<?php $y++;} ?>

<tr><td colspan="6" style="text-align:right"><a href="#" id="doctor_assign"><img src="img/man259.png" width="64" height="64" onclick="yuvaraj()"></a></td></tr>
</tbody>        
</table>
<?php
	}
	if($CNT==0){
	
	}
}
if(isset($_GET["doctor_assign"])){
		mysql_query("UPDATE doctors SET rep_assign=".$_GET["rep_id"]." WHERE id IN (".$_GET["pin"].")");
		echo "DOCTOR <-> ASSIGNED TO REPRESENTATIVE";
}
if(isset($_GET["daily_report"])){
    // print_r($_GET["representative1"]);exit();
?>

<div style='float:right; width: 50px;'><a href="inout_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["representative1"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<br />
<!-- <?php
$from_date="2022-05-10";
$to_date="2022-12-15";
$id="1";
?>
<div style='float:right; width: 50px;'><a href="excel_download1.php?from_date=<?php echo @$from_date; ?>&to_date=<?php echo @$to_date; ?>&id=<?php echo @$id ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>

<br /> -->

<table class="table table-striped table-bordered bootstrap-datatable datatable" id="summary">
<tr><th style="text-align:center">S.NO</th>
<th style="text-align:center">PATIENT NAME</th>
<th style="text-align:center">CONTACT PERSON</th>
<th style="text-align:center">PHONE NUMBER</th>
<th style="text-align:center">ADDRESS</th>
<th style="text-align:center">LOCATION</th>
<th style="text-align:center">DISEASE NAME</th>
<th style="text-align:center">PATIENT DETAILS</th>
<th style="text-align:center">STATUS</th>

<th style="text-align:center">ACTION</th>
       </tr>
       <tbody>
	<?php	
		$p=1;	
		// echo "SELECT representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN `wp_dc`= 'D' THEN `wp_dc_id` END) as D,COUNT(DISTINCT CASE WHEN `wp_dc`= 'C' THEN `wp_dc_id` END) as C FROM `tbl_work_plan`,representative WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND tbl_work_plan.attendancestatus='1' AND `tbl_work_plan`.`wp_rep_id`=representative.id AND representative.rep_order!='0' ".$repmgrid." GROUP BY `tbl_work_plan`.`wp_rep_id` ORDER BY `representative`.`rep_order` ASC";
			if($_GET['representative1'] == '1'){			
		$SQL=mysql_query("SELECT patient_details.* FROM patient_details
        --  LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
        -- LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id

		 WHERE  patient_details.action = '0' ORDER BY patient_details.id DESC  
	
		 ");
    //  $Y=mysql_fetch_object($SQL);
    //  print_r($Y);exit();
            }elseif($_GET['representative1'] == '2'){

                $SQL=mysql_query("SELECT patient_details.*,patient_details.id as gg,inouttime_nurse.*,patient_details.status as fff,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,
                nurse_assign.id as bbb,nurse_assign.c_date,nurse_assign.job_started,nurse_assign.status AS DDD,nurse_assign.is_completed,nurse_assign.re_assign FROM patient_details
                  LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
                 LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id
         
                  WHERE nurse_assign.status='1' AND nurse_assign.is_completed !='1' AND nurse_assign.job_started !='1' ORDER BY patient_details.id  DESC  
                  
                  ");
  

            }elseif($_GET['representative1'] == '3'){

                $SQL=mysql_query("SELECT patient_details.*,patient_details.id as gg,inouttime_nurse.*,patient_details.status as fff,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,
                nurse_assign.id as bbb,nurse_assign.c_date,nurse_assign.job_started,nurse_assign.status AS DDD,nurse_assign.is_completed,nurse_assign.re_assign FROM patient_details
                  LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
                 LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id
         
                  WHERE nurse_assign.status='1' AND nurse_assign.is_completed !='1' AND nurse_assign.job_started ='1' ORDER BY patient_details.id DESC  
                  
                  ");
   
            }elseif($_GET['representative1'] == '4'){

                $SQL=mysql_query("SELECT patient_details.*,patient_details.id as gg,inouttime_nurse.*,patient_details.status as fff,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,
                nurse_assign.id as bbb,nurse_assign.c_date,nurse_assign.job_started,nurse_assign.status AS DDD,nurse_assign.is_completed,nurse_assign.re_assign FROM patient_details
                  LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
                 LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id
         
                  WHERE nurse_assign.status='1' AND nurse_assign.is_completed ='1' AND nurse_assign.job_started ='1' ORDER BY patient_details.id DESC  
                  
                  ");
//    $Y=mysql_fetch_object($SQL);
//    print_r($Y);exit();

            }elseif($_GET['representative1'] == '5'){

                $SQL=mysql_query("SELECT patient_details.*,patient_details.id as gg,inouttime_nurse.*,patient_details.status as fff,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,
                nurse_assign.id as bbb,nurse_assign.c_date,nurse_assign.job_started,nurse_assign.status AS DDD,nurse_assign.is_completed,nurse_assign.re_assign FROM patient_details
                  LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
                 LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id
         
                  WHERE nurse_assign.re_assign ='1' ORDER BY patient_details.id DESC  
                  
                  ");
//  $Y=mysql_fetch_object($SQL);
//  print_r($Y);exit();
            }
        }
	
		while($Y=mysql_fetch_object($SQL)){	

            $intime=$Y->intime;
            $outtime=$Y->outtime;
            $is_completed=$Y->is_completed;
            $DDD=$Y->DDD;
            $fff=$Y->fff;
            $job_started=$Y->job_started;
            $gg=$Y->gg;
            $bbb=$Y->bbb;
            $re_assign=$Y->re_assign;





			// print_r($Y);exit();
		// $DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");$DRCNT=mysql_fetch_object($DR);
		// $CHY=mysql_query("SELECT COUNT(*)style="text-align:right" AS CHEMIST FROM tbl_customer_master WHERE rep_id='".$Y->R."'");$CHYCNT=mysql_fetch_object($CHY);
	?>
							<tr class="amma">
							<td style="text-align:center"><?=$p; ?></td>
							
							<td><?=$Y->patient_name; ?></td>
							<td ><?=$Y->contact_person; ?></td>
							<td><?=$Y->phone_no; ?></td>
                            <td ><?=$Y->address; ?></td>
							<td><?=$Y->location; ?></td> 
							<td ><?=$Y->disease_name; ?></td>
							<td><?=$Y->patient_details; ?></td>

                            <td><?php if($job_started =='1' && $is_completed !='1'){
                                echo "ONGOING";
                                ?>
                                 
                                <?php }elseif($DDD =='1' && $is_completed =='0' && $job_started =='0'){
                                      echo "ASSIGNED";
                                    ?>

                                    <?php }elseif($DDD ==''){
                                      echo "NA";
                                    ?>

                                    <?php }elseif($is_completed =='1' && $job_started =='1'){ 
                                          echo "COMPLETED";
                                        ?>

                                        <?php }elseif($re_assign =='1'){
                                      echo "REASSIGNED";
                                    ?>

                                    <?php }
                                        
                                        ?>
                            
                            
                            
                            </td>
							

                            <td><?php if($intime =='0'){
                              
                                ?>
                                 <button type="button" ><a href="assign_report.php?id=<?php echo $Y->bbb;?>">
                              REASSIGN</a>
                                  </button>
                                <?php }elseif($DDD =='1' && $is_completed =='0'){
                                      
                                    ?>
                                    <button type="button" ><a href="assign_report.php?id=<?php echo $Y->bbb;?>">
                              REASSIGN</a>
                                  </button>
                                    <?php }elseif($DDD ==''){
                                     
                                    ?>
                                    <button type="button" >   <a href="report_assign.php?id=<?php echo $Y->gg;?>">
                                            ASSIGN
                                                </button>
                                    <?php }elseif($is_completed !='0' ){ 
                                        
                                        ?>
                                        <button type="button" >   <a href="report_assign.php?id=<?php echo $Y->gg;?>">
                                            ASSIGN
                                                </button>
                                        <?php 
                                        
                                    }elseif($re_assign =='1'){
                                       
                                      ?>
  <button type="button" ><a href="assign_report.php?id=<?php echo $Y->bbb;?>">
                              REASSIGN</a>
                                  </button>
                                      <?php }?>
                            
                            
                            
                            </td>
                           
<!-- 
<td><button type="button" >   <a href="report_assign.php?id=<?php echo $Y->id;?>">
                                            ASSIGN
                                                </button></td> -->

						
							</tr>
    <?php $p++;} ?>
</tbody>
</table>
<div id="y" style="height:auto"></div>
<?php
	$_GET["from_date"] = str_replace("/","-",$_GET["from_date"]);
	$_GET["to_date"] = str_replace("/","-",$_GET["to_date"]);
	$DCTOT=mysql_query("SELECT COUNT(*) AS DC FROM doctors WHERE rep_id='".$_GET["representative1"]."' AND c_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."'");
	$DCNTOT=mysql_fetch_object($DCTOT);


if(isset($_GET["daily_cmts"])){



function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
}




	$date=$_GET["wp_date"];
	$date_split=explode("/",$date);
	$dates=$date_split[2]."-".$date_split[1]."-".$date_split[0];	

    if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
        $SQL=mysql_query("SELECT tbl_customer_master.shop_name as name,tbl_customer_master.pincode as pincode,tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,(select dr_latitude from doctors where id=tbl_work_plan.wp_dc_id) as dr_latitude,(select dr_longitude from doctors where id=tbl_work_plan.wp_dc_id) as dr_longitude,latitude,longitude FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_rep_id='".$_GET["representative1"]."' AND tbl_work_plan.reporteddate='".$dates."' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='C'");
    } else {
	   $SQL=mysql_query("SELECT doctors.doctor_name as name,doctors.doc_pincode as pincode,tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,(select dr_latitude from doctors where id=tbl_work_plan.wp_dc_id) as dr_latitude,(select dr_longitude from doctors where id=tbl_work_plan.wp_dc_id) as dr_longitude,latitude,longitude FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='".$_GET["representative1"]."' AND tbl_work_plan.reporteddate='".$dates."' AND doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='D'");
    }

	echo "<h3>REP REPORTED COMMENTS @ ".$_GET["wp_date"]."</h3>";
	while($R=mysql_fetch_object($SQL)){
?>
<p style="padding:5px; border:1px solid #00CCFF; background:#CCCCCC">
    <strong><?php echo $R->name."-".$R->pincode; ?></strong>
    <strong style="float: right;">
        <?php if($R->latitude!='' && $R->longitude!='' && $R->dr_latitude!='' && $R->dr_longitude!=''){ ?>
        <a href="latandlong.php?dlat=<?=$R->dr_latitude; ?>&dlong=<?=$R->dr_longitude; ?>&alat=<?=$R->latitude; ?>&along=<?=$R->longitude; ?>" target="_blank">
        <?php $DISTANCE = calculateDistance($R->dr_latitude, $R->dr_longitude, $R->latitude, $R->longitude); if($DISTANCE>0.5){ echo "<span style='color:red'><strong>".$DISTANCE." KM</strong></span>"; }if($DISTANCE<=0.5){ echo $DISTANCE." KM"; }?>
        </a>
        <?php } ?>
    </strong>
</p>
<p><?php echo $R->drunavailablereason; ?></p>
<p><?php echo "TIME : ".$R->reportedtime; ?></p>
<?php	
	
	}
}
if(isset($_GET["doctor_Unassign"])){

	mysql_query("UPDATE doctors SET rep_assign=0 WHERE id IN (".$_GET["pin"].")");
	echo "Multiple Doctor Unassigned";
}
if(isset($_GET["unassign_doctor"])){
	$SQL=mysql_query("SELECT * FROM doctors WHERE rep_assign=0 AND doctor_name<>'' ORDER BY doctor_name");
	$CNT=mysql_num_rows($SQL);
	if($CNT>0){
	echo "<input type='text' placeholder='search' onkeyup='filterValue(this.value)' style='width:200px;'>";		
?>
<h3>UNASSIGN REPRESENTATIVE <-> DOCTOR </h3>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
	<thead><th>Sl.No</th><th>Select</th><th>Doctor Name</th><th>Specilist</th><th>Qualification</th><th>Doctor Address</th></thead>
    <tbody>
    
<?php 
    $y=1;
    while($BABA=mysql_fetch_object($SQL)){   
    
?>	
	<tr class="yuvi">
	<td><?=$y; ?></td>
    <td><input type="checkbox" name="doctors[]" value="<?=$BABA->id; ?>"></td>            
    <td><?=$BABA->doctor_name; ?></td>
    <td><?=$BABA->doc_specilist_id; ?></td><td><?=$BABA->doc_qualification; ?></td><td><?=$BABA->doctor_addrs; ?></td></tr>
<?php $y++;} ?>

<tr><td colspan="6" style="text-align:right"><a href="#" id="doctor_assign"><img src="img/man259.png" width="64" height="64" onclick="yuvaraj()"></a></td></tr>
</tbody>        
</table>
<?php
	}	
}if(isset($_GET["repc"])){	
	$SQL=mysql_query("SELECT master_pincode.pincode,  master_pincode.pin_id, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp`,master_pincode WHERE rep_id = '".$_GET["rep_id"]."' and `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."') and master_pincode.pin_id=areawise_temp.pin_id GROUP BY areawise_temp.pin_id");
?>
<style>#pincode tr:nth-child(odd){background: #cccccc;}#pincoded tr:nth-child(odd){background: #cccccc;}</style>
<table class="table table-bordered" id="representative1">
<thead><tr><th style="background:#00B300;color:#FFFFFF">PINCODE</th><th style="background:#00B300;color:#FFFFFF">CUSTOMERS</th><th style="background:#00B300;color:#FFFFFF">PRODUCTS</th><th style="background:#00B300;color:#FFFFFF">PTR</th><th style="background:#00B300;color:#FFFFFF">PTS</th></tr></thead>
<tbody>
<?php	
	while($R=mysql_fetch_object($SQL)){
	?>
		<tr class="REPCP"><td class="reppin" hidden><?= $R->rep_id;?></td><td><a style="color:#000000" href="javascript:yuvaraj('<?php echo $R->pin_id; ?>','<?php echo $_GET["rep_id"] ?>','<?php echo $_GET["from_date"] ?>','<?php echo $_GET["to_date"] ?>');"><?php $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$R->pincode."' LIMIT 1"); $A=mysql_fetch_object($AREA); echo $R->pincode." - ".strtoupper($A->area_name);?></a></td><td><?=$R->CUST;?></td><td><?=$R->PROD;?></td><td><?=$R->PTR;?></td><td><?=$R->PTS;?></td></tr>
	<?php }
?>
</tbody>
</table>
<?php
}
if(isset($_GET["repcd"])){
$SQL=mysql_query("SELECT tbl_customer_master.shop_name,areawise_temp.pro_name,dist_id,SUM(quantity) AS Q,SUM(free_quantity) AS F,SUM(replace_quantity) AS R,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp`,tbl_customer_master WHERE areawise_temp.rep_id = '".$_GET["rep_id"]."' and areawise_temp.pin_id='".$_GET["pin_id"]."' and `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."') and areawise_temp.our_cust_id=tbl_customer_master.id  GROUP BY areawise_temp.pin_id,areawise_temp.our_product_id,areawise_temp.dist_id,areawise_temp.our_cust_id");
?>
<table class="table table-bordered" id="representative1">
<thead><tr><th style="background:#00B300;color:#FFFFFF">CHEMIST</th><th style="background:#00B300;color:#FFFFFF">DISTRIBUTOR</th><th style="background:#00B300;color:#FFFFFF">PRODUCT</th><th style="background:#00B300;color:#FFFFFF">Q</th><th style="background:#00B300;color:#FFFFFF">F</th><th style="background:#00B300;color:#FFFFFF">R</th><th style="background:#00B300;color:#FFFFFF">PTR</th><th style="background:#00B300;color:#FFFFFF">PTS</th></tr></thead>
<tbody>
<?php while($R=mysql_fetch_object($SQL)){ $DIST=mysql_query("SELECT dis_name FROM distributor WHERE dis_id='".$R->dist_id."'"); $D=mysql_fetch_object($DIST); ?>
	<tr><td><?= $R->shop_name;?></td><td><?= $D->dis_name;?></td><td><?= $R->pro_name;?></td><td><?= $R->Q;?></td><td><?= $R->F;?></td><td><?= $R->R;?></td><td><?=$R->PTR;?></td><td><?=$R->PTS;?></td></tr>
<?php } ?>
</tbody>
</table>
<?php 
}


if(@$_REQUEST['condition']=='area_merging'){
    $sql=mysql_query("SELECT * FROM pincode_list WHERE pin_id=".$_REQUEST['pin_id']);
    while($row=mysql_fetch_array($sql)){ ?>
    <div style="margin:5px"><input type="checkbox" name="area_name[]" value="<?php echo $row['id']; ?>" >&nbsp;&nbsp;<?php echo $row['area_name']; ?></div>
<?php
    }
}


if(@$_REQUEST['condition']=='show_pro_grouping'){
    $json=array();
    $sql=mysql_query("SELECT slv_product FROM product_grouping WHERE mst_product='".$_REQUEST['pro_id']."'");
    while ($row=mysql_fetch_array($sql)) {
        $json[]=$row['slv_product'];
    }
    echo json_encode($json);
}


if(@$_REQUEST['condition']=='specialist_grouping'){
    $json=array();
    $sql=mysql_query("SELECT product,product_type FROM specialist_grouping WHERE specialist='".$_REQUEST['specialist']."'");
    while ($row=mysql_fetch_array($sql)) {
        if($row['product_type']=='1'){
            $json['mst_pro'][]=$row['product'];
        } else {
            $json['slv_pro'][]=$row['product'];
        }
    }
    echo json_encode($json);
}


if(@$_REQUEST['condition']=='map_daily_report'){ 

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
}
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <?php $sql=mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST['rep_id']."'"); $row=mysql_fetch_array($sql); ?>
            <h3>Daily Representative Report (<?php echo $row['rep_name']; ?>) (<?php echo date('d-m-Y'); ?>)</h3>
        </div>
        <div class="modal-body" style="height:510px;">
            <table class="table table-striped table-bordered">
                <tr>
                    <th style="text-align:center">S.NO</th>
                    <th style="text-align:center">CLIENT</th>
                    <th style="text-align:center">MOBILE NUMBER</th>
                    <th style="text-align:center">ADDRESS</th>
                    <th style="text-align:center">LATITUDE</th>
                    <th style="text-align:center">LONGTITUDE</th>
                    <th style="text-align:center">REPORT DATETIME</th>
                    <th style="text-align:center">DISTANCE</th>
                </tr>
                <?php
                    $i=1;
                    $sql1=mysql_query("SELECT clinetcreation.name as client, clinetcreation.pincode as pincode, clinetcreation.address as address, clinetcreation.mobileno as mobileno, reorting.remarks, reorting.latt, reorting.longg, reorting.reporteddate, reorting.reportedtime,clinetcreation.latts,clinetcreation.longgs FROM reorting,clinetcreation WHERE attendance='1' AND reorting.repid='".$_REQUEST['rep_id']."' AND reorting.reporteddate=CURDATE()");
                    if(mysql_num_rows($sql1)>0){
                    while($row1=mysql_fetch_array($sql1)){        
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $i; ?></td>
                    <td style="text-align:center"><?php echo $row1['client'].' ('.$row1['pincode'].')'; ?></td>
                    <td style="text-align:center"><?php echo $row1['mobileno']; ?></td>
                    <td style="text-align:center"><?php echo $row1['address']; ?></td>
                    <td style="text-align:center"><?php echo $row1['latt']; ?></td>
                    <td style="text-align:center"><?php echo $row1['longg']; ?></td>
                    <td style="text-align:center"><?php echo $row1['reporteddate'].' '.$row1['reportedtime']; ?></td>
                    <td>
                        <?php if($row1['latt']!='' && $row1['longg']!='' && $row1['latts']!='' && $row1['longgs']!=''){ ?>
                        <a href="latandlong.php?dlat=<?=$row1['latts']; ?>&dlong=<?=$row1['longgs']; ?>&alat=<?=$row1['latt']; ?>&along=<?=$row1['longg']; ?>" target="_blank">
                        <?php $DISTANCE = calculateDistance($row1['latts'], $row1['longgs'], $row1['latt'], $row1['longg']); if($DISTANCE>0.5){ echo "<span style='color:red'><strong>".$DISTANCE." KM</strong></span>"; }if($DISTANCE<=0.5){ echo $DISTANCE." KM"; }?>
                        </a>
                        <?php } else { echo "0 KM"; } ?>
                    </td>
                </tr>
                <?php $i++;}} else { echo "<tr><td colspan='8'>No data available in table</td></tr>"; } ?>
            </table>                    
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
    </div>
</div>
<?php } ?>