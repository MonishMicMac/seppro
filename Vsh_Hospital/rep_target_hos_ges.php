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

  if(isset($_REQUEST['qasave'])=='Confirm')
  {
   $ai=0;
   foreach ($_REQUEST['hos_id'] as $hosid) {
       // echo "INSERT INTO mst_target_assign(target_assign_rep_id,target_assign_hos_id,target_assign_value,target_assign_month_year)VALUES('".$_REQUEST['rep_name']."','".$hosid."','".$_REQUEST['amt'][$ai]."','".$_REQUEST['from_date']."')";
    $d1=mysql_query("select * from mst_target_assign where target_assign_rep_id='".$_REQUEST['rep_name']."'   AND target_assign_hos_id='".$hosid."' AND target_assign_month_year='".date('Y-m',strtotime($_REQUEST['from_date']))."' ");
    $count_d1=mysql_num_rows($d1);
    if($count_d1==0) {
      mysql_query("INSERT INTO mst_target_assign(target_assign_rep_id,target_assign_hos_id,target_assign_value,target_assign_month_year,target_assign_c_date,target_assign_c_time)VALUES('".$_REQUEST['rep_name']."','".$hosid."','".$_REQUEST['amt'][$ai]."','".date('Y-m',strtotime($_REQUEST['from_date']))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());
    }
    else
    {
     mysql_query("UPDATE mst_target_assign SET target_assign_value='".$_REQUEST['amt'][$ai]."',target_assign_c_date='".date('Y-m',strtotime($_REQUEST['from_date']))."',target_assign_c_time='".date('H:i:s')."' WHERE target_assign_rep_id='".$_REQUEST['rep_name']."'   AND target_assign_hos_id='".$hosid."' AND target_assign_month_year='".date('Y-m',strtotime($_REQUEST['from_date']))."'")or die(mysql_error());
   }

   $ai++;
 }


    // exit();
}
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
              <h2><i class="icon-user"></i>REP Target Assign</h2>
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
                      <!-- <td></td> -->
                <!-- <td><label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="one" value="nooff" >
           Define Offer 
         </label></td> -->
         <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
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
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
  $ffdate=$_REQUEST["from_date"];
  $_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
  $MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
  $R_MDATE=mysql_fetch_object($MDATE);
  ?>
<!--  <div class="control-group"> 
    <div class="controls"> 
       <label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="one" value="nooff" >
           Define Offer 
       </label>
       <label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="two" value="off"> 
           General Offer
       </label>       
    </div>
  </div> --> 
  <!-- <div style='float:right; width: 50px;'><a href="rep_visit_record_excel5.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
  <br/>
  <div class="box-content">
    <h2>LIST OF Hospital</h2>
    <form name="thisForm1" action="" method="post">
      <input type="hidden" name="rep_name" id="rep_name" value="<?php echo @$_REQUEST["rep_name"]; ?>" readonly/>
      <input type="hidden" name="from_date" id="from_date" value="<?php echo @$ffdate; ?>" readonly/>
      <input type="hidden" name="submit" id="submit" value="REPORT" readonly/>
      <table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
        <thead>
          <tr>
           <th style="text-align:center">S.NO</th>
           <th hidden></th><th hidden></th>
           <th style="text-align:center">Name</th>
           <th style="text-align:center">Target</th>


         </tr>
       </thead>   
       <tbody>
         <?php	
         $p=1;	

         $SQL=mysql_query("SELECT * from Hospitalname where rep_id='".$_REQUEST['rep_name']."' AND hos_name!='' And doctor_id!='0' ORDER BY hos_name ASC");
         while($Y=mysql_fetch_object($SQL)){	
          $r1=mysql_query("select * from mst_target_assign where target_assign_rep_id='".$_REQUEST['rep_name']."'  AND target_assign_hos_id='".$Y->id."' AND target_assign_month_year='".date('Y-m',strtotime($_REQUEST['from_date']))."'  ");
          $r1_res = mysql_fetch_array($r1);

          ?>
          <tr class="amma"><td style="text-align:center"><?=$p; ?></td>
           <td hidden><input type="text" name="hos_id[]" value="<?php echo $Y->id; ?>"></td>
           <td ><?php echo $Y->hos_name  ; ?></td>

           <td ><input type="text" name="amt[]" value="<?php echo $r1_res['target_assign_value']; ?>"></td>
         </tr>


         <?php $p++;} ?>
       </tbody>
     </table>  

     <center>
      <div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="qasave btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
    </center>
  </form>
</div>   <hr style="border:1px solid #317eac;height: 0px;">
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

  $(".css-checkbox").click(function () {
    if ($(this).attr('id') == "one") {
     alert("hi");
     $("#example").load();          

   } else {

   }
 });



</script>
</body>
</html>
<?php
}
?>
