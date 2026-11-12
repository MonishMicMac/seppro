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
  if(isset($_REQUEST['managerid']))
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
  <th style="text-align:center">Representative Name</th>
   <!--<th style="text-align:center">Specialist</th>
   <th style="text-align:center">Area Name</th>
   <th style="text-align:center">Pincode</th>
   <th style="text-align:center">Phone No</th>-->
  <th style="text-align:center">Select</th>
  
</tr>
</thead>   
<tbody>
  
  <?php 
    $p=1; 

     $SQL=mysql_query("select id,rep_name from representative");
    
	$check='';
    while($Y=mysql_fetch_object($SQL)){     
	
	$man=mysql_query("select * from assigningreptomanager where managerid='".$_REQUEST['managerid']."'");
	while($fetch_man=mysql_fetch_object($man))
	{
	  $manvalues[] = $fetch_man->repid;
	}
	$count=mysql_num_rows($man);
	if($count>0)
	{
	$check = (in_array($Y->id,$manvalues) ? "checked=checked" : '' ); 
    ?>
     <tr><td><?php echo $p; ?></td>
      <td><?php echo $Y->rep_name; ?></td> 
     <td>
          <input type="checkbox" name="rep[]"  id="<?php echo $Y->id;?>"  class="checkbox" value="<?php echo $Y->id;?>" <?php echo $check;?>>               
                <label for="<?php echo $Y->id;?>"></label>
            </td>  
     </tr>
     <?php } else { ?>
     
     <tr><td><?php echo $p; ?></td>
      <td><?php echo $Y->rep_name; ?></td> 
        
       <td>
          <input type="checkbox" name="rep[]"  id="rep"  class="checkbox" value="<?php echo $Y->id;?>">               
                <label for="#"></label>
            </td>  
     </tr>
     
   
    <?php } $p++;} ?>
</tbody>
</table> 
<?php
} 

if(isset($_REQUEST['submit']))
{
  $manager_id=$_REQUEST['manager_name'];
  $rep_id=$_REQUEST['rep'];
  
  mysql_query("DELETE from assigningreptomanager where managerid='$manager_id'");
  for($i=0;$i<count($rep_id);$i++)
   { 
     mysql_query("INSERT INTO assigningreptomanager(managerid,repid)VALUES('".$_REQUEST['manager_name']."','".$rep_id[$i]."')")or die(mysql_error());
 }
 echo "<script type=text/javascript>alert('Assigned Successfully');window.location='manager_setup.php';</script>";
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