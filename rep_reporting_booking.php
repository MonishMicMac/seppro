<?php
	include("connect_db.php");

	$link = mysql_connect(DB_HOST, DB_USER,DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0); 
	?>
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
	<?php
	if(isset($_GET["customerwise"])){	
		$DR=mysql_query("SELECT * FROM representative WHERE id='".$_GET["rep"]."'");$DRCNT=mysql_fetch_object($DR);
	
		$SQL=mysql_query("SELECT DISTINCT(doc_pin_id) AS pincd FROM doctors WHERE id IN(SELECT DISTINCT(client_id) AS clid FROM pobbooking1 WHERE repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."' )");

		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - AREA COVERED</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PINCODE</th><th style="text-align:center">AREA</th></tr>
</thead> 
<tbody> 
<input type="hidden" name="clientdate" class="clientdate" id="clientdate" value="<?php echo $_GET["daterep"]; ?>" /> 
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

		$SQL1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(client_id) AS clid FROM pobbooking1 WHERE repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."' ) aND drorchemist='DOCTOR'");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - DOCTOR BOOKING</h2>";
		$dr=1;
?>
<table id="exampledoc" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">BOOKED PRODUCT</th><th style="text-align:center">BOOKING TIME</th></tr>
</thead> 
<tbody>  
<?php while($MR1=mysql_fetch_object($SQL1)){ 
	
	$SQL2=mysql_query("SELECT count(productid) AS pdid,client_id,ctime FROM pobbooking1 WHERE client_id='".$MR1->id."' AND repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."'   ");
	$MR2=mysql_fetch_object($SQL2);
?>
	<tr class="docusesamp"><td style="text-align:center"><?=$dr; ?></td>
		<td hidden><?php echo $MR2->client_id; ?></td>
			<td hidden><?php echo $_GET["rep"]; ?></td>
				<td hidden><?php echo $_GET["daterep"]; ?> </td>
				<td><?=$MR1->drorchemist.'_'.$MR1->doctor_name.'_'.$MR1->doc_pincode; ?></td>    
<td style="text-align:center"><?php echo $MR2->pdid; ?></td>
<td style="text-align:center"><?php echo $MR2->ctime; ?></td></tr>

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
		$SQLc1=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id IN (SELECT DISTINCT(client_id) AS clid FROM pobbooking1 WHERE repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."' ) aND drorchemist='SHOP'");
		echo mysql_error();
		
		echo "<h2>".$DRCNT->rep_name." - CHEMIST BOOKING</h2>";
		$drc=1;
?>
<table id="examplechm" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">CUSTOMER</th><th style="text-align:center">BOOKED PRODUCT</th><th style="text-align:center">BOOKING TIME</th></tr>
</thead> 
<tbody>  
<?php while($MRc1=mysql_fetch_object($SQLc1)){ 

	$SQLc2=mysql_query("SELECT count(productid) AS pdid,client_id,ctime FROM pobbooking1 WHERE client_id='".$MRc1->id."' AND repid='".$_GET["rep"]."' AND cdate='".$_GET["daterep"]."'  ");
	$MRc2=mysql_fetch_object($SQLc2);
	
	
	// echo $MRc1->id;?>
	<tr class="chmusesamp"><td style="text-align:center"><?=$drc; ?></td>
		<td hidden><?php echo $MRc2->client_id; ?></td>
			<td hidden><?php echo $_GET["rep"]; ?></td>
				<td hidden><?php echo $_GET["daterep"]; ?> </td>
				<td><?=$MRc1->drorchemist.'_'.$MRc1->doctor_name.'_'.$MRc1->doc_pincode; ?></td>   
    <td style="text-align:center"><?php echo $MRc2->pdid; ?></td>
<td style="text-align:center"><?php echo $MRc2->ctime; ?></td></tr>
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

		$.get("autosearch-y/rep_reporting_booking.php?usesample=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
			$("#docterprductusesample").html(data);
		});	
		// $.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
		// 	$("#consolidated").html(data);
		// });		
	});
$('.chmusesamp').click(function(){

		$.get("autosearch-y/rep_reporting_booking.php?usesamplechm=yuvi&cldid="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmid="+$(this).closest('tr').find('td:eq(2)').text()+"&datepro="+$(this).closest('tr').find('td:eq(3)').text()+"",function(data){
			
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

$SQLc1sg=mysql_query("SELECT sum(qty) AS Q,productid,client_id,status FROM pobbooking1 WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."'  GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTl->doctor_name." -DOCTOR BOOKED PRODUCT</h2>";
		$drsg=1;
?>
<table id="exampledoc1" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th><th style="text-align:center">QUANTITY</th><th style="text-align:center">SELECT</th></tr>
</thead> 
<tbody>  
<?php while($MR1sg=mysql_fetch_object($SQLc1sg)){ 
	
	$SQL2sg=mysql_query("SELECT * FROM product WHERE id='".$MR1sg->productid."' ");
	$MR2sg=mysql_fetch_object($SQL2sg);

	?>
	<tr class="docusesamp"><td style="text-align:center"><?=$drsg; ?></td>
		<td hidden><?php echo $MR1sg->client_id; ?></td>
			<td hidden><?php echo $_GET["repnmid"]; ?></td>
				<td hidden><?php echo $_GET["datepro"]; ?> </td>
    <td style="text-align:center"><?php echo $MR2sg->pro_name; ?></td>	
				<td style="text-align:center"><?php echo $MR1sg->Q; ?></td>
			<td >
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox"  value="<?php echo $MR2sg->id;?>" <?php if($MR1sg->status=='1'){ ?> checked <?php }elseif($MR1sg->status=='0'){ ?> unchecked <?php }?>><input type="hidden" name="clientiddoc" class="clientiddoc" id="clientiddoc" value="<?php echo $MR1sg->client_id; ?>" />                  
                <label for="#"></label>
            </td></tr>
<?php			
			$drsg++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
	<script type="text/javascript">

	$('.checkbox').click(function(){
		if(this.checked == true){
			alert('1');
		$.get("autosearch-y/rep_reporting_booking.php?prosts=yuvi&cldidsts="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmidsts="+$(this).closest('tr').find('td:eq(2)').text()+"&dateprosts="+$(this).closest('tr').find('td:eq(3)').text()+"&prodidsts="+$(this).val()+"",function(data){		
		// alert(data);	
		});	
		}
		if(this.checked == false) { 
			// alert('2');
			$.get("autosearch-y/rep_reporting_booking.php?prosts1=yuvi&cldidsts="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmidsts="+$(this).closest('tr').find('td:eq(2)').text()+"&dateprosts="+$(this).closest('tr').find('td:eq(3)').text()+"&prodidsts="+$(this).val()+"",function(data){	
			// alert(data);			
		});	
		}

	});

</script>	
<?php
	}
	if(isset($_GET["prosts"])){
		// echo "UPDATE pobbooking1 SET status='1' WHERE  client_id='".$_GET["cldidsts"]."' AND repid='".$_GET["repnmidsts"]."' AND cdate='".$_GET['dateprosts']."' AND productid='".$_GET['prodidsts']."'";
		mysql_query("UPDATE pobbooking1 SET status='1' WHERE  client_id='".$_GET["cldidsts"]."' AND repid='".$_GET["repnmidsts"]."' AND cdate='".$_GET['dateprosts']."' AND productid='".$_GET['prodidsts']."'")or die(mysql_error());

	}
	if(isset($_GET["prosts1"])){
		// echo "UPDATE pobbooking1 SET status='0' WHERE  client_id='".$_GET["cldidsts"]."' AND repid='".$_GET["repnmidsts"]."' AND cdate='".$_GET['dateprosts']."' AND productid='".$_GET['prodidsts']."'";
		mysql_query("UPDATE pobbooking1 SET status='0' WHERE  client_id='".$_GET["cldidsts"]."' AND repid='".$_GET["repnmidsts"]."' AND cdate='".$_GET['dateprosts']."' AND productid='".$_GET['prodidsts']."'")or die(mysql_error());

	}

	if(isset($_GET["usesamplechm"])){
		// echo "SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id='".$_GET['cldid']."'  AND drorchemist='SHOP'";
		$DRlchm=mysql_query("SELECT id,doctor_name,doc_pincode,drorchemist FROM doctors WHERE id='".$_GET['cldid']."'  aND drorchemist='SHOP'");
		echo mysql_error();
		$DRCNTlchm=mysql_fetch_object($DRlchm);
		
	
$SQLc1sgchm=mysql_query("SELECT sum(qty) AS Q,productid,client_id,status FROM pobbooking1 WHERE client_id='".$_GET['cldid']."' AND repid='".$_GET["repnmid"]."' AND cdate='".$_GET["datepro"]."'  GROUP BY productid ");
		echo mysql_error();
		
		
		echo "<h2>".$DRCNTlchm->doctor_name." -CHEMIST BOOKED PRODUCT</h2>";
		$drsgchm=1;
?>
<table id="exampledoc2" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center">PRODUCT NAME</th><th style="text-align:center">QUANTITY</th><th>Select</th></tr>
</thead> 
<tbody>  
<?php while($MR1sgchm=mysql_fetch_object($SQLc1sgchm)){ 
	
	$SQL2sgchm=mysql_query("SELECT * FROM product WHERE id='".$MR1sgchm->productid."' ");
	$MR2sgchm=mysql_fetch_object($SQL2sgchm);

	?>
	<tr class="docusesamp1"><td style="text-align:center"><?=$drsgchm; ?></td>
		<td hidden><?php echo $MR1sgchm->client_id; ?></td>
			<td hidden><?php echo $_GET["repnmid"]; ?></td>
				<td hidden><?php echo $_GET["datepro"]; ?> </td>
    <td style="text-align:center"><?php echo $MR2sgchm->pro_name; ?></td>	
				<td style="text-align:center"><?php echo $MR1sgchm->Q; ?></td>
				<td >
          <input type="checkbox" name="checkbox1[]"  id="checkbox1" class="checkbox1" value="<?php echo $MR2sgchm->id;?>" <?php if($MR1sgchm->status=='1'){ ?> checked <?php }elseif($MR1sgchm->status=='0'){ ?> unchecked <?php }?>> <input type="hidden" name="clientidchm" class="clientidchm" id="clientidchm" value="<?php echo $MR1sgchm->client_id; ?>" />                 
                <label for="#"></label>
            </td>
				 </tr>
<?php			
			$drsgchm++;}
?>
</tbody>
</table>
<hr style="border:1px solid #73a839;height: 0px;">
<script type="text/javascript">

	$('.checkbox1').click(function(){
		if(this.checked == true){
			alert($(this).val());
		$.get("autosearch-y/rep_reporting_booking.php?prostschm=yuvi&cldidsts1="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmidsts1="+$(this).closest('tr').find('td:eq(2)').text()+"&dateprosts1="+$(this).closest('tr').find('td:eq(3)').text()+"&prodidsts1="+$(this).val()+"",function(data){		
		// alert(data);	
		});	
		}
		if(this.checked == false) { 
			// alert('4');
			$.get("autosearch-y/rep_reporting_booking.php?prostschm1=yuvi&cldidsts1="+$(this).closest('tr').find('td:eq(1)').text()+"&repnmidsts1="+$(this).closest('tr').find('td:eq(2)').text()+"&dateprosts1="+$(this).closest('tr').find('td:eq(3)').text()+"&prodidsts1="+$(this).val()+"",function(data){	
			// alert(data);			
		});	
		}

	});

</script>
<?php
	}
if(isset($_GET["prostschm"])){
		// echo "UPDATE pobbooking1 SET status='1' WHERE  client_id='".$_GET["cldidsts1"]."' AND repid='".$_GET["repnmidsts1"]."' AND cdate='".$_GET['dateprosts1']."' AND productid='".$_GET['prodidsts1']."'";
		mysql_query("UPDATE pobbooking1 SET status='1' WHERE  client_id='".$_GET["cldidsts1"]."' AND repid='".$_GET["repnmidsts1"]."' AND cdate='".$_GET['dateprosts1']."' AND productid='".$_GET['prodidsts1']."'")or die(mysql_error());

	}
	if(isset($_GET["prostschm1"])){
		// echo "UPDATE pobbooking1 SET status='0' WHERE  client_id='".$_GET["cldidsts1"]."' AND repid='".$_GET["repnmidsts1"]."' AND cdate='".$_GET['dateprosts1']."' AND productid='".$_GET['prodidsts1']."'";
		mysql_query("UPDATE pobbooking1 SET status='0' WHERE  client_id='".$_GET["cldidsts1"]."' AND repid='".$_GET["repnmidsts1"]."' AND cdate='".$_GET['dateprosts1']."' AND productid='".$_GET['prodidsts1']."'")or die(mysql_error());

	}
if(isset($_REQUEST["clientid"])){
	 $year1=date("Y",strtotime($_REQUEST["fromdate"]));
 $month1=date("m",strtotime($_REQUEST["fromdate"]));

	$repid = $_REQUEST['clientid'];
foreach($repid as $repids)
{

	$d=mysql_query("SELECT * from targetachievemneet where cusid='".$repids."'");
$count_d=mysql_num_rows($d);
	if($count_d==0) 
	{
	  mysql_query("INSERT INTO targetachievemneet(cusid,assignid,month,year,targetamount,cdate,ctime)VALUES('".$repids."','0','".$month1."','".$year1."','".$_REQUEST['amounttar']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
	}
	else
	{
		mysql_query("UPDATE targetachievemneet SET month='".$month1."',year='".$year1."',targetamount='".$_REQUEST['amounttar']."',cdate='".date('Y-m-d')."',ctime='".date('H:i:s')."' WHERE  cusid='".$repids."'")or die(mysql_error());	
	}
 }
}
 if(isset($_REQUEST["custometlisttarget"])){



	
?>

<br/>
<div class="box-content">
<h2>LIST OF CUSTOMER</h2>
<table  class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>

	<th style="text-align:center">SI NO</th>
	<th style="text-align:center">Doctor Name</th>
	<th style="text-align:center">Pincode</th>
	<th style="text-align:center">Area Name</th>
	<th style="text-align:center">Type</th>
	<th style="text-align:center">Amount</th>
	<th style="text-align:center">Select</th>
	
</tr>
</thead>   
<tbody>
	
	<?php	
		$p=1;	

				
		$SQL=mysql_query("SELECT * from doctors where  rep_id='".$_REQUEST['rep']."' ");
		while($Y=mysql_fetch_object($SQL)){			
		
		$areacov=mysql_query("SELECT * FROM targetachievemneet WHERE cusid ='".$Y->id."' ");	
			$areacov_res=mysql_fetch_object($areacov);
			$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
			$pinarea_res=mysql_fetch_object($pinarea);
			?>
		 <tr ><td ><?php echo $p; ?></td>
		 	<td ><?php echo $Y->doctor_name; ?></td>
		 		<td style="text-align:center"><?php echo $Y->doc_pincode; ?></td>		
		 		<td style="text-align:center"><?php echo $pinarea_res->area_name; ?></td>	
		 		<td style="text-align:center"><?php echo $Y->drorchemist; ?></td>	
		 		<td style="text-align:center"><?php echo $areacov_res->targetamount; ?></td>	 	
		 	 <td class="hidden-480">
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $Y->id;?>">  
          <input type="hidden" name="repidname" class="repidname" id="repidname" value="<?php echo $_REQUEST['rep_name']; ?>" /> 
	<input type="hidden" name="yeartar" class="yeartar" id="yeartar" value="<?php echo $year1; ?>" /> 
	<input type="hidden" name="monthtar" class="monthtar" id="monthtar" value="<?php echo $month1; ?>" /> 
	<input type="hidden" name="amounttar" class="amounttar" id="amounttar" value="<?php echo $_REQUEST['amount']; ?>" />          
                <label for="#"></label>
            </td>  
		 </tr>

   
    <?php $p++;} ?>
</tbody>
</table>  


</div> 
<?php
}

 if(isset($_REQUEST["customervisit"])){

// $_GET["clientdate"]=date("Y-m",strtotime($_GET["clientdate"]))."-01";
// $MDATE = mysql_query("select LAST_DAY(date_add('".$_GET["clientdate"]."',interval 0 month)) LastDay");
// $R_MDATE=mysql_fetch_object($MDATE);

	
?>

<br/>
<div class="box-content">
<h2>VISIT CUSTOMER</h2>
<table  class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>

	<th style="text-align:center">SI NO</th>
	<th style="text-align:center">Date</th>
	<th style="text-align:center">Pincode</th>
	<th style="text-align:center">Area Name</th>
	<th style="text-align:center">Type</th>
	<th style="text-align:center">Type Of Calls</th>
	
	
</tr>
</thead>   
<tbody>
	
	<?php	
		$p=1;	
	
$visitcount=mysql_query("SELECT reporteddate,jointworkby from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_GET["clientdate"]))."' AND '".date("Y-m-d",strtotime($_GET	["clienttodate"]))."') AND `wp_rep_id`='".$_GET['rep']."' AND wp_dc_id='".$_GET['client']."' AND attendancestatus='1' ");	

		while($visitcount_res=mysql_fetch_object($visitcount)){			
		$SQL=mysql_query("SELECT * from doctors where`id`='".$_GET['client']."'  ");
		$Y=mysql_fetch_object($SQL);
		$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
			$pinarea_res=mysql_fetch_object($pinarea);
			?>
		 <tr ><td ><?php echo $p; ?></td>
		 	<td ><?php echo $visitcount_res->reporteddate; ?></td>
		 		<td style="text-align:center"><?php echo $Y->doc_pincode; ?></td>		
		 		<td style="text-align:center"><?php echo $pinarea_res->area_name; ?></td>	
		 		<td style="text-align:center"><?php echo $Y->drorchemist; ?></td>	
		 		<td style="text-align:center"><?php  if($visitcount_res->jointworkby=='0') { echo "INDIVIDUAL"; } else { $SQL1=mysql_query("SELECT * from doctors where`id`='".$visitcount_res->jointworkby."'  ");	$Y1=mysql_fetch_object($SQL1); echo "Joint Work With".'('.$Y1->doctor_name.')';  } ?></td>	 	
		 	
		 </tr>

   
    <?php $p++;} ?>
</tbody>
</table>  


</div> 
<?php
}



?>
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