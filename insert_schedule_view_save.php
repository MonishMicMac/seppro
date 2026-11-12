<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
  $command=$_POST['command'];
  ?>
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
<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
<?php
  if(isset($_REQUEST['repid']))
  { ?>
<div class="pull-right">
                  <div class="col-xs-12">
                  <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                   <!-- <input type="text" placeholder="Search" class="form-control pull-right" id="filter" onclick="filter_call()">-->
                  </div>
                </div>
         <table  class="table table-striped table-bordered bootstrap-datatable" width="100%">
<thead>
<tr>

  <th style="text-align:center">SI NO</th>
  <th style="text-align:center">Docter Name</th>
   <th style="text-align:center">Specialist</th>
   <th style="text-align:center">Area Name</th>
   <th style="text-align:center">Pincode</th>
   <th style="text-align:center">Phone No</th>
  <th style="text-align:center">Select</th>
  
</tr>
</thead>   
<tbody>
  
  <?php 
    $p=1; 

        $SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pin_id=doctors.doc_pin_id GROUP BY pin_id) as area_name,doctor_name,doc_pincode,doc_specilist_id,doc_contact_no,id FROM doctors WHERE rep_id='".$_REQUEST['repid']."'");
    // $SQL=mysql_query("SELECT * from doctors WHERE rep_id='".$_REQUEST['repid']."'");
    while($Y=mysql_fetch_object($SQL)){     
    
      ?>
     <tr ><td ><?php echo $p; ?></td>
      <td ><?php echo $Y->doctor_name; ?></td> 
       <td ><?php echo $Y->doc_specilist_id; ?></td>  
        <td ><?php echo $Y->area_name; ?></td>  
         <td ><?php echo $Y->doc_pincode; ?></td>  
          <td ><?php echo $Y->doc_contact_no; ?></td>  
                 
       <td>
          <input type="checkbox" name="checkbox[]"  id="checkbox"  class="checkbox" value="<?php echo $Y->id;?>">               
                <label for="#"></label>
            </td>  
     </tr>

   
    <?php $p++;} ?>
</tbody>
</table> 
<?php
} 

if($command=='scheduled')
{
  $wp_rep_id=$_REQUEST['rep_name'];

$wp_date=$_REQUEST['from_date'];
  $did=$_REQUEST['checkbox'];
  // print_r($did);
   $proid1 = implode(",",$did);
     $proid = explode(",",$proid1);
     // print_r($proid1);
   // exit();
  for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM  tbl_work_plan WHERE wp_rep_id = '".$wp_rep_id."' AND wp_dc_id = '".$proid[$i]."' and wp_date = '".date("Y-m-d",strtotime($wp_date))."' ")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO tbl_work_plan(wp_rep_id,wp_dc_id,attendancestatus,wp_date,c_date,c_time,wp_dc)VALUES('".$wp_rep_id."','".$proid[$i]."','0','".date("Y-m-d",strtotime($wp_date))."','".$c_date."','".$c_time."','D')")or die(mysql_error());
     }
}
 echo "<script type=text/javascript>alert('Assigned Successfully');window.location='insert_schedule_view.php';</script>";
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
<?php
}
?>