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
// $fun = new select1;
// $res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
// $( "#from_date" ).datepicker({
// changeMonth: true,
// changeYear: true,
// yearRange: "1990:2020",
// dateFormat:"yy/mm/dd"
// });
// $( "#to_date" ).datepicker({
// changeMonth: true,
// changeYear: true,
// yearRange: "1990:2020",
// dateFormat:"yy/mm/dd"
// });
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
              <h2><i class="icon-user"></i>REP VISIT RECORD</h2>
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
                   <td><select id="rep_name" name="rep_name" class="rep_name" data-rel="chosen">
                    <option value="">--Select--</option>
                    <?php
                    $res=mysql_query("SELECT * FROM representative");
                    while($row_res=mysql_fetch_array($res)) {
                      $rep_name1=$row_res['rep_name'];
                      $id=$row_res['id'];
                      ?>
                      <option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
                      <?php } ?> 
                    </select><script>document.thisForm.rep_name.value="<?php if($_REQUEST['rep_name']!='') { echo $_REQUEST['rep_name']; } else { echo $_REQUEST["representative"]; } ?>"</script></td>
                    <?php } ?>
                    <td><Label>Month &amp; Year</label></td>
                    <td>:</td>
                    <td><input type="text" name="from_date" id="from_date" value="<?php if($_REQUEST['from_date']!='') { echo $_REQUEST['from_date']; } else { echo @$_REQUEST["month_year"]; } ?>" readonly/></td>
                    <!-- <td></td> -->
                <!-- <td><label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="one" value="nooff" >
           Define Offer 
         </label></td> -->
         <td><input type="button" name="submit" id="submit" value="REPORT" class="btn btn-primary" ></td>
         <td></td>
         <td style="width:10%;"></td>
         <td></td>
         <td></td>
         <td style="width:10%;"></td>
         <td></td>
         <td></td>
       </tr>
     </table>
       <!--  <table style="width:100%;">
    <tr>
        <td style="width:10%;"><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td style="width:10%;"><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td style="width:10%;"><input type="submit"  name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
  </table> -->
</form>
</div><br>
<?php if(@$_REQUEST["submit"]=="REPORT"){ 

  if($_REQUEST['from_date']!='')
  {   
  $_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
  $MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
  $R_MDATE=mysql_fetch_object($MDATE);
    }
    else
    {
  $_REQUEST["month_year"]=date("Y-m",strtotime($_REQUEST["month_year"]))."-01";
  $MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["month_year"]."',interval 0 month)) LastDay");
  $R_MDATE=mysql_fetch_object($MDATE);
    }
  ?>
  
  <div class="span12">
  <center>
  <div class="control-group"> 
    <div class="controls"> 
    <div class="span1">
     <label class="radio">
       <input type="radio" class="rad css-checkbox" name="check" id="one" value="All"<?php if($_REQUEST['doctor_checking']=='All') { ?>checked="checked" <?php } else {?>checked="checked"<?php } ?>>
       All 
     </label>
     </div>
     <div class="span2">
     <label class="radio">
       <input type="radio" class="rad css-checkbox" name="check" id="two" value="Regular visit"<?php if($_REQUEST['doctor_checking']=='Regular visit') { ?>checked="checked" <?php } ?>> 
       Regular visit
     </label>
     </div>
     <div class="span2">
     <label class="radio">
       <input type="radio" class="rad css-checkbox" name="check" id="three" value="Surgery"<?php if($_REQUEST['doctor_checking']=='Surgery') { ?>checked="checked" <?php } ?>> 
       Surgery
     </label> 
     </div>        
   </div>
 </div> 
 </center>
 </div>

<?php if($_REQUEST['doctor_checking']=="All") { ?>
 <div style='float:right; width: 50px;'><a href="rep_visit_record_excel1.php?month_year=<?php echo @$_REQUEST["month_year"]; ?>&representative=<?php echo @$_REQUEST["representative"]; ?>&doctor_checking=<?php echo @$_REQUEST["doctor_checking"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
 <?php 
  } 
 elseif($_REQUEST['doctor_checking']=="Regular visit")
  {
  ?>
<div style='float:right; width: 50px;'><a href="rep_visit_record_excel1.php?month_year=<?php echo @$_REQUEST["month_year"]; ?>&representative=<?php echo @$_REQUEST["representative"]; ?>&doctor_checking=<?php echo @$_REQUEST["doctor_checking"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<?php 
} 
elseif($_REQUEST['doctor_checking']=="Surgery")
{
?>
 <div style='float:right; width: 50px;'><a href="rep_visit_record_excel1.php?month_year=<?php echo @$_REQUEST["month_year"]; ?>&representative=<?php echo @$_REQUEST["representative"]; ?>&doctor_checking=<?php echo @$_REQUEST["doctor_checking"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
 <?php 
   } 
 else 
 {
  ?>
<div style='float:right; width: 50px;'><a href="rep_visit_record_excel1.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
 <?php 
 }
 ?>
 <br/>
 <div class="box-content">
  <h2>LIST OF CUSTOMER</h2>
  <table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
      <tr>
       <th style="text-align:center">S.NO</th>
       <th hidden></th><th style="text-align:center">Doctor Name</th>
       <th style="text-align:center">Hospital Name</th>
       <th style="text-align:center">AREA</th>
       <th style="text-align:center">Visit Days</th>
       <th style="text-align:center">NO Of Count</th>
      <?php
      if($_REQUEST['doctor_checking']=="Surgery") 
      { 
     ?>
      <th>Tray Details</th>
      <th >No.of Cares</th>
      <th >Values</th>
      <th >Action</th>
      <?php
       }
       ?> 
     </tr>
   </thead>   
   <tbody>
     <?php	
     $p=1;	
     if($_REQUEST['doctor_checking']=="All")
     {
      $SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
     }
     elseif ($_REQUEST['doctor_checking']=="Regular visit") 
     {
      $SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
     }

     elseif ($_REQUEST['doctor_checking']=="Surgery") 
     {
      $SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
     }
     else
     {

      $SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");

     }
     
     while($Y=mysql_fetch_object($SQL)){	
      $pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
      $pinarea_res=mysql_fetch_object($pinarea);
  
      if($_REQUEST['doctor_checking']=="All")
     {
          $visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
      $visitcount_res=mysql_fetch_object($visitcount);
     }
     elseif ($_REQUEST['doctor_checking']=="Regular visit") 
     {
       $visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')  AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
      $visitcount_res=mysql_fetch_object($visitcount);
     }

     elseif ($_REQUEST['doctor_checking']=="Surgery") 
     {
        $visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')  AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
      $visitcount_res=mysql_fetch_object($visitcount);
     }
     else
     {
    $visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
      $visitcount_res=mysql_fetch_object($visitcount);

     }

      ?>
      <tr class="amma"><td style="text-align:center"><?=$p; ?></td>
       <td hidden><?php echo $_REQUEST["rep_name"]; ?> </td>
       <td hidden class="doctor_id"><?php echo $Y->id; ?> </td>
       <td hidden><?php echo $_REQUEST["from_date"]; ?> </td>
       <td hidden><?php echo $_REQUEST["to_date"]; ?> </td>
       <td ><?php echo $Y->doctor_name; ?></td>
              <td ><?php echo $Y->doc_hospital_clinic_name; ?></td>
       <td ><?php echo $pinarea_res->area_name; ?></td>
       <td ><?php if($_REQUEST['doctor_checking']=="All")
     {
        $cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
				// while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_res=mysql_fetch_object($cldate);
     }
     elseif ($_REQUEST['doctor_checking']=="Regular visit") 
     {
     $cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
				// while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_res=mysql_fetch_object($cldate);
     }

     elseif ($_REQUEST['doctor_checking']=="Surgery") 
     {
          $cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate,reporteddate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
				// while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_res=mysql_fetch_object($cldate);
     }
     else
     {

         $cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
				// while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_res=mysql_fetch_object($cldate);

     }

					// $Visitdate=date("Y-m-d",strtotime($cldate_res->reporteddate));					
         echo $cldate_res->rpdate;					
				// }								
         ?></td>
         <td><?php  echo $visitcount_res->clid; ?></td>
         <?php 
          if($_REQUEST['doctor_checking']=="Surgery") 
          { 
          $doc=mysql_query("SELECT * from tbl_work_plan where wp_dc_id='".$Y->id."' AND reporteddate='".$cldate_res->reporteddate."'");
          $doc_res=mysql_fetch_array($doc);
         ?>
         <td>
         <div class="control-group">
         <div class="controls">
         <input class="input-xsmall focused" type="text" name="tray_details" id="tray_details" value="<?php echo $doc_res['tray_details']; ?>" style="width: 106px;">
         </div>
         </div>
         </td>
         <td>
         <div class="control-group">
         <div class="controls">
         <input class="input-xsmall focused" type="text" name="cares" id="cares" value="<?php echo $doc_res['cares']; ?>" style="width: 106px;">
         </div>
         </div>
         </td>
         <td>
         <div class="control-group">
         <div class="controls">
         <input class="input-xsmall focused" type="text" name="values_info" id="values_info" value="<?php echo $doc_res['values_info']; ?>"style="width: 106px;">
         </div>
         </div>
         </td>
         <td>
         <div class="control-group">
         <div class="controls">
      <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $Y->id;?>">
      <input type="hidden" name="tbl_id" id="tbl_id" value="<?php echo $doc_res['wp_id'];?>">
       <input type="submit" name="submit" class="btn btn-info edit" value="Submit">
       <input type="reset" value="Reset" class="btn btn-danger delete">
         </div>
         </div>
         </td>
         <?php 
          }
         ?>
        </tr>
     <?php $p++;} ?>
     </tbody>
   </table>  


 </div>   <hr style="border:1px solid #317eac;height: 0px;">
 <?php } ?>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').dataTable();


  });
  $('.amma').click(function(){
// alert("hi");
$.get("autosearch-y/rep_reporting_booking.php?customervisit=yuvi&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&client="+$(this).closest('tr').find('td:eq(2)').text()+"&clientdate="+$(this).closest('tr').find('td:eq(3)').text()+"&clienttodate="+$(this).closest('tr').find('td:eq(4)').text()+"",function(data){
			// alert(data);
			$("#consolidated1").html(data);
		});	

});

  $(".rad").change(function () {
 var checking = $(this).val();
 //var rep = $('.rep_name').val();
 var rep = $('#rep_name').val();
 //alert(rep);
 var month_year = $('#from_date').val();
 window.location="rep_visit_record_new1.php?doctor_checking="+checking+"&representative="+rep+"&month_year="+month_year+"&submit=REPORT";
 });


$("#submit").click(function () {
 var checking = "All";
 var rep = $('#rep_name').val();
 //alert(rep);
 var month_year = $('#from_date').val();
 window.location="rep_visit_record_new1.php?doctor_checking="+checking+"&representative="+rep+"&month_year="+month_year+"&submit=REPORT";
 });

$('.edit').click(function(){
	// alert($('#tbl_id').val());
var did = $('#tbl_id').val();
var tray = $('#tray_details').val();
var cares = $('#cares').val();
var info = $('#values_info').val();

$.post("doctor_update_ajax.php?doctor_id="+did+"&tray="+tray+"&cares="+cares+"&values_info="+info+"&doctor=up",function(data){
  alert(data);
       if(data=="success")
       {
        alert("Updated Sucessfully");
        //window.location="rep_visit_record_new1.php";
       }
    }); 
});

$('.delete').click(function(){
  $('.amma').find('input:text').val('');
});

</script>
</body>
</html>
<?php
}
?>
