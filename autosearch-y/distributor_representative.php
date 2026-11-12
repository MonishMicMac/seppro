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


if(isset($_GET["daily_report"])){
?>

<div style='float:right; width: 50px;'><a href="distributor_rep_daily_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["representative1"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<br />
<br />

<table class="table table-striped table-bordered bootstrap-datatable datatable" id="summary">
    	<tr>
            <th>Date</th>
            <th>From Place</th>
            <th>To Place</th>
            <th>Type</th>
            <th>extra kilometer allowance</th>
            <th>Onward Kilometer</th>
            <th>Onward Fare</th>
            <th>Return Kilometer</th>
            <th>Total Fare</th>
            <th>Designation</th>
            <th>Expense wage Amount</th>
           
        </tr>
<?php
// if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
// 	$rep_daily=mysql_query("SELECT * FROM tbl_work_plan  WHERE wp_rep_id='".$_GET["representative1"]."' AND wp_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' and wp_dc='C' GROUP BY wp_date ORDER BY wp_date desc");	
// } else {
//     $rep_daily=mysql_query("SELECT * FROM tbl_work_plan  WHERE wp_rep_id='".$_GET["representative1"]."' AND wp_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' and wp_dc='D' GROUP BY wp_date ORDER BY wp_date desc");
// }


//    $rep_daily=mysql_query("SELECT representative.*,representative.address as res_address,
//    repgivenasleave.*,repgivenasleave.date AS res_date,repgivenasleave.expenses as exp,repgivenasleave.km_allowance as km_alance,
//    km_calc.*,km_calc.from_place
//    from repgivenasleave
//    LEFT JOIN representative ON representative.rep_id=repgivenasleave.repid
//    LEFT JOIN km_calc ON km_calc.rep_id=representative.rep_id
//    WHERE representative.rep_id='".$_GET["representative1"]."'
//     ")or die(mysql_error());
$from=$_GET["from_date"];
$to=$_GET["to_date"];

// print_r($_GET["from_date"]);
// $rep_daily=mysql_query("SELECT repgivenasleave.*,repgivenasleave.date as search_date,representative.*,
// km_calc.*
// From repgivenasleave  
// LEFT JOIN km_calc ON repgivenasleave.km_calc_id=km_calc.id
// LEFT JOIN representative on representative.id=km_calc.id
// WHERE repgivenasleave.repid='".$_GET["representative1"]."'
// AND repgivenasleave.date BETWEEN '".
// $_GET["from_date"]."'AND '".$_GET["to_date"]."' ORDER BY  repgivenasleave.date DESC
// ")or die(mysql_error());

$rep_daily=mysql_query("SELECT repgivenasleave.*,repgivenasleave.date as search_date,representative.designation,km_calc.*,
representative.id,rep_hq_wages,rep_ex_wages,rep_out_wages
From repgivenasleave  
LEFT JOIN km_calc ON repgivenasleave.km_calc_id=km_calc.id
LEFT JOIN representative on representative.id=repgivenasleave.repid
WHERE repgivenasleave.repid='".$_GET["representative1"]."'
AND repgivenasleave.leaveapplieddate BETWEEN '".
$_GET["from_date"]."'AND '".$_GET["to_date"]."' ORDER BY  repgivenasleave.date DESC
")or die(mysql_error());




    while($REPDAILY=mysql_fetch_object($rep_daily)){
//    print_r($REPDAILY);exit();

    $Search_date=$REPDAILY->search_date;
   $leave_empty= '-';
  $designation=$REPDAILY->designation;
    $status=$REPDAILY->expenses;

	?>
        <tr>
        <td><?=$REPDAILY->leaveapplieddate; ?></td>
        <td><?=$REPDAILY->from_place; ?></td>
        <td><?=$REPDAILY->district; ?></td>
        <td><?=$REPDAILY->expenses; ?></td>
        <td><?=$REPDAILY->km_allowance; ?></td>
        <td><?=$REPDAILY->onward_km; ?></td>
        <td><?=$REPDAILY->onward_km_fare; ?></td>
        <td><?=$REPDAILY->return_km; ?></td>
        <td><?=$REPDAILY->total_wages; ?></td>
        <td><?=$REPDAILY->designation; ?></td>
        <td><?php if($status=="local"){?>
            <?=$REPDAILY->rep_hq_wages; ?>
       <?php
        }?>
        <?php if($status=="exstation"){?>
            <?=$REPDAILY->rep_ex_wages; ?>
       <?php
        }?>
        <?php if($status=="outstation"){?>
         <?=$REPDAILY->rep_out_wages; ?>
       <?php
        }?>
        <?php if($status=="leave"){?>
         <?=$leave_empty; ?>
       <?php
        }?>
      
    </td>
         
        </tr>    
	<?php	
	}
?>
</table>
<?php
	// $_GET["from_date"] = str_replace("/","-",$_GET["from_date"]);
	// $_GET["to_date"] = str_replace("/","-",$_GET["to_date"]);
	// $DCTOT=mysql_query("SELECT COUNT(*) AS DC FROM doctors WHERE rep_id='".$_GET["representative1"]."' AND c_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."'");
	// $DCNTOT=mysql_fetch_object($DCTOT);
}
?>

   
</div>
