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
	
 if(isset($_REQUEST["custometlistexcel"])){

?>

<br/>
 <div style='float:right; width: 50px;'><a href="customers_list_excel.php?repid=<?php echo @$_REQUEST["rep"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<div class="box-content" >
<table class="table table-striped table-bordered bootstrap-datatable datatable" >
<thead>
<tr>
<th>S.NO</th>
<th>DR NAME</th>
<th>NEW/EX</th>
<th>PLACE</th>
<th>CNT NO</th>
<th>DOB</th>
<th>EMAIL</th>
<th>QUALIFICATION</th>
<th>SPECIALITY</th>
<th>GENDER</th>
<th>ADDRESS</th>
</tr>
</thead>   
<tbody>
<?php
$i=1;

if($_REQUEST['rep']=='')
{
	
$res=mysql_query("SELECT * FROM doctors WHERE doctor_name!='' ");
}
else{
$res=mysql_query("SELECT * FROM doctors WHERE doctor_name!='' AND rep_id='".$_REQUEST['rep']."'");
}
while($row_res=mysql_fetch_array($res)){

$sql=mysql_query("SELECT area_name FROM pincode_list WHERE pin_id='".$row_res['doc_pin_id']."' order by id asc limit 1");
$row=mysql_fetch_array($sql);

?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $row_res['doctor_name']; ?></td>
<td><?php echo "DISPENCY"; ?></td>
<td><?php echo $row['area_name']; ?></td>
<td><?php echo $row_res['doc_contact_no']; ?></td>
<td><?php echo $row_res['dob']; ?></td>
<td><?php echo $row_res['email']; ?></td>
<td><?php echo $row_res['doc_qualification']; ?></td>
<td><?php echo $row_res['doc_specilist_id']; ?></td>
<td><?php echo $row_res['doc_gender']; ?></td>
<td><?php echo $row_res['doctor_addrs']; ?></td>
</tr>
<?php
$i++;
}
?>

</tbody>
</table>            
</div>


<?php
}

 if(isset($_REQUEST["repleavelist"])){

?>

<br/>
 <div style='float:right; width: 50px;'><a href="customers_list_excel.php?repid=<?php echo @$_REQUEST["rep"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<div class="box-content" >
<table class="table table-striped table-bordered bootstrap-datatable datatable" >
<thead>
<tr>
<th>S.NO</th>
<th>REP NAME</th>
<th>Date</th>
<th>Reasion</th>

</tr>
</thead>   
<tbody>
<?php
$i=1;
echo "SELECT * FROM repgivenasleave WHERE repid='".$_REQUEST['rep']."' AND (date between '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') AND expenses LIKE '%leave%'";

$res=mysql_query("SELECT * FROM repgivenasleave WHERE repid='".$_REQUEST['rep']."' AND (date between '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') AND expenses LIKE '%leave%'");

while($row_res=mysql_fetch_array($res)){


?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $row_res['repid']; ?></td>
<td><?php echo $row_res['date']; ?></td>
<td><?php echo $row_res['reason']; ?></td>

</tr>
<?php
$i++;
}
?>

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