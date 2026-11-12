<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
include("include/select.php");
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {

    $('#from_date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });

//ajax Starts
$("#search_box").keypress(function(){
    var from_date =$("#from_date").val();
    var to_date    =$("#to_date").val();
    var content =$("#search_box").val();
    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
    $.get(url,function(data,status){
        $("#search").html(data);
    });
});
//ajax Ends
});
</script>
<style>
 .ui-datepicker-calendar {
   display: none;
 }
</style>

	
</head>

<body>
<!-- topbar starts -->
<?php include("include/header.php"); ?>
<!-- topbar ends -->
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>

<noscript>
<div class="alert alert-block span10">
</div>
</noscript>

<div id="content" class="span10">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Expenses Report</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">
    	<table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td>Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen">
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
				<?php } ?>
                <td><Label>Month &amp; Year</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
                
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td>
            </tr>
        </table>
   <!--      <center>
         <div style='float:right; width: 50px;'><a href="expenses_rep_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"></a></div>
     </center> -->
    </form>
</div><br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
	?>
	     <center>
         <div style='float:right; width: 50px;'><a href="expenses_rep_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
     </center>
	<?php
$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

	
?>
<!--  <div style='float:right; width: 50px;'><a href="expenses_rep_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
    <br/>
<br/>
<div class="box-content">
<h2>Expense Details</h2>
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
	<th hidden></th><th style="text-align:center">Date</th>
	<th style="text-align:center">AREA COVERED</th>
	<th style="text-align:center">KMS</th>
	<th style="text-align:center">ALLOWANCE</th>
	<th style="text-align:center">CLAIMABLE FARE</th>

</tr>
</thead>   
<tbody>
	<?php	

// $sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
// $aqq=mysql_fetch_array($sqlsqq);
// $wages=$aqq['rep_hq_wages'];


		$p=1;	
		$totexp=0;
		$sqlsqq=mysql_query("SELECT rep_hq_wages,(rep_ex_wages+rep_out_wages) AS outstrep FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_object($sqlsqq);


$Daysperiod=mysql_query("select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."' ");
while($D=mysql_fetch_object($Daysperiod)){	 ?>


			 <tr class="amma"><td style="text-align:center;width:5%;"><?=$p; ?></td>
			 	<td style="width:10%;text-align:center;"><?php echo date("Y-m-d",strtotime($D->selected_date)); ?></td> <?php		
	// echo "SELECT GROUP_CONCAT(wp_dc_id) as pids,GROUP_CONCAT(latitude) as latitude,GROUP_CONCAT(longitude) as longitude FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND attendancestatus='1' AND wp_rep_id='".$_REQUEST['rep_name']."' AND latitude!='0' AND longitude!='0' AND latitude!='0.0' AND longitude!='0.0'";
			
		$sqls=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) as pids,GROUP_CONCAT(latitude) as latitude,GROUP_CONCAT(longitude) as longitude FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND attendancestatus='1' AND wp_rep_id='".$_REQUEST['rep_name']."' AND latitude!='0' AND longitude!='0' AND latitude!='0.0' AND longitude!='0.0'")or die(mysql_error());
		$a=mysql_fetch_object($sqls); 

		if($a->pids=='')
		{ ?>
		
			<td style="width:20%;text-align:center;"><?php echo "no visit"; ?></td>
			<td style="width:10%;text-align:center;"><?php echo "0 KM"; ?></td>
			<td style="width:10%;text-align:center;"><?php echo "0"; ?></td>
			<td style="width:10%;text-align:center;"><?php echo "0"; ?></td>
			<?php
	
		
		}

		if($a->pids!='')
		{
			// echo "amma";
		 $totexp=$totexp+$aqq->rep_hq_wages;
		 // echo "SELECT GROUP_CONCAT(doc_pin_id) as pinid FROM doctors where id IN(".$a->pids.")";
		$sqlsq=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) as pinid FROM doctors where id IN(".$a->pids.")")or die(mysql_error());
			$aq=mysql_fetch_object($sqlsq);


			$sqlsqs=mysql_query("SELECT GROUP_CONCAT(area_name) as areaname FROM pincode_list where pin_id IN(".$aq->pinid.")")or die(mysql_error());
			$aqs=mysql_fetch_object($sqlsqs);
			
			// $sqlsqslalo=mysql_query("SELECT GROUP_CONCAT(dr_latitude) as dr_latt,GROUP_CONCAT(dr_longitude) as dr_long FROM doctors where id IN(".$a->pids.") AND dr_latitude!='0' AND dr_longitude!='0' AND dr_latitude!='0.0' AND dr_longitude!='0.0' ")or die(mysql_error());
			// $aqslalo=mysql_fetch_object($sqlsqslalo);
			 if($aqs->areaname=='')
			 { ?>
				<td style="width:20%;text-align:center;"><?php echo "no Area name"; ?></td>
			 	
			 	<?php
			 }
			 else
			 { 	?>
			<td style="width:20%;text-align:center;"><?php echo $aqs->areaname; ?></td>
		
			<?php
			}	
			 // echo $a->latitude;
			 // echo $a->longitude;
			  
				//  if($a->latitude!='' && $a->longitude!='' && $aqslalo->dr_latt!='' && $aqslalo->dr_long!=''){ 
        
    //      echo $DISTANCE = calculateDistance($aqslalo->dr_latt, $aqslalo->dr_long, $a->latitude, $a->longitude);   
			// echo "SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".date("Y-m-d",strtotime($D->selected_date))."'";
				$sql1new=mysql_query("SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".date("Y/m/d",strtotime($D->selected_date))."'");
	$row1new=mysql_fetch_object($sql1new);
	$location=explode(":", $row1new->latandlong);
	$j=1;
	$total=0;
	for ($i=0; $i<count($location)-1; $i++) { 
		if($location[$j]!=''){
    		$loc=explode(",", $location[$i]);
    		$loc1=explode(",", $location[$j]);
    		if(calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1])>0){
    			$total=$total+calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1]);
    		}
    		$j++;
		}
	}
	
       
         ?>
        <td style="width:10%;text-align:center;"><?php echo $total." KM"; ?></td>
			 
		<td style="width:10%;text-align:center;"><?php  $sqlsqsnew=mysql_query("SELECT station FROM stationplanforrep where pinid IN(".$aq->pinid.") GROUP BY station")or die(mysql_error());
		$aqsnew=mysql_num_rows($sqlsqsnew);
		if($aqsnew=='1')
		{
			$aqsnew=mysql_fetch_object($sqlsqsnew); if($aqsnew->station=='local') { echo $totall=$aqq->rep_hq_wages; } elseif($aqsnew->station=='out') { echo $totall=$aqq->outstrep; } }
			elseif($aqsnew=='2') { echo $totall=$aqq->outstrep; }
			else { echo $totall=$aqq->rep_hq_wages; } ?></td>

			
			<?php
				$wag=$wag+$totall;
			
			$cl_exp=mysql_query("SELECT sum(fareamount) AS clfare FROM expenses where reporteddate='".date("Y-m-d",strtotime($D->selected_date))."' AND repid='".$_REQUEST['rep_name']."'")or die(mysql_error());
			$cl_exp_row=mysql_fetch_object($cl_exp);
			if($cl_exp_row->clfare!='')
			{
			?>
					<td style="width:10%;text-align:center;"><?php echo $cl_exp_row->clfare; ?></td>
					<?php
					$clwag=$clwag+$cl_exp_row->clfare;
				}
				else
				{
					?>
					<td style="width:10%;text-align:center;"><?php echo "0"; ?></td>
					<?php
				}
		}
		?>
	</tr>
		<?php
	$p++;

}


?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td style="width:10%;text-align:center;"><?php echo "Total - ".$wag; ?></td>
<td style="width:10%;text-align:center;"><?php echo "Total - ".$clwag; ?></td></tr>
<!-- $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");

	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totexp); -->
	
<?php
		// $SQL=mysql_query("SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,IFNULL((select targetamount from targetachievemneet where cusid=doctors.id AND month='".date("m",strtotime($from_date))."' AND year='".date("Y",strtotime($from_date))."'),'No target') as area_name FROM doctors WHERE rep_assign='".$_REQUEST['rep_name']."' ORDER BY id DESC");
		// while($Y=mysql_fetch_object($SQL)){	
		
		//         $sql1=mysql_query("SELECT productid,qty FROM pobbooking1 where client_id='".$Y->id."' AND cdate BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'");
		// $pr=0;
		// while($row1=mysql_fetch_object($sql1))
		// {	

 	// 	 $sqlpr=mysql_query("SELECT pro_mrp FROM product where id='".$row1->productid."'");
		// 	$rowpr=mysql_fetch_object($sqlpr);
				

		// 	$rt=$row1->qty*$rowpr->pro_mrp;

		// $pr=($pr+$rt);
			
		// }
		
			?>
<!-- 		 <tr class="amma"><td style="text-align:center"><?=$p; ?></td>
		 	
		 	<td ><?php echo $Y->doctor_name; ?></td>
		 	<td ><?php echo $Y->drorchemist; ?></td>
		 	<td ><?php echo $Y->area_name ?></td>
		 	<td ><?php  echo $pr; ?></td>
		 		</tr> -->

   
    <?php 
    // $p++;} ?>
</tbody>
</table>  


</div> 
<!-- <hr style="border:1px solid #317eac;height: 0px;"> -->
<?PHP } ?>
<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated1"></div>  
<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated"></div>      
</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>

<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-tour.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.chosen.min.js"></script>
<script src="js/jquery.uniform.min.js"></script>
<script src="js/jquery.colorbox.min.js"></script>
<script src="js/jquery.cleditor.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/jquery.elfinder.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>	

</body>
</html>
<?php
}
?>
